@extends('layouts.app')
@section('title', 'Détails de l\'enseignant')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Enseignants</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.enseignant.index') }}">Enseignants</a></li>
            <li>Détails</li>
        </ul>
    </div>
    <!-- Teacher Profile Header -->
    <div class="card height-auto mg-b-20">
        <div class="card-body">
            <div class="single-info-details">
                <div class="item-img">
                    <div
                        style="width: 150px; height: 150px; border-radius: 50%; background: #061557ff; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 48px; border: 4px solid #e8e8e8;">
                        {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}{{ strtoupper(substr($enseignant->nom, 0, 1)) }}
                    </div>
                </div>
                <div class="item-content">
                    <div class="header-inline item-header">
                        <h3 class="text-dark-medium font-medium">{{ $enseignant->prenom }} {{ $enseignant->nom }}</h3>
                        <div class="header-elements">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.enseignant.edit', $enseignant->id) }}" title="Modifier">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:window.print()" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap mt-2" style="gap: 10px;">
                        <span class="badge"
                            style="background-color: #667eea; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 13px;">
                            <i class="fas fa-graduation-cap mg-r-5"></i> {{ $enseignant->specialite }}
                        </span>
                        @if($enseignant->statut == 'actif')
                            <span class="badge"
                                style="background-color: #28a745; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 13px;">
                                <i class="fas fa-check-circle mg-r-5"></i> Actif
                            </span>
                        @else
                            <span class="badge"
                                style="background-color: #dc3545; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 13px;">
                                <i class="fas fa-times-circle mg-r-5"></i> Inactif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Personal Information -->
        <div class="col-12 col-xl-6">
            <div class="card height-auto mg-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3><i class="fas fa-address-card text-dark-pastel-green mg-r-10"></i>Informations professionnelles</h3>
                        </div>
                    </div>
                    <div class="info-table table-responsive mt-3">
                        <table class="table text-nowrap">
                            <tbody>
                                <tr>
                                    <td style="width: 180px; color: #6c757d;"><i class="fas fa-user mg-r-8"></i>Nom complet</td>
                                    <td class="font-medium text-dark-medium">{{ $enseignant->prenom }} {{ $enseignant->nom }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-star mg-r-8"></i>Spécialité</td>
                                    <td class="font-medium text-dark-medium">{{ $enseignant->specialite }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-phone mg-r-8"></i>Téléphone</td>
                                    <td class="font-medium text-dark-medium">{{ $enseignant->telephone }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-envelope mg-r-8"></i>E-mail</td>
                                    <td class="font-medium text-dark-medium">{{ $enseignant->email }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-calendar-check mg-r-8"></i>Membre depuis</td>
                                    <td class="font-medium text-dark-medium">{{ $enseignant->created_at->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignments (Classes & Subjects) -->
        <div class="col-12 col-xl-6">
            <div class="card height-auto mg-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3><i class="fas fa-chalkboard-teacher text-orange-peel mg-r-10"></i>Classes & Matières affectées</h3>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th>Matière</th>
                                    <th>Année</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enseignant->affectations as $affectation)
                                    <tr>
                                        <td>
                                            <span class="badge" style="background-color: #667eea; color: #fff; padding: 3px 10px; border-radius: 10px;">
                                                {{ $affectation->classe->nom ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $affectation->matiere->nom ?? '-' }}</td>
                                        <td>{{ $affectation->anneeScolaire->annee ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-chalkboard fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                            Aucune affectation enregistrée
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluations created by this teacher -->
    <div class="row gutters-20">
        <div class="col-12">
            <div class="card height-auto mg-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3><i class="fas fa-clipboard-list text-blue mg-r-10"></i>Dernières Évaluations</h3>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Libellé</th>
                                    <th>Matière</th>
                                    <th>Date</th>
                                    <th>Note Max</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enseignant->evaluations as $index => $evaluation)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $evaluation->libelle }}</strong></td>
                                        <td>{{ $evaluation->matiere->nom ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}</td>
                                        <td>{{ $evaluation->note_max }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                            Aucune évaluation enregistrée
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
