@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Configuration des Frais Scolaires</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Frais Scolaires</li>
        </ul>
    </div>

    <div class="row">
        <!-- Formulaire d'ajout -->
        <div class="col-xl-4 col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Nouveaux Frais</h3>
                        </div>
                    </div>
                    <form class="new-added-form" method="POST" action="{{ route('frais_scolaires.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="text-dark-medium">Niveau scolaire *</label>
                                <select name="niveau_id" class="select2" required>
                                    <option value="" disabled selected>Choisir un niveau</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label class="text-dark-medium">Année Scolaire *</label>
                                <select name="annee_scolaire_id" class="select2" required>
                                    <option value="" disabled selected>Choisir une année</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}" {{ $annee->status == 'actif' ? 'selected' : '' }}>
                                            {{ $annee->annee }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label class="text-dark-medium">Frais d'inscription (FCFA)</label>
                                <input type="number" name="frais_inscription" class="form-control" min="0" step="1"
                                    placeholder="Ex: 50000">
                            </div>
                            <div class="col-12 form-group">
                                <label class="text-dark-medium">Frais de scolarité (FCFA)</label>
                                <input type="number" name="frais_Scolarité" class="form-control" min="0" step="1"
                                    placeholder="Ex: 350000">
                            </div>
                            <div class="col-12 form-group">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow w-100">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des frais -->
        <div class="col-xl-8 col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Grille Tarifaire</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Niveau</th>
                                    <th>Année Scolaire</th>
                                    <th>Inscription</th>
                                    <th>Scolarité</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($frais as $item)
                                    <tr>
                                        <td class="font-weight-bold">{{ $item->niveau->nom ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ ($item->anneeScolaire->status ?? '') == 'actif' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $item->anneeScolaire->annee ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($item->frais_inscription ?? 0, 0, ',', ' ') }}</td>
                                        <td>{{ number_format($item->frais_Scolarité ?? 0, 0, ',', ' ') }}</td>
                                        <td class="text-dark-pastel-green font-weight-bold">
                                            {{ number_format(($item->frais_inscription ?? 0) + ($item->frais_Scolarité ?? 0), 0, ',', ' ') }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('frais_scolaires.edit', $item->id) }}">
                                                        <i class="fas fa-edit text-dark-pastel-green"></i> Modifier
                                                    </a>
                                                    @role('super admin|admin')
                                                    <form action="{{ route('frais_scolaires.destroy', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ces frais ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-trash-alt text-orange-red"></i> Supprimer
                                                        </button>
                                                    </form>
                                                    @endrole
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
        </div>
    </div>
@endsection