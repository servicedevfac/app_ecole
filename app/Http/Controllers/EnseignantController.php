<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enseignants = Enseignant::all();
        return view('admin.enseignant.index', compact('enseignants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.enseignant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
                'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
                'telephone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
                'email' => 'required|email|unique:enseignants,email|max:255',
                'specialite' => 'required|string|max:255',
    
            ]);
            $user = User::create([
            'name' => $request->input('nom'),
            'email' => $request->input('email'),
            'password' =>Hash::make('123456'),
        ]);
    
        $user->assignRole('enseignant');

    
            $enseignant =Enseignant::create([
            'user_id' => $user->id,
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
            'specialite' => $request->input('specialite'),
            'statut' => 'actif',
        ]); 
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('admin.enseignant.index')->with('success', 'Enseignant ajoute avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enseignant $enseignant)
    {
        return view('admin.enseignant.show', compact('enseignant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enseignant $enseignant)
    {
        return view('admin.enseignant.edit', compact('enseignant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enseignant $enseignant)
    {
        //
        $request->validate([
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'telephone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'email' => 'required|email|unique:enseignants,email,'.$enseignant->id.',id|max:255',
            'specialite' => 'required|string|max:255',
            
        ]);
         
        $enseignant->update($request->all());
        
        return redirect()->route('admin.enseignant.index')->with('success', 'Enseignant modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();
        
        return redirect()->route('admin.enseignant.index')->with('success', 'Enseignant supprime avec succes');
    }
}
