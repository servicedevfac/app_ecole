<?php

namespace App\Http\Controllers;

use App\Models\Frais_Scolaire;
use App\Models\Niveau;
use App\Models\Annee_scolaire;
use Illuminate\Http\Request;

class FraisScolaireController extends Controller
{
    public function index()
    {
        $frais = Frais_Scolaire::with(['niveau', 'anneeScolaire'])->get();
        $niveaux = Niveau::all();
        $annees = Annee_scolaire::where('status', 'actif')->get();
        return view('admin.frais_scolaires.index', compact('frais', 'niveaux', 'annees'));
    }

    public function create()
    {
        $niveaux = Niveau::all();
        $annees = Annee_scolaire::where('status', 'actif')->get();
        return view('admin.frais_scolaires.create', compact('niveaux', 'annees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'niveau_id' => 'required|exists:niveaux,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'frais_inscription' => 'nullable|numeric|min:0',
            'frais_Scolarité' => 'nullable|numeric|min:0',
        ]);

        Frais_Scolaire::create($request->only([
            'niveau_id',
            'annee_scolaire_id',
            'frais_inscription',
            'frais_Scolarité'
        ]));

        return redirect()->route('frais_scolaires.index')
            ->with('success', 'Frais scolaire ajouté avec succès.');
    }

    public function edit(Frais_Scolaire $frais_scolaire)
    {
        $niveaux = Niveau::all();
        $annees = Annee_scolaire::all();
        return view('admin.frais_scolaires.edit', compact('frais_scolaire', 'niveaux', 'annees'));
    }

    public function update(Request $request, Frais_Scolaire $frais_scolaire)
    {
        $request->validate([
            'niveau_id' => 'required|exists:niveaux,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'frais_inscription' => 'nullable|numeric|min:0',
            'frais_Scolarité' => 'nullable|numeric|min:0',
        ]);

        $frais_scolaire->update($request->only([
            'niveau_id',
            'annee_scolaire_id',
            'frais_inscription',
            'frais_Scolarité'
        ]));

        return redirect()->route('frais_scolaires.index')
            ->with('success', 'Frais scolaire mis à jour avec succès.');
    }

    public function destroy(Frais_Scolaire $frais_scolaire)
    {
        $frais_scolaire->delete();

        return redirect()->route('frais_scolaires.index')
            ->with('success', 'Frais scolaire supprimé avec succès.');
    }
}
