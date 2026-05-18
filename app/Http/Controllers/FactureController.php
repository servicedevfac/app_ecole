<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Facture_lignes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('paiements.view');
        
        $query = Facture::with(['inscription.student', 'inscription.classe']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('inscription.student', function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $factures = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.factures.index', compact('factures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Facture $facture)
    {
        Gate::authorize('paiements.view');
        $facture->load(['inscription.student', 'inscription.classe', 'lines', 'payments']);
        return view('admin.factures.show', compact('facture'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facture $facture)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facture $facture)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facture $facture)
    {
        //
    }
}
