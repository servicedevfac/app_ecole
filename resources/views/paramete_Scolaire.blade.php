@extends('layouts.app')
@section('title', 'Paramètres Scolaires - Akkhor Theme')

@section('content')
<div class="breadcrumbs-area mx-3 mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 font-weight-bold" style="color: #111111;">Configuration Scolaire</h3>
            <ul class="d-flex align-items-center p-0" style="list-style: none; font-size: 0.9rem;">
                <li><a href="{{ route('dashboard') }}" class="text-muted">Accueil</a></li>
               
                <li class="text-orange-peel font-weight-bold"> Paramètres Globaux</li>
            </ul>
        </div>
        <div class="header-elements">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.annee.create') }}" class="btn-fill-lg btn-gradient-yellow btn-soft-amber border-none shadow-none text-white px-4">
                    <i class="fas fa-plus mr-2"></i> Nouvelle Année
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <!-- Statistics Section -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box blue shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-blue text-blue-sky">
                            <i class="flaticon-calendar"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-weight-bold tracking-1">Années</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue">{{ $anneesCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box green shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-green text-dark-pastel-green">
                            <i class="flaticon-books"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-weight-bold tracking-1">Cycles / Niveaux</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue">{{ $cyclesCount }} / {{ $niveauxCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box yellow shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-yellow text-orange-peel">
                            <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-weight-bold tracking-1">Classes</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue">{{ $classesCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box red shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-red text-orange-red">
                            <i class="flaticon-open-book text-red"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-weight-bold tracking-1">Matières</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue">{{ $matieresCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <!-- Active Year Details -->
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="card border-none shadow-akkhor border-radius-10 h-100 pb-0">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title">
                            <h3 class="font-bold text-dark-medium"><i class="fas fa-calendar-check text-dark-pastel-green mr-3"></i>Année Active</h3>
                        </div>
                    </div>
                    @if($anneeActive)
                    <div class="p-4 rounded bg-ash border-none text-center mb-4 shadow-sm border-left-akkhor-green">
                        <div class="small text-muted font-weight-bold text-uppercase mb-1 opacity-75">Session d'études actuelle</div>
                        <div class="display-3 font-weight-900 text-dark-medium mb-3">{{ $anneeActive->annee }}</div>
                        <div class="d-flex justify-content-around mt-4 pt-3 border-top-akkhor">
                            <div>
                                <div class="text-muted small font-weight-bold mb-1">DÉBUT</div>
                                <div class="h6 font-bold text-dark-medium mb-0">{{ \Carbon\Carbon::parse($anneeActive->date_debut)->format('d/M/y') }}</div>
                            </div>
                            <div>
                                <div class="text-muted small font-weight-bold mb-1">FIN</div>
                                <div class="h6 font-bold text-dark-medium mb-0">{{ \Carbon\Carbon::parse($anneeActive->date_fin)->format('d/M/y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.annee.index') }}" class="btn-fill-lmd font-bold text-light bg-dodger-blue btn-block mb-3 shadow-none rounded-pill">
                            <i class="fas fa-history mr-2"></i> Liste complète des sessions
                        </a>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="item-icon bg-light-yellow mx-auto mb-3" style="width: 60px; height: 60px;"><i class="fas fa-exclamation-triangle text-orange-peel"></i></div>
                        <h4 class="text-dark-medium">Aucune donnée active</h4>
                        <a href="{{ route('admin.annee.create') }}" class="btn-fill-sm btn-gradient-yellow border-none shadow-none text-light mt-2 rounded">Créer l'année</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Links Grid -->
        <div class="col-lg-7">
            <div class="card border-none shadow-akkhor border-radius-10 h-100 pb-0">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title">
                            <h3 class="font-bold text-dark-medium"><i class="fas fa-th-large text-blue-ky mr-3"></i>Action de Gestion</h3>
                        </div>
                    </div>
                    <div class="row mt-2 g-4">
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('admin.annee.index') }}" class="akkhor-quick-link bg-light-blue text-blue-sky hover-lift shadow-sm">
                                <i class="flaticon-calendar mb-2 text-24"></i>
                                <span class="font-bold small">ANNÉES</span>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('admin.cycle.index') }}" class="akkhor-quick-link bg-light-green text-dark-pastel-green hover-lift shadow-sm">
                                <i class="flaticon-books mb-2 text-24"></i>
                                <span class="font-bold small">CYCLES</span>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('admin.niveau.index') }}" class="akkhor-quick-link bg-light-yellow text-orange-peel hover-lift shadow-sm">
                                <i class="flaticon-couple mb-2 text-24"></i>
                                <span class="font-bold small">NIVEAUX</span>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('admin.classe.index') }}" class="akkhor-quick-link bg-light-red text-orange-red hover-lift shadow-sm">
                                <i class="flaticon-classmates mb-2 text-24"></i>
                                <span class="font-bold small">CLASSES</span>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('admin.matiere.index') }}" class="akkhor-quick-link bg-p-magenta text-magenta hover-lift shadow-sm">
                                <i class="flaticon-open-book mb-2 text-24"></i>
                                <span class="font-bold small">MATIÈRES</span>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('admin.periodes.index') }}" class="akkhor-quick-link bg-light-blue text-dodger-blue hover-lift shadow-sm">
                                <i class="flaticon-script mb-2 text-24"></i>
                                <span class="font-bold small">PERIODE</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Tables -->
    <div class="row mt-4 px-2">
        <!-- Cycles Table -->
        <div class="col-xl-6 col-12 mb-5">
            <div class="card height-auto border-none shadow-akkhor border-radius-10">
                <div class="card-body py-4 px-4">
                    <div class="heading-layout1 mb-4 d-flex justify-content-between align-items-center">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Gestion des Cycles</h3></div>
                        <a href="{{ route('admin.cycle.create') }}" class="btn-fill-lmd text-light bg-true-v font-bold shadow-none border-none py-2 px-3 rounded small">AJOUTER</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap akkhor-table">
                            <thead>
                                <tr class="bg-ash">
                                    <th class="px-3">#</th>
                                    <th>Nom du Cycle</th>
                                    <th>Niveaux Associés</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cycles as $index => $cycle)
                                <tr>
                                    <td class="px-3 font-bold text-dark-medium">{{ $index + 1 }}</td>
                                    <td class="font-medium text-dark-medium">{{ $cycle->nom }}</td>
                                    <td><span class="badge-akkhor bg-light-blue text-dodger-blue font-bold px-3 py-1 rounded-pill">{{ $cycle->niveaux_count }} niveaux</span></td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.cycle.edit', $cycle->id) }}" class="text-blue-sky mr-2 text-18" title="Modifier"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">Aucun cycle enregistré.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Levels Table -->
        <div class="col-xl-6 col-12 mb-5">
            <div class="card height-auto border-none shadow-akkhor border-radius-10">
                <div class="card-body py-4 px-4">
                    <div class="heading-layout1 mb-4 d-flex justify-content-between align-items-center">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Structure des Niveaux</h3></div>
                        <a href="{{ route('admin.niveau.create') }}" class="btn-fill-lmd text-light bg-orange-peel font-bold shadow-none border-none py-2 px-3 rounded small">AJOUTER</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap akkhor-table">
                            <thead>
                                <tr class="bg-ash">
                                    <th class="px-3">#</th>
                                    <th>Niveau</th>
                                    <th>Cycle</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($niveaux as $index => $niveau)
                                <tr>
                                    <td class="px-3 font-bold text-dark-medium">{{ $index + 1 }}</td>
                                    <td class="font-medium text-dark-medium text-uppercase">{{ $niveau->nom }}</td>
                                    <td><span class="badge-akkhor bg-light-yellow text-orange-peel font-medium px-3 py-1 rounded-pill">{{ $niveau->cycle->nom ?? 'Indéfini' }}</span></td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.niveau.edit', $niveau->id) }}" class="text-blue-sky text-18" title="Modifier"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">Aucun niveau enregistré.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Akkhor Specific Overrides */
    .font-weight-900 { font-weight: 900; }
    .tracking-1 { letter-spacing: 1px; }
    .border-radius-15 { border-radius: 15px; }
    .border-radius-10 { border-radius: 10px; }
    .shadow-akkhor { box-shadow: 0px 10px 20px 0px rgba(229, 229, 229, 0.75); }
    .hover-lift:hover { transform: translateY(-5px); transition: 0.3s; }
    
    /* Akkhor Palette Tones */
    .text-blue-sky { color: #3f7afc !important; }
    .bg-light-blue { background-color: #eff6ff !important; }
    .text-dark-blue { color: #042954 !important; }
    
    .text-dark-pastel-green { color: #00c853 !important; }
    .bg-light-green { background-color: #ecfdf5 !important; }
    
    .text-orange-peel { color: #ffa001 !important; }
    .bg-light-yellow { background-color: #fffbeb !important; }
    
    .text-orange-red { color: #ff0000 !important; }
    .bg-light-red { background-color: #fff1f2 !important; }
    
    .bg-dodger-blue { background-color: #2196f3 !important; }
    .bg-true-v { background-color: #9575cd !important; }
    .bg-p-magenta { background-color: #fce4ec !important; }
    .text-magenta { color: #8e24aa !important; }
    
    .bg-ash { background-color: #f0f1f3 !important; }
    
    .border-left-akkhor-green { border-left: 6px solid #00c853 !important; }
    .border-top-akkhor { border-top: 1px solid #e5e7eb !important; }
    
    /* Stat Icons */
    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.8rem;
    }
    
    /* Quick Actions */
    .akkhor-quick-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 15px;
        border-radius: 12px;
        text-decoration: none !important;
        transition: all 0.3s;
    }
    .akkhor-quick-link i { font-size: 2rem; margin-bottom: 5px; }
    
    /* Tables */
    .akkhor-table thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #111111;
        letter-spacing: 1px;
        border-top: none;
        padding: 15px 20px;
    }
    .akkhor-table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }
</style>
@endsection
