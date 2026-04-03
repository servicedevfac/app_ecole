<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Facture;
use App\Models\Inscription;
use App\Models\Student;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activeAnnee = \App\Models\Annee_scolaire::where('status', 'actif')->first();
        
        $query = Student::with(['parents', 'inscriptions' => function($q) use ($activeAnnee) {
            if ($activeAnnee) {
                $q->where('annee_scolaire_id', $activeAnnee->id);
            }
        }, 'inscriptions.classe']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('matricule', 'like', "%$search%");
            });
        }

        if ($request->filled('sexe')) {
            $query->where('sexe', $request->sexe);
        }

        if ($request->filled('classe_id')) {
            $query->whereHas('inscriptions', function ($q) use ($request, $activeAnnee) {
                $q->where('classe_id', $request->classe_id);
                if ($activeAnnee) {
                    $q->where('annee_scolaire_id', $activeAnnee->id);
                }
            });
        }

        $etudiants = $query->orderBy('nom')->orderBy('prenom')->get();
        $classes = \App\Models\Classe::orderBy('nom')->get();

        return view('admin.etudiant.index', compact('etudiants', 'classes', 'activeAnnee'));
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
    public function store(StudentRequest $request)
    {
        try {
            DB::beginTransaction();
        $etudiant = Student::create(
            $request->except('photo', 'parent_id', 'parent_nom', 'parent_prenom', 'parent_telephone', 'parent_email', 'parent_adresse', 'relation')
        );

        // 2️⃣ photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos/etudiants', 'public');
            $etudiant->update(['photo' => $path]);
        }

        // 3️⃣ relation parent
        if ($request->filled('parent_id')) {
            $parentId = $request->parent_id;
        } else {
            $parent = \App\Models\Parents::where('telephone', $request->parent_telephone)->first();
            
            if (!$parent && $request->filled('parent_email')) {
                $parent = \App\Models\Parents::where('email', $request->parent_email)->first();
            }

            if (!$parent) {
                $parent = \App\Models\Parents::create([
                    'nom' => $request->parent_nom,
                    'prenom' => $request->parent_prenom,
                    'telephone' => $request->parent_telephone,
                    'email' => $request->parent_email,
                    'adresse' => $request->parent_adresse,
                ]);
            }
            $parentId = $parent->id;
        }   $etudiant->parents()->attach($parentId, [
            'relation' => $request->relation,
        ]);

        DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'élève'. $e->getMessage());
        }
        return redirect()->route('admin.etudiant.index')->with('success', 'Eleve ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ✅ 1️⃣ récupérer l'étudiant existant




        $etudiant = Student::findOrFail($id);

        $inscription = $etudiant->inscriptions()
            ->where('status', 'inscrite')
            ->first();

        $factures = $inscription?->factures ?? collect();

        $etudiant->load([
            'parents',
            'inscriptions.anneeScolaire',
            'inscriptions.cycle',
            'inscriptions.niveau',
            'inscriptions.classe',
            'notes.evaluation.matiere',
        ]);

        return view('admin.etudiant.show', compact('etudiant', 'factures'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $etudiant = Student::findOrFail($id);
        $parents = \App\Models\Parents::all();
        return view('admin.etudiant.edit', compact('etudiant', 'parents'));
    }

    public function update(StudentRequest $request, string $id)
    {

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
