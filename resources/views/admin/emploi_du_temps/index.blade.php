@extends('layouts.app')
@section('title', 'Emploi du temps')
@section('content')
<div class="breadcrumbs-area">
    <h3>Emploi du temps</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
        <li>Liste</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Tous les créneaux</h3>
            </div>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.create') }}"><i class="fas fa-plus text-green"></i>Nouveau créneau</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table display data-table text-nowrap">
                <thead>
                    <tr>
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Enseignant</th>
                        <th>Jour</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emploi_du_temps as $e)
                    <tr>
                        <td>{{ $e->classe->nom ?? '-' }}</td>
                        <td>{{ $e->matiere->nom ?? '-' }}</td>
                        <td>{{ $e->enseignant->nom ?? '-' }} {{ $e->enseignant->prenom ?? '' }}</td>
                        <td>{{ ucfirst($e->jour->jours ?? '-') }}</td>
                        <td>{{ $e->horaire->heure_debut ?? '-' }}</td>
                        <td>{{ $e->horaire->heure_fin ?? '-' }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.emploi_du_temps.show', ['emploi_du_temp' => $e->id]) }}">Voir</a>
                            <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.emploi_du_temps.edit', ['emploi_du_temp' => $e->id]) }}">Modifier</a>
                            <form action="{{ route('admin.emploi_du_temps.destroy', ['emploi_du_temp' => $e->id]) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
