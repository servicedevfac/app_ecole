<?php

namespace App\Http\Controllers;

use App\Models\Types_frais;
use Illuminate\Http\Request;

class TypesFraisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typesFrais = Types_frais::all();
        return view('types_frais.index', compact('typesFrais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types_frais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $typesFrais = Types_frais::create($request->all());
        return redirect()->route('types_frais.index')->with('success', 'Type de frais créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Types_frais $types_frais)
    {
        return view('types_frais.show', compact('types_frais'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Types_frais $types_frais)
    {
        return view('types_frais.edit', compact('types_frais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Types_frais $types_frais)
    {
        $types_frais->update($request->all());
        return redirect()->route('types_frais.index')->with('success', 'Type de frais mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Types_frais $types_frais)
    {
        $types_frais->delete();
        return redirect()->route('types_frais.index')->with('success', 'Type de frais supprimé avec succès');
    }
}
