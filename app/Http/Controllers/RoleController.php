<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('utilisateurs.view');
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('utilisateurs.create');
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('utilisateurs.create');
        $request->validate([
            'name' => 'required',
        ]);

        Role::create($request->all());
        return redirect()->route('admin.role.index')->with('success', 'Role cree avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('utilisateurs.view');
        $role = Role::findOrFail($id);
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('utilisateurs.update');
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('utilisateurs.update');
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required',
        ]);

        $role->update($request->all());
        return redirect()->route('admin.role.index')->with('success', 'Role modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('utilisateurs.delete');
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin.role.index')->with('success', 'Role supprime avec succes');
    }

    /**
     * Show permissions for a role.
     */
    public function permissions(Role $role)
    {
        Gate::authorize('utilisateurs.update');
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.role.permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update permissions for a role.
     */
    public function updatePermissions(Request $request, Role $role)
    {
        Gate::authorize('utilisateurs.update');
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.role.index')->with('success', 'Permissions mises a jour avec succes');
    }
}
