<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Cycle;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matieres = Matiere::with('classes')->get();
        $classes = Classe::all();
        return view('admin.matiere.index', compact('matieres', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        return view('admin.matiere.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-ZÀ-ÿ0-9\s\-]+$/'
            ],

            'code' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[A-Z0-9_-]+$/',
                Rule::unique('matieres', 'code')->ignore($request->input('id')),
            ],


        ]);

        Matiere::create($request->all());
        return redirect()->route('admin.matiere.index')->with('success', 'Matière créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Matiere $matiere)
    {
        $matieres = Matiere::with('classes')->get();
        return view('admin.matiere.show', compact('matieres')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matiere $matiere)
    {
        $classes = Classe::all();
        return view('admin.matiere.edit', compact('matiere', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'nom' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-ZÀ-ÿ0-9\s\-]+$/'
            ],

            'code' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[A-Z0-9_-]+$/',
                Rule::unique('matieres', 'code')->ignore($matiere->id),
            ],

            'classe_id' => [
                'nullable',
                'integer',
                Rule::exists('classes', 'id'),
            ],
        ]);

        $matiere->update($request->all());

        return redirect()->route('admin.matiere.index')->with('success', 'Matière mise à jour avec succès.');    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matiere $matiere)
    {
        $matiere->delete(); 

        return redirect()->route('admin.matiere.index')->with('success', 'Matière supprimée avec succès.');
    }
    public function assignematieresClasse()
    {
        $matieres = Matiere::all();
        $classe = Classe::all();
        return view('admin.matiere.assignematiere', compact('matieres', 'classe'));
    }
    public function assignematiere(Request $request )
    {
        $request->validate([
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'coefficient' => 'required|integer|min:1|max:10',
        ]);

        $classe = Classe::find($request->input('classe_id'));
        $classe->matieres()->syncWithoutDetaching([$request->input('matiere_id') => ['coefficient' => $request->input('coefficient')]]);

        return redirect()->route('admin.matiere.assignematiere', $request->input('classe_id'))->with('success', 'Matière assignée avec succès.');
    }   
}
