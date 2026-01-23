<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Models\Cycle;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveaux = Niveau::all();
        return view('admin.niveau.index', compact('niveaux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cycles = Cycle::all();
        return view('admin.niveau.create', compact('cycles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'cycle_id' => 'required',
        ]);

        Niveau::create([
            'nom' => $request->nom,
            'cycle_id' => $request->cycle_id,
        ]);
        return redirect()->route('admin.niveau.index')->with('success', 'Niveau ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $niveau = Niveau::findOrFail($id);
        return view('admin.niveau.show', compact('niveau'));      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $niveau = Niveau::findOrFail($id);
        return view('admin.niveau.edit', compact('niveau'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required',
        ]);

        $niveau = Niveau::findOrFail($id);
        $niveau->update($request->all());
        return redirect()->route('admin.niveau.index')->with('success', 'Niveau modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Niveau $niveau)
    {
        $niveau->delete();
        return redirect()->route('admin.niveau.index')->with('success', 'Niveau supprime avec succes');   
    }
}
