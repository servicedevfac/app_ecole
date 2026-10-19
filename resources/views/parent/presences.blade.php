@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Suivi des Présences</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Présences: {{ $selectedStudent->nom }} {{ $selectedStudent->prenom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Historique des Présences</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Matière / Séance</th>
                            <th>Statut</th>
                            <th>Justifié</th>
                            <th>Commentaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($presences as $presence)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($presence->date)->format('d/m/Y') }}</td>
                                <td>{{ $presence->emploiDuTemps->matiere->nom ?? 'Séance générale' }}</td>
                                <td>
                                    @if($presence->statut == 'présent')
                                        <span class="badge badge-success px-3">PRÉSENT</span>
                                    @elseif($presence->statut == 'absent')
                                        <span class="badge badge-danger px-3">ABSENT</span>
                                    @else
                                        <span class="badge badge-warning px-3">RETARD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($presence->est_justifie)
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Oui</span>
                                    @else
                                        <span class="text-muted">Non</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="small text-muted">{{ $presence->commentaire ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
