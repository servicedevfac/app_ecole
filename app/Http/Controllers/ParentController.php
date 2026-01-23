<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parents;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = Parents::all();
        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('admin.parents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'email' => 'required|email|unique:parents,email|max:255',
            'telephone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'autre_telephone' => 'nullable|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'adresse' => 'required|string|max:500',
        ]);

        Parents::create($request->all());

        return redirect()->route('admin.parent.index')
            ->with('success', 'Parent créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $parent = Parents::findOrFail($id);
        return view('admin.parents.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parent = Parents::findOrFail($id);
        return view('admin.parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'email' => 'required|email|unique:parents,email,'.$id.'|max:255',
            'relation' => 'required|in:mere,pere,frere,soeur,tuteur',
            'telephone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'autre_telephone' => 'nullable|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'adresse' => 'required|string|max:500',
        ]);

        $parent = Parents::findOrFail($id);
        $parent->update($request->all());

        return redirect()->route('admin.parent.index')
            ->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //  
        $parent = Parents::findOrFail($id);
        $parent->delete();

        return redirect()->route('admin.parent.index')
            ->with('success', 'Parent supprimé avec succès.');
    }
}
