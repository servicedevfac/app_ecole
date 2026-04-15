@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Mes Factures & Paiements</h3>
        <ul>
            <li>
                <a href="{{ route('student.dashboard') }}">Accueil</a>
            </li>
            <li>Mes Factures</li>
        </ul>
    </div>

    <!-- Student Invoices Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Historique financier</h3>
                </div>
            </div>

            @forelse($inscriptions as $ins)
            <div class="mg-t-30">
                <div class="p-3 bg-light border rounded mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">Année Scolaire {{ $ins->anneeScolaire->nom }}</h4>
                            <p class="mb-0 text-muted">Classe : {{ $ins->classe->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 text-md-right">
                            @php $facture = $ins->factures->first(); @endphp
                            @if($facture)
                                <span class="badge {{ $facture->statut == 'soldé' ? 'badge-success' : 'badge-danger' }}" style="font-size: 1rem;">
                                    {{ strtoupper($facture->statut) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($facture)
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="bg-primary text-white p-3 rounded text-center">
                            <div class="small">Montant Total</div>
                            <div class="h3 mb-0">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-success text-white p-3 rounded text-center">
                            <div class="small">Déjà Payé</div>
                            @php $dejaPaye = $facture->montant_total - $facture->reste; @endphp
                            <div class="h3 mb-0">{{ number_format($dejaPaye, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-warning text-white p-3 rounded text-center">
                            <div class="small">Reste à Payer</div>
                            <div class="h3 mb-0">{{ number_format($facture->reste, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </div>

                <h5>Détail des Paiements</h5>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Référence</th>
                                <th>Mode</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($facture->payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                <td>{{ $payment->reference ?? 'VER-' . $payment->id }}</td>
                                <td>{{ $payment->mode_paiement ?? 'Espèces' }}</td>
                                <td class="font-bold text-success">{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun paiement enregistré pour cette facture.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">Aucune facture n'a été générée pour cette année scolaire.</div>
                @endif
            </div>
            <hr class="my-5">
            @empty
            <div class="alert alert-warning text-center">Aucune inscription enregistrée.</div>
            @endforelse
        </div>
    </div>
    <!-- Student Invoices Area End Here -->
</div>
@endsection
