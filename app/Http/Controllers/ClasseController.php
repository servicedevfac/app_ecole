<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::with(['niveau'])->get();
        return view('admin.classe.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveaux = Niveau::all();
        return view('admin.classe.create', compact('niveaux'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'niveau_id' => 'required',
            'nom' => 'required',
        ]);

        Classe::create($request->all());
        return redirect()->route('admin.classe.index')->with('success', 'Classe ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classe = Classe::findOrFail($id);
     
        return view('admin.classe.show', compact('classe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classe = Classe::findOrFail($id);
        $niveaux = Niveau::all();
        return view('admin.classe.edit', compact('classe', 'niveaux'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'niveau_id' => 'required',
            'nom' => 'required',
        ]);

        $classe = Classe::findOrFail($id);
        $classe->update($request->all());
        return redirect()->route('admin.classe.index')->with('success', 'Classe modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return redirect()->route('admin.classe.index')->with('success', 'Classe supprime avec succes');   
    }
}
