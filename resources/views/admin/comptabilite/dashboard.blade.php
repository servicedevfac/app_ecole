@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Tableau de Bord Comptabilité</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Comptabilité</li>
        </ul>
    </div>

    <!-- Stats Cards Start Here -->
    <div class="row gutters-20">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-green">
                            <i class="flaticon-money text-green"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Encaissé</div>
                            <div class="item-number"><span>{{ number_format($totalEncaisse, 0, ',', ' ') }}</span> FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-calendar text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Facturé</div>
                            <div class="item-number"><span>{{ number_format($totalFacture, 0, ',', ' ') }}</span> FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-red">
                            <i class="flaticon-download-button text-red"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Reste à Percevoir</div>
                            <div class="item-number"><span>{{ number_format($resteAPercevoir, 0, ',', ' ') }}</span> FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-yellow">
                            <i class="flaticon-user text-yellow"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Taux Recouvrement</div>
                            <div class="item-number"><span>{{ round($tauxRecouvrement, 1) }}</span> %</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Revenue by Class -->
        <div class="col-lg-12 col-xl-6 col-12-xxxl">
            <div class="card dashboard-card-six height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Recouvrement par Classe</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th>Facturé</th>
                                    <th>Encaissé</th>
                                    <th>Taux</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($revenueByClass as $item)
                                    @if($item['total'] > 0)
                                    <tr>
                                        <td>{{ $item['nom'] }}</td>
                                        <td>{{ number_format($item['total'], 0, ',', ' ') }}</td>
                                        <td>{{ number_format($item['encaisse'], 0, ',', ' ') }}</td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar {{ $item['taux'] < 50 ? 'bg-danger' : ($item['taux'] < 80 ? 'bg-warning' : 'bg-success') }}" 
                                                    role="progressbar" style="width: {{ $item['taux'] }}%;" 
                                                    aria-valuenow="{{ $item['taux'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>{{ round($item['taux'], 1) }}%</small>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Invoices -->
        <div class="col-lg-12 col-xl-6 col-12-xxxl">
            <div class="card dashboard-card-six height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Factures en Retard</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th>Reste</th>
                                    <th>Échéance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overdueInvoices as $facture)
                                    <tr>
                                        <td>{{ $facture->inscription->student->nom }} {{ $facture->inscription->student->prenom }}</td>
                                        <td>{{ $facture->inscription->classe->nom }}</td>
                                        <td class="text-red font-weight-bold">{{ number_format($facture->reste, 0, ',', ' ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Aucune facture en retard</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Recent Payments -->
        <div class="col-12">
            <div class="card dashboard-card-six height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Paiements Récents</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Référence</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->date_paiement)->format('d/m/Y') }}</td>
                                        <td>{{ $payment->facture->inscription->student->nom }} {{ $payment->facture->inscription->student->prenom }}</td>
                                        <td>{{ $payment->facture->inscription->classe->nom }}</td>
                                        <td class="font-weight-bold text-success">{{ number_format($payment->montant, 0, ',', ' ') }}</td>
                                        <td>{{ $payment->mode_paiement }}</td>
                                        <td>{{ $payment->reference ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
