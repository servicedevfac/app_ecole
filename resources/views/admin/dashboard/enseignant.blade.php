@extends('layouts.app')
@section('title', 'Tableau de Bord Enseignant')

@section('content')
<div class="breadcrumbs-area mx-3 mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 font-weight-900" style="color: #111111;">Tableau de bord Enseignant</h3>
            <ul class="d-flex align-items-center p-0" style="list-style: none; font-size: 0.9rem;">
                <li><a href="{{ route('dashboard') }}" class="text-muted">Tableau de bord</a></li>
                <li class="mx-2 text-muted">/</li>
                <li class="text-orange-peel font-bold"> {{ $enseignant->nom }}</li>
            </ul>
        </div>
        <div class="header-elements">
            @if($anneeActive)
            <div class="bg-light-green text-dark-pastel-green px-4 py-2 rounded-pill font-bold size-15">
                <i class="fas fa-calendar-check mr-2"></i> Session {{ $anneeActive->annee }}
            </div>
            @endif
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <!-- Teacher Stats Row -->
    <div class="row mb-5">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="akkhor-stat-box blue shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-blue text-blue-sky">
                            <i class="flaticon-classmates"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Mes Élèves</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter">{{ $myStudentsCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="akkhor-stat-box yellow shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-yellow text-orange-peel">
                            <i class="flaticon-books"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Mes Classes</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter">{{ $myClassesCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="akkhor-stat-box green shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-green text-dark-pastel-green">
                            <i class="flaticon-shopping-list text-dark-pastel-green"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Mes Évaluations</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter">{{ $myEvaluationsCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <!-- Assigned Classes Table -->
        <div class="col-xl-7 col-12 mb-4">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4 d-flex justify-content-between align-items-center">
                        <div class="item-title">
                            <h3 class="font-bold text-dark-medium"><i class="fas fa-chalkboard text-blue-sky mr-3"></i>Classes & Matières Assignées</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap akkhor-table">
                            <thead>
                                <tr class="bg-ash">
                                    <th class="px-3">Matière</th>
                                    <th>Classe</th>
                                    <th>Niveau</th>
                                    <th>Effectif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myAffectations as $affectation)
                                <tr>
                                    <td class="font-bold text-dark-medium px-3">{{ $affectation->matiere->nom }}</td>
                                    <td><span class="badge-akkhor bg-light-yellow text-orange-peel font-bold px-3 py-1 rounded-pill">{{ $affectation->classe->nom }}</span></td>
                                    <td class="small text-uppercase">{{ $affectation->classe->niveau->nom ?? '-' }}</td>
                                    <td><span class="badge-akkhor bg-light-blue text-blue-sky font-bold px-3 py-1 rounded-pill">{{ $affectation->classe->students_count ?? $affectation->classe->students()->count() }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5">Aucune affectation trouvée.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Evaluations Section -->
        <div class="col-xl-5 col-12 mb-4">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4 d-flex justify-content-between align-items-center">
                        <div class="item-title">
                            <h3 class="font-bold text-dark-medium"><i class="fas fa-calendar-alt text-orange-red mr-3"></i>Évaluations Récentes</h3>
                        </div>
                        <a href="{{ route('admin.evaluations.index') }}" class="btn-fill-lmd text-light bg-dodger-blue font-bold shadow-none border-none py-2 px-3 rounded small rounded-pill">
                            VOIR TOUT
                        </a>
                    </div>
                    <div class="notice-board-wrap">
                        @forelse($myEvaluations as $evaluation)
                        <div class="notice-list mb-3 p-3 bg-ash border-radius-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="post-date bg-light-blue text-blue-sky rounded px-2 py-1 font-bold small">
                                    {{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d M, Y') }}
                                </div>
                                <div class="statut">
                                    <span class="badge badge-pill {{ $evaluation->statut == 'validee' ? 'bg-light-green text-dark-pastel-green' : 'bg-light-yellow text-orange-peel' }} px-3">
                                        {{ ucfirst($evaluation->statut) }}
                                    </span>
                                </div>
                            </div>
                            <h6 class="title-bold text-dark-medium mt-2 mb-1">{{ $evaluation->libelle }}</h6>
                            <div class="entry-meta text-muted small">
                                {{ $evaluation->matiere->nom }} | {{ $evaluation->classe->nom }}
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted">Aucune évaluation récente.</div>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.evaluations.create') }}" class="btn-fill-lg font-bold text-light bg-true-v btn-block shadow-none rounded-pill py-3">
                            <i class="fas fa-plus mr-2"></i> Créer une évaluation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reuse Admin Styles */
    .font-weight-900 { font-weight: 900; }
    .tracking-1 { letter-spacing: 1px; }
    .border-radius-15 { border-radius: 15px; }
    .border-radius-10 { border-radius: 10px; }
    .shadow-akkhor { box-shadow: 0px 10px 20px 0px rgba(229, 229, 229, 0.75); }
    .border-none { border: none !important; }
    .text-blue-sky { color: #3f7afc !important; }
    .bg-light-blue { background-color: #eff6ff !important; }
    .text-dark-blue { color: #042954 !important; }
    .text-dark-pastel-green { color: #00c853 !important; }
    .bg-light-green { background-color: #ecfdf5 !important; }
    .text-orange-peel { color: #ffa001 !important; }
    .bg-light-yellow { background-color: #fffbeb !important; }
    .text-orange-red { color: #ff0000 !important; }
    .bg-ash { background-color: #f0f1f3 !important; }
    .bg-true-v { background-color: #9575cd !important; }
    .bg-dodger-blue { background-color: #2196f3 !important; }
    
    .stat-icon {
        width: 55px; height: 55px; border-radius: 15px;
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
    }
    .akkhor-table thead th {
        font-weight: 700; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;
        background-color: #f0f1f3; color: #111111; border: none !important;
    }
    .akkhor-table tbody td { vertical-align: middle; padding: 15px 20px; border-bottom: 1px solid #f1f3f5; }
    .badge-akkhor { font-size: 0.8rem; }
</style>
@endsection
