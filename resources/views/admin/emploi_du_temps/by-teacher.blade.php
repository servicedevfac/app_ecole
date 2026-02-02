@extends('layouts.app')
@section('title', 'Emploi du temps par enseignant')
@section('content')
<div class="breadcrumbs-area">
    <h3>Emploi du temps</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
        <li>Par enseignant</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Emploi du temps par enseignant</h3>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table display data-table text-nowrap">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Horaire</th>
                        <th>Classe</th>
                        <th>Matière</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ ucfirst($schedule->jour->jours ?? '-') }}</td>
                        <td>{{ $schedule->horaire->heure_debut ?? '-' }} - {{ $schedule->horaire->heure_fin ?? '-' }}</td>
                        <td>{{ $schedule->classe->nom ?? '-' }}</td>
                        <td>{{ $schedule->matiere->nom ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun emploi du temps trouvé pour cet enseignant.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
