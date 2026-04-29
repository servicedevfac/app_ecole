@extends('layouts.app')
@section('title', 'Gestion des Factures')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Comptabilité</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Factures</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Toutes les Factures</h3>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Montant Total</th>
                            <th>Reste à Payer</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factures as $facture)
                            <tr>
                                <td>{{ $facture->id }}</td>
                                <td>{{ optional($facture->inscription->student)->nom }}
                                    {{ optional($facture->inscription->student)->prenom }}</td>
                                <td>{{ optional($facture->inscription->classe)->nom }}</td>
                                <td>{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    <span class="{{ $facture->reste > 0 ? 'text-danger font-weight-bold' : 'text-success' }}">
                                        {{ number_format($facture->reste, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $facture->statut == 'soldé' ? 'badge-success' : 'badge-danger' }}">
                                        {{ strtoupper($facture->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.factures.show', $facture->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Détails / Payer
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $factures->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection