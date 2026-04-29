<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Facture;
use App\Models\Inscription;
use App\Models\Student;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('etudiants.view');
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

        $etudiants = $query->orderBy('nom')->orderBy('prenom')->paginate(10);
        $classes = \App\Models\Classe::orderBy('nom')->get();

        return view('admin.etudiant.index', compact('etudiants', 'classes', 'activeAnnee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('etudiants.create');
        $parents = \App\Models\Parents::all();
        return view('admin.etudiant.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        Gate::authorize('etudiants.create');
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
        }

        $etudiant->parents()->attach($parentId, [
            'relation' => $request->relation,
        ]);

        $parent = \App\Models\Parents::find($parentId);

        // 4️⃣ Création/Récupération automatique du compte utilisateur pour le PARENT
        if (!$parent->user_id) {
            $password = $this->generPassword();
            $userEmail = $parent->email ?? strtolower($parent->nom) . '.' . strtolower($parent->prenom) . "@school-parent.com";
            
            // On vérifie si l'email existe déjà (cas rare où un utilisateur a déjà cet email généré)
            $existingUser = User::where('email', $userEmail)->orWhere('username', $parent->telephone)->first();
            
            if ($existingUser) {
                $user = $existingUser;
            } else {
                $user = User::create([
                    'name'     => $parent->nom . ' ' . $parent->prenom,
                    'username' => $parent->telephone,
                    'email'    => $userEmail,
                    'password' => Hash::make($password),
                    'ecole_id' => $etudiant->ecole_id,
                    'must_change_password' => true,
                ]);
                $user->assignRole('parent');
            }
            
            $parent->update(['user_id' => $user->id]);
        } else {
            $user = $parent->user;
            $password = '******** (Déjà existant)';
        }

        DB::commit();

        return redirect()->route('admin.etudiant.credentials', [
            'id' => $etudiant->id,
            'password' => $password
        ])->with('success', 'Élève enregistré et compte parent configuré avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'élève : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('etudiants.view');
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
        Gate::authorize('etudiants.update');
        $etudiant = Student::findOrFail($id);
        $parents = \App\Models\Parents::all();
        return view('admin.etudiant.edit', compact('etudiant', 'parents'));
    }

    public function update(StudentRequest $request, string $id)
    {
        Gate::authorize('etudiants.update');

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


    public function credentials(Request $request)
    {
        $etudiant = Student::with('parents')->findOrFail($request->id);
        $parent = $etudiant->parents->first();
        $password = $request->password;
        return view('admin.etudiant.credentials', compact('etudiant', 'parent', 'password'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('etudiants.delete');
        $etudiant = Student::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('admin.etudiant.index')->with('success', 'Eleve supprime avec succes');
    }

    private function generPassword($length = 8)
    {
        return Str::random($length);
    }
}
