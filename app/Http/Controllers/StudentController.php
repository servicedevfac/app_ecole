<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   
        $etudiants = Student::with('parents','classe')->get();

        
        return view('admin.etudiant.index', compact('etudiants'));  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = \App\Models\Parents::all();
        return view('admin.etudiant.create', compact('parents'));   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'date_naissance' => 'required|date|before:today|after:1900-01-01',
            'email' => 'required|email|unique:students,email|max:255',
            'phone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'sexe' => 'required|in:M,F,Homme,Femme',
            'address' => 'required|string|max:500',
            'parent_id' => 'required|exists:parents,id',
            'relation' => 'required|in:mere,pere,frere,soeur,tuteur',
           'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
 $etudiant = Student::create(
        $request->except('photo', 'parent_id', 'relation')
    );

    // 2️⃣ photo
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos/etudiants', 'public');
        $etudiant->update(['photo' => $path]);
    }

    // 3️⃣ relation parent
    $etudiant->parents()->attach($request->parent_id, [
        'relation' => $request->relation,
    ]);

        
        return redirect()->route('admin.etudiant.index')->with('success', 'Eleve ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $etudiant = Student::findOrFail($id);
        $etudiant->load('parents');
        return view('admin.etudiant.show', compact('etudiant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $etudiant = Student::findOrFail($id);
        $parents = \App\Models\Parents::all();
        return view('admin.etudiant.edit', compact('etudiant','parents'));     
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
        'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
        'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
        'date_naissance' => 'required|date|before:today|after:1900-01-01',
        'email' => 'required|email|max:255|unique:students,email,' . $id,
        'phone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
        'sexe' => 'required|in:M,F,Homme,Femme',
        'address' => 'required|string|max:500',
        'parent_id' => 'required|exists:parents,id',
        'relation' => 'required|in:mere,pere,frere,soeur,tuteur',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // ✅ 1️⃣ récupérer l'étudiant existant
    $etudiant = Student::findOrFail($id);

    // ✅ 2️⃣ mise à jour des champs
    $etudiant->update(
        $request->except('photo', 'parent_id', 'relation')
    );

    // ✅ 3️⃣ mise à jour de la photo
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos/etudiants', 'public');
        $etudiant->update(['photo' => $path]);
    }

    // ✅ 4️⃣ mise à jour relation parent
    $etudiant->parents()->sync([
        $request->parent_id => [
            'relation' => $request->relation,
        ],
    ]);

    return redirect()
        ->route('admin.etudiant.index')
        ->with('success', 'Élève modifié avec succès');
    }

    /**
     * Display a listing of the resource.
     */
    public function affectation()
    {
        return view('admin.etudiant.affectation');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function affect(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:students,id',
            'classe_id' => 'required|exists:classes,id',
        ]);
        
        // Update student promotion logic to handle cycle_id, niveau_id, and annee_scolaire_id
        Student::whereIn('id', $request->ids)->update([
            'classe_id' => $request->classe_id,
            'cycle_id' => $request->cycle_id,
            'niveau_id' => $request->niveau_id,
            'annee_scolaire_id' => $request->annee_scolaire_id, 
        ]);
        
        return redirect()->route('admin.etudiant.index')->with('success', 'Eleves promus avec succes');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $etudiant = Student::findOrFail($id);
        $etudiant->delete(); 
        
        return redirect()->route('admin.etudiant.index')->with('success', 'Eleve supprime avec succes');    
    }
}
