<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enseignants = Enseignant::paginate(10);
        return view('admin.enseignant.index', compact('enseignants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.enseignant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/',
            'telephone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'email' => 'required|email|unique:enseignants,email|unique:users,email|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        try {
            \DB::beginTransaction();

            // Génération d'un mot de passe aléatoire
            $password = Str::random(8);

            // 1. Créer le compte utilisateur
            $user = User::create([
                'name' => $request->input('nom') . ' ' . $request->input('prenom'),
                'email' => $request->input('email'),
                'username' => $request->input('email'),
                'password' => Hash::make($password),
                'ecole_id' => auth()->user()->ecole_id,
                'must_change_password' => true,
            ]);

            $user->assignRole('enseignant');

            // 2. Créer l'enseignant
            Enseignant::create([
                'user_id' => $user->id,
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'telephone' => $request->input('telephone'),
                'email' => $request->input('email'),
                'specialite' => $request->input('specialite'),
                'statut' => 'actif',
                'ecole_id' => auth()->user()->ecole_id,
            ]);

            \DB::commit();
            return redirect()->route('admin.enseignant.index')->with('success', "Enseignant et compte utilisateur créés avec succès. Mot de passe généré : $password");

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout : ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Enseignant $enseignant)
    {
        $enseignant->load(['user', 'affectations.matiere', 'affectations.classe', 'affectations.anneeScolaire', 'evaluations.matiere']);
        return view('admin.enseignant.show', compact('enseignant'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enseignant $enseignant)
    {
        return view('admin.enseignant.edit', compact('enseignant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/',
            'telephone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'email' => 'required|email|unique:enseignants,email,' . $enseignant->id . '|unique:users,email,' . ($enseignant->user_id ?? 0) . '|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        try {
            \DB::beginTransaction();

            $enseignant->update($request->all());

            if ($enseignant->user) {
                $enseignant->user->update([
                    'name' => $request->nom . ' ' . $request->prenom,
                    'email' => $request->email,
                    'username' => $request->email,
                ]);
            }

            \DB::commit();
            return redirect()->route('admin.enseignant.index')->with('success', 'Enseignant et compte utilisateur modifiés avec succès');

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la modification : ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();

        return redirect()->route('admin.enseignant.index')->with('success', 'Enseignant supprime avec succes');
    }
}
