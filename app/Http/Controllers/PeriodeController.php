<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\Annee_scolaire;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::with('anneeScolaire')->paginate(10);
        return view('admin.periodes.index', compact('periodes'));
    }

    public function create()
    {
        $annees = Annee_scolaire::all();
        return view('admin.periodes.create', compact('annees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:trimestre,semestre',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'status' => 'required|in:ouvert,fermé',
        ]);

        Periode::create($request->all());

        return redirect()->route('admin.periodes.index')->with('success', 'Période créée avec succès.');
    }

    public function edit(Periode $periode)
    {
        $annees = Annee_scolaire::all();
        return view('admin.periodes.edit', compact('periode', 'annees'));
    }

    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:trimestre,semestre',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'status' => 'required|in:ouvert,fermé',
        ]);

        $periode->update($request->all());

        return redirect()->route('admin.periodes.index')->with('success', 'Période mise à jour avec succès.');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();
        return redirect()->route('admin.periodes.index')->with('success', 'Période supprimée avec succès.');
    }
}
