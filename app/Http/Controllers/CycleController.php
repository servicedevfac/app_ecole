<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cycles = Cycle::with('niveaux')->paginate(10);
        return view('admin.cycle.index', compact('cycles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cycle.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:cycles,nom',
        ]);  
        Cycle::create($request->all());
        return redirect()->route('admin.cycle.index')->with('success', 'Cycle ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cycle = Cycle::with('niveaux')->findOrFail($id);
        return view('admin.cycle.show', compact('cycle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cycle = Cycle::findOrFail($id);
        return view('admin.cycle.edit', compact('cycle'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|unique:cycles,nom,' . $id,
        ]);

        $cycle = Cycle::findOrFail($id);
        $cycle->update($request->all());
        return redirect()->route('admin.cycle.index')->with('success', 'Cycle modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $cycle = Cycle::withCount('niveaux')->findOrFail($id);
        
        if ($cycle->niveaux_count > 0) {
            return redirect()->route('admin.cycle.index')
                ->with('error', 'Impossible de supprimer ce cycle car il contient des niveaux actifs.');
        }

        $cycle->delete();
        return redirect()->route('admin.cycle.index')->with('success', 'Cycle supprimé avec succès');
    }
}
