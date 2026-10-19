<?php

namespace App\Http\Controllers;

use App\Models\Ecole;
use App\Models\EcolePayment;
use Illuminate\Http\Request;

class EcolePaymentController extends Controller
{
    /**
     * Display a listing of all school payments (Platform-wide).
     */
    public function index()
    {
        $payments = EcolePayment::with('ecole')->latest()->paginate(20);
        $totalRevenue = EcolePayment::sum('montant');

        return view('admin.ecole_payments.index', compact('payments', 'totalRevenue'));
    }

    /**
     * Store a newly created school payment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ecole_id'      => 'required|exists:ecoles,id',
            'montant'       => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|string',
            'reference'     => 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        EcolePayment::create($validated);

        return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EcolePayment $ecolePayment)
    {
        return view('admin.ecole_payments.show', compact('ecolePayment'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EcolePayment $ecolePayment)
    {
        $ecolePayment->delete();
        return redirect()->back()->with('success', 'Paiement supprimé.');
    }
}
