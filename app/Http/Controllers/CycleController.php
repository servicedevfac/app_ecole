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
        $cycles = Cycle::all();
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
            'nom' => 'required',
        ]);  
        Cycle::create($request->all());
        return redirect()->route('admin.cycle.index')->with('success', 'Cycle ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cycle = Cycle::findOrFail($id);
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
            'nom' => 'required',
        ]);

        $cycle = Cycle::findOrFail($id);
        $cycle->update($request->all());
        return redirect()->route('admin.cycle.index')->with('success', 'Cycle modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $cycle = Cycle::findOrFail($id);
        $cycle->delete();
        return redirect()->route('admin.cycle.index')->with('success', 'Cycle supprime avec succes');
    }
}
