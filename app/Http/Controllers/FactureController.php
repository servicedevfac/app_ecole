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
    public function index()
    {
        Gate::authorize('paiements.view');
        $factures = Facture::with(['inscription.student', 'inscription.classe'])->orderBy('created_at', 'desc')->get();
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
