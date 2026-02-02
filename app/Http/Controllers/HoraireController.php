<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use Illuminate\Http\Request;

class HoraireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horaires = Horaire::all();
        return view('admin.horaires.index', compact('horaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.horaires.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jours' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
        ]);

        Horaire::create($request->all());

        return redirect()->route('admin.horaires.index')->with('success', 'Horaire créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horaire $horaire)
    {
        return view('admin.horaires.show', compact('horaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horaire $horaire)
    {
        return view('admin.horaires.edit', compact('horaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horaire $horaire)
    {
        $request->validate([
            'jours' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
        ]);

        $horaire->update($request->all());

        return redirect()->route('admin.horaires.index')->with('success', 'Horaire mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horaire $horaire)
    {
        $horaire->delete();

        return redirect()->route('admin.horaires.index')->with('success', 'Horaire supprimé avec succès');
    }
}
