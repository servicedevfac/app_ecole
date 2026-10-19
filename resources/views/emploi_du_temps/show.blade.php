@extends('layouts.app')
@section('title', 'Détail du créneau')
@section('content')
<div class="breadcrumbs-area">
    <h3>Emploi du temps</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
        <li>Détail</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Détails du créneau</h3>
            </div>
        </div>

        <div class="single-info-details">
            <div class="info-table table-responsive">
                <table class="table text-nowrap">
                    <tbody>
                        <tr>
                            <td>Classe</td>
                            <td class="font-medium text-dark-medium">{{ $emploi_du_temps->classe->nom ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Matière</td>
                            <td class="font-medium text-dark-medium">{{ $emploi_du_temps->matiere->nom ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Enseignant</td>
                            <td class="font-medium text-dark-medium">{{ $emploi_du_temps->enseignant->nom ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jour</td>
                            <td class="font-medium text-dark-medium">{{ ucfirst($emploi_du_temps->jours) }}</td>
                        </tr>
                        <tr>
                            <td>Heure</td>
                            <td class="font-medium text-dark-medium">{{ $emploi_du_temps->heure_debut }} - {{ $emploi_du_temps->heure_fin }}</td>
                        </tr>
                        <tr>
                            <td>Année scolaire</td>
                            <td class="font-medium text-dark-medium">{{ $emploi_du_temps->anneeScolaire->annee ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('admin.emploi_du_temps.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
    </div>
</div>
@endsection
