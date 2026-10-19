@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Factures & Paiements</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Factures: {{ $selectedStudent->nom }} {{ $selectedStudent->prenom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Historique des Factures</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>Montant Total</th>
                            <th>Reste à Payer</th>
                            <th>Statut</th>
                            <th>Échéance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factures as $facture)
                            <tr>
                                <td>#{{ $facture->id }}</td>
                                <td class="font-weight-bold">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</td>
                                <td class="{{ $facture->reste > 0 ? 'text-red font-weight-bold' : 'text-success' }}">
                                    {{ number_format($facture->reste, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    @if($facture->statut == 'soldé')
                                        <span class="badge badge-success px-3">SOLDÉ</span>
                                    @else
                                        <span class="badge badge-danger px-3">NON SOLDÉ</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-print text-muted"></i> Imprimer
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
