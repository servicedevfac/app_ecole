@extends('layouts.app')
@section('title', 'Gestion des Factures')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Gestion de la Facturation</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Factures</li>
        </ul>
    </div>

    <!-- Filters Area -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Filtrer les Factures</h3>
                </div>
            </div>
            <form class="mg-b-20" action="{{ route('admin.factures.index') }}" method="GET">
                <div class="row gutters-8">
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par élève..." class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-3 col-12 form-group">
                        <select name="statut" class="select2">
                            <option value="">Tous les statuts</option>
                            <option value="non soldé" {{ request('statut') == 'non soldé' ? 'selected' : '' }}>Non Soldé</option>
                            <option value="soldé" {{ request('statut') == 'soldé' ? 'selected' : '' }}>Soldé</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow">RECHERCHER</button>
                    </div>
                </div>
            </form>

            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Liste des Factures</h3>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Montant Total</th>
                            <th>Reste à Payer</th>
                            <th>Statut</th>
                            <th>Dernière Échéance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factures as $facture)
                            <tr>
                                <td class="font-weight-bold">#{{ $facture->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="item-img bg-light-blue p-2 rounded-circle mr-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user text-blue" style="font-size: 14px;"></i>
                                        </div>
                                        <div>
                                            <span class="text-dark font-weight-bold">{{ optional($facture->inscription->student)->nom }} {{ optional($facture->inscription->student)->prenom }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ optional($facture->inscription->classe)->nom }}</td>
                                <td class="font-weight-bold">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    @if($facture->reste > 0)
                                        <span class="text-red font-weight-bold">
                                            {{ number_format($facture->reste, 0, ',', ' ') }} FCFA
                                        </span>
                                    @else
                                        <span class="text-dark-pastel-green">
                                            <i class="fas fa-check-circle"></i> Soldé
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($facture->statut == 'soldé')
                                        <span class="badge badge-pill badge-success px-3">SOLDÉ</span>
                                    @else
                                        <span class="badge badge-pill badge-danger px-3">NON SOLDÉ</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $facture->date_echeance ? \Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.factures.show', $facture->id) }}">
                                                <i class="fas fa-eye text-primary"></i> Voir / Payer
                                            </a>
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
                <div class="mt-4 d-flex justify-content-center">
                    {{ $factures->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection