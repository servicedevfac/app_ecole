<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Matiere_classe;
use Illuminate\Http\Request;

class AssignematiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matieres = Matiere_classe::all();
        return view('admin.matiere.index', compact('matieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matieres = Matiere::all();
        $classes = Classe::all();
        return view('admin.matiere.assignematiere', compact('matieres', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'matiere_id' => 'required',
            'classe_id' => 'required',
            'coefficient' => 'required|numeric',
        ]);

       $classe = Classe::findOrFail($request->classe_id);
       $classe->matieres()->syncWithoutDetaching([
            $request->matiere_id => ['coefficient' => $request->coefficient]
       ]);

        return redirect()->route('admin.matiere.index')
                        ->with('success', 'Matière assignée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $matieres = Matiere::all();
        $classe = Classe::all();
        $matiere_classe = Matiere_classe::find($id);
        return view('admin.matiere.assignematiere', compact('matieres', 'classe', 'matiere_classe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'matiere_id' => 'required',
            'classe_id' => 'required',
            'coefficient' => 'required|numeric',
        ]);

        $classe = Classe::findOrFail($request->classe_id);
        $classe->matieres()->updateExistingPivot($request->matiere_id, [
            'coefficient' => $request->coefficient
        ]);

        return redirect()->route('admin.matiere.assignematiere.index')
                        ->with('success', 'Matière assignée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $matiere_classe = Matiere_classe::find($id);
        $matiere_classe->delete();

        return redirect()->route('admin.matiere.assignematiere.index')
                        ->with('success', 'Matière désassignée avec succès.');  
    }
}
