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
        $niveaux = Niveau::with(['cycle', 'classes'])->paginate(10);
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
            'nom' => 'required|unique:niveaux,nom',
            'cycle_id' => 'required|exists:cycles,id',
        ]);

        Niveau::create([
            'nom' => $request->nom,
            'cycle_id' => $request->cycle_id,
        ]);
        return redirect()->route('admin.niveau.index')->with('success', 'Niveau ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $niveau = Niveau::with(['cycle', 'classes'])->findOrFail($id);
        return view('admin.niveau.show', compact('niveau'));      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $niveau = Niveau::findOrFail($id);
        $cycles = Cycle::all();
        return view('admin.niveau.edit', compact('niveau', 'cycles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|unique:niveaux,nom,' . $id,
            'cycle_id' => 'required|exists:cycles,id',
        ]);

        $niveau = Niveau::findOrFail($id);
        $niveau->update($request->all());
        return redirect()->route('admin.niveau.index')->with('success', 'Niveau modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Niveau $niveau)
    {
        if ($niveau->classes()->count() > 0) {
            return redirect()->route('admin.niveau.index')
                ->with('error', 'Impossible de supprimer ce niveau car il contient des classes actives.');
        }

        $niveau->delete();
        return redirect()->route('admin.niveau.index')->with('success', 'Niveau supprimé avec succès');   
    }
}
