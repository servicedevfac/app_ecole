<?php

namespace App\Http\Controllers;

use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EcoleController extends Controller
{
    /**
     * Show the settings for the current school.
     */
    public function settings()
    {
        $ecole = Ecole::findOrFail(auth()->user()->ecole_id);
        return view('admin.ecole.settings', compact('ecole'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Global aggregates for monitoring (Super Admin only)
        $totalSchools = Ecole::count();
        $activeSchoolsCount = Ecole::where('is_active', true)->count();
        $totalStudentsCount = \App\Models\Student::count();
        $newSchoolsCount = Ecole::where('created_at', '>', now()->subDays(30))->count();

        // Paginated list with eager-loaded counts
        $ecoles = Ecole::withCount(['users', 'etudiants', 'enseignants'])
            ->paginate(10);

        return view('admin.ecole.index', compact(
            'ecoles', 
            'totalSchools', 
            'activeSchoolsCount', 
            'totalStudentsCount', 
            'newSchoolsCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ecole.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:ecoles,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'limite_etudiants' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $validated['slug'] = Str::slug($request->nom);

        Ecole::create($validated);

        return redirect()->route('admin.ecole.index')
            ->with('success', 'Établissement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ecole $ecole)
    {
        // Charger les compteurs de ressources pour le monitoring détaillé
        $ecole->loadCount(['users', 'etudiants', 'classes', 'matieres', 'inscriptions', 'enseignants']);
        $ecole->load(['users.roles', 'ecolePayments' => function($query) {
            $query->latest();
        }]);
        
        return view('admin.ecole.show', compact('ecole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ecole $ecole)
    {
        return view('admin.ecole.edit', compact('ecole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ecole $ecole)
    {
        $isSuperAdmin = auth()->user()->hasRole('Super Admin');
        
        $rules = [
            'email' => 'nullable|email|max:255|unique:ecoles,email,' . $ecole->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($isSuperAdmin) {
            $rules['nom'] = 'required|string|max:255';
            $rules['limite_etudiants'] = 'nullable|integer';
            $rules['is_active'] = 'boolean';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($ecole->logo) {
                Storage::disk('public')->delete($ecole->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        if ($isSuperAdmin) {
            $validated['slug'] = Str::slug($request->nom);
        }

        $ecole->update($validated);

        if ($isSuperAdmin) {
            return redirect()->route('admin.ecole.index')
                ->with('success', 'Établissement mis à jour avec succès.');
        }

        return back()->with('success', 'Les informations de l\'établissement ont été mises à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ecole $ecole)
    {
        if ($ecole->logo) {
            Storage::disk('public')->delete($ecole->logo);
        }
        $ecole->delete();

        return redirect()->route('admin.ecole.index')
            ->with('success', 'Établissement supprimé avec succès.');
    }
}
