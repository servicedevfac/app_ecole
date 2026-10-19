@extends('layouts.app')
@section('title', 'Gestion des Présences')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Présences</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Liste des présences</li>
        </ul>
    </div>

    <!-- Filter Bar -->
    <div class="card mg-b-20">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.presences.index') }}" class="row gutters-8 align-items-end">
                <div class="col-xl-4 col-lg-4 col-12 form-group mb-0">
                    <label style="font-size: 12px; color: #6c757d; font-weight: 600; text-transform: uppercase;">Date</label>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="form-control">
                </div>
                <div class="col-xl-4 col-lg-4 col-12 form-group mb-0">
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
                <div class="col-xl-4 col-lg-4 col-12 form-group mb-0 d-flex" style="gap: 8px;">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="flex: 1;">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.presences.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow" style="flex: 1; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times"></i> Réinitialiser
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
                    <h3>Historique des Présences</h3>
                </div>
                <div class="d-flex flex-wrap" style="gap: 10px;">
                    <a href="{{ route('admin.presences.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                        <i class="fas fa-plus mg-r-5"></i> Faire l'appel
                    </a>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Date</th>
                            <th>Séance</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presences as $presence)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-600 text-dark">{{ $presence->student->nom }} {{ $presence->student->prenom }}</div>
                                </div>
                            </td>
                            <td>{{ $presence->classe->nom }}</td>
                            <td>{{ $presence->matiere->nom ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($presence->date)->format('d/m/Y') }}</td>
                            <td>
                                @if($presence->emploiDuTemps)
                                    <small class="badge badge-light border">
                                        {{ $presence->emploiDuTemps->horaire->heure_debut }} - {{ $presence->emploiDuTemps->horaire->heure_fin }}
                                    </small>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = [
                                        'present' => 'badge-success',
                                        'absent' => 'badge-danger',
                                        'retard' => 'badge-warning',
                                        'justifié' => 'badge-info',
                                    ][$presence->statut] ?? 'badge-secondary';
                                @endphp
                                <span class="badge badge-pill {{ $badgeClass }} p-2 px-3">
                                    {{ ucfirst($presence->statut) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.presences.edit', $presence->id) }}" class="btn btn-light btn-sm shadow-sm border-0">
                                    <i class="fas fa-edit text-success"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Aucune présence enregistrée pour ces critères.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $presences->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

@endsection
