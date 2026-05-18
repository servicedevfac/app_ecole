<?php

namespace App\Http\Controllers;

use App\Models\Ecole;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('utilisateurs.view');
        $query = User::with('ecole');

        if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
            $query->where('ecole_id', auth()->user()->ecole_id);
        }

        if ($request->has('ecole_id')) {
            $query->where('ecole_id', $request->ecole_id);
        }

        $users = $query->latest()->paginate(10);
        $ecoles = Ecole::get();
        return view('admin.utilisateur.index', compact('users', 'ecoles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('utilisateurs.create');
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where('name', '!=', 'Super Admin')->get();
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $ecoles = Ecole::all();
        } else {
            $ecoles = Ecole::where('id', auth()->user()->ecole_id)->get();
        }
        return view('admin.utilisateur.create', compact('roles', 'ecoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('utilisateurs.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'ecole_id' => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    $role = Role::find($request->role_id);
                    return $role && $role->name !== 'Super Admin';
                }),
                'exists:ecoles,id'
            ],
        ]);

        $ecoleId = $request->ecole_id;

        // Sécurité : Si l'utilisateur n'est pas Super Admin, on force son ecole_id
        if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
            $ecoleId = auth()->user()->ecole_id;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ecole_id' => $ecoleId,
        ]);

        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        return redirect()->route('admin.user.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('utilisateurs.view');
        $query = User::with('ecole');

        if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
            $query->where('ecole_id', auth()->user()->ecole_id);
        }

        $user = $query->findOrFail($id);
        return view('admin.utilisateur.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('utilisateurs.update');
        $roles = Role::all();
        $ecoles = Ecole::all();

        $query = User::query();
        if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
            $query->where('ecole_id', auth()->user()->ecole_id);
        }

        $user = $query->findOrFail($id);
        return view('admin.utilisateur.edit', compact('user', 'roles', 'ecoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('utilisateurs.update');
        $query = User::query();
        if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
            $query->where('ecole_id', auth()->user()->ecole_id);
        }

        $user = $query->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'ecole_id' => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    $role = Role::find($request->role_id);
                    return $role && $role->name !== 'Super Admin';
                }),
                'exists:ecoles,id'
            ],
        ]);

        $data = $request->except(['password', 'password_confirmation', 'role_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $role = Role::findOrFail($request->role_id);
        $user->syncRoles([$role]);

        return redirect()->route('admin.user.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('utilisateurs.delete');
        $query = User::query();
        if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
            $query->where('ecole_id', auth()->user()->ecole_id);
        }

        $user = $query->findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Utilisateur supprimé avec succès');
    }
}
