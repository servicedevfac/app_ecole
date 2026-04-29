@extends('layouts.app')
@section('title', 'Liste des élèves')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Élèves</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Liste des élèves</li>
        </ul>
    </div>

    <!-- Summary Cards -->
    <div class="row gutters-20 mg-b-20">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #667eea;">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="flaticon-classmates text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content text-right">
                            <h6 class="text-uppercase" style="font-size: 11px;">Total élèves</h6>
                            <h2 class="text-dark font-weight-bold">{{ $etudiants->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #4facfe;">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                            <i class="fas fa-male text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content text-right">
                            <h6 class="text-uppercase" style="font-size: 11px;">Garçons</h6>
                            <h2 class="text-dark font-weight-bold">{{ $etudiants->where('sexe', 'M')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #f093fb;">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <i class="fas fa-female text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content text-right">
                            <h6 class="text-uppercase" style="font-size: 11px;">Filles</h6>
                            <h2 class="text-dark font-weight-bold">{{ $etudiants->where('sexe', 'F')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #28a745;">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <i class="fas fa-chalkboard text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content text-right">
                            <h6 class="text-uppercase" style="font-size: 11px;">Classes uniques</h6>
                            <h2 class="text-dark font-weight-bold">
                                {{ $etudiants->pluck('classe_id')->filter()->unique()->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
<div class="card mg-b-20">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.etudiant.index') }}" class="row gutters-8 align-items-end">
            <div class="col-xl-4 col-lg-4 col-12 form-group mb-0">
                <label style="font-size: 12px; color: #6c757d; font-weight: 600; text-transform: uppercase;">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="Nom, Prénom ou Matricule...">
            </div>
            <div class="col-xl-3 col-lg-3 col-12 form-group mb-0">
                <label style="font-size: 12px; color: #6c757d; font-weight: 600; text-transform: uppercase;">Sexe</label>
                <select name="sexe" class="form-control">
                    <option value="">Tous</option>
                    <option value="M" {{ request('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ request('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>
            <div class="col-xl-3 col-lg-3 col-12 form-group mb-0">
                <label style="font-size: 12px; color: #6c757d; font-weight: 600; text-transform: uppercase;">Classe</label>
                <select name="classe_id" class="form-control">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-2 col-lg-2 col-12 form-group mb-0 d-flex" style="gap: 8px;">
                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="flex: 1;">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('admin.etudiant.index') }}"
                    class="btn-fill-lg bg-blue-dark btn-hover-yellow"
                    style="flex: 1; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

    <!-- Table -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Tous les élèves</h3>
                </div>
                <div class="d-flex flex-wrap" style="gap: 10px;">
                    @can('etudiants.create')
                    <a href="{{ route('admin.etudiant.create') }}"
                        class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                        <i class="fas fa-user-plus mg-r-5"></i> Nouvel élève
                    </a>
                    <a href="{{ route('admin.inscription.create') }}" 
                        class="btn-fill-lg bg-blue-dark btn-hover-yellow text-white">
                        <i class="fas fa-file-invoice mg-r-5"></i> Inscrire un élève
                    </a>
                    @endcan
                    <a href="{{ route('admin.inscription.index') }}" 
                        class="btn-fill-lg bg-light text-dark shadow-sm">
                        <i class="fas fa-list-ul mg-r-5"></i> Liste Inscriptions
                    </a>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Élève</th>
                            <th>Sexe</th>
                            <th>Inscription {{ $activeAnnee->annee ?? '' }}</th>
                            <th>Parents</th>
                            <th>Date naiss.</th>
                            <th>Téléphone</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                        <tr>
                                <td>
                                    <a href="{{ route('admin.etudiant.show', $etudiant->id) }}"
                                        class="font-weight-bold text-primary">
                                        {{ $etudiant->matricule }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            @if($etudiant->photo)
                                                <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="{{ $etudiant->nom }}"
                                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e8e8e8;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold" 
                                                     style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2); font-size: 13px;">
                                                    {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="identity">
                                            <div class="font-weight-600 text-dark">{{ $etudiant->nom }} {{ $etudiant->prenom }}</div>
                                            <small class="text-muted">{{ $etudiant->sexe == 'M' ? 'Garçon' : 'Fille' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($etudiant->sexe == 'M')
                                        <span class="badge badge-pill" style="background-color: #e3f2fd; color: #1976d2;">M</span>
                                    @else
                                        <span class="badge badge-pill" style="background-color: #fce4ec; color: #c62828;">F</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $currentInscription = $etudiant->inscriptions->first();
                                    @endphp
                                    @if($currentInscription)
                                        <div class="inscription-status">
                                            <span class="badge badge-success p-2 px-3" style="border-radius: 20px;">
                                                <i class="fas fa-check-circle mr-1"></i> Inscrit
                                            </span>
                                            <div class="small text-muted mt-1">
                                                {{ $currentInscription->classe->nom ?? 'Classe N/A' }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge badge-light border p-2 px-3 text-muted" style="border-radius: 20px;">
                                            <i class="fas fa-times-circle mr-1"></i> Non inscrit
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($etudiant->parents && $etudiant->parents->count())
                                        @foreach($etudiant->parents as $parent)
                                            <div class="small">{{ $parent->nom }} {{ $parent->prenom }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ $etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $etudiant->phone ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle shadow-sm border-0" type="button" data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                            <a class="dropdown-item" href="{{ route('admin.etudiant.show', $etudiant->id) }}">
                                                <i class="fas fa-eye text-primary mr-2"></i> Profil complet
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.etudiant.documents.index', $etudiant->id) }}">
                                                <i class="fas fa-file-alt text-info mr-2"></i> Documents
                                            </a>
                                            @can('etudiants.update')
                                            <a class="dropdown-item" href="{{ route('admin.etudiant.edit', $etudiant->id) }}">
                                                <i class="fas fa-edit text-success mr-2"></i> Modifier infos
                                            </a>
                                            @if(!$currentInscription)
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item font-weight-bold text-warning" href="{{ route('admin.inscription.create', ['student_id' => $etudiant->id]) }}">
                                                    <i class="fas fa-file-invoice mr-2"></i> Inscrire cet élève
                                                </a>
                                            @endif
                                            @endcan
                                            @can('etudiants.delete')
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.etudiant.destroy', $etudiant->id) }}" method="POST" onsubmit="return confirm('Supprimer cet élève ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="flaticon-classmates fa-2x d-block mb-2" style="opacity: 0.3;"></i>
                                    Aucun élève enregistré
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $etudiants->links() }}
                </div>
            </div>
        </div>
    </div>

<style>
    .avatar-sm { flex-shrink: 0; }
    .identity .font-weight-600 { font-size: 15px; letter-spacing: 0.2px; }
    .dropdown-item { padding: 10px 20px; font-size: 14px; transition: all 0.2s; }
    .dropdown-item:hover { background-color: #f8f9fa; transform: translateX(5px); }
    .badge-pill { font-weight: 600; padding: 4px 12px; }
    .table tbody tr:hover { background-color: #fcfcfc; transition: background 0.3s; }
</style>

@endsection