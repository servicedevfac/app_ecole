@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Emploi du Temps</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Emploi: {{ $selectedStudent->nom }} {{ $selectedStudent->prenom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Planning hebdomadaire - {{ $classe->nom }}</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-light-blue">
                            <th class="text-dark font-weight-bold">Heure</th>
                            @foreach($jours as $jour)
                                <th class="text-dark font-weight-bold">{{ $jour->nom }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horaires as $horaire)
                            <tr>
                                <td class="bg-light text-muted small font-weight-bold" style="vertical-align: middle;">
                                    {{ \Carbon\Carbon::parse($horaire->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($horaire->heure_fin)->format('H:i') }}
                                </td>
                                @foreach($jours as $jour)
                                    @php
                                        $cell = $grid[$horaire->id][$jour->id] ?? null;
                                    @endphp
                                    <td class="p-2" style="min-width: 150px; height: 80px; vertical-align: middle;">
                                        @if($cell)
                                            <div class="schedule-item p-2 rounded shadow-sm" style="background-color: #f0f7ff; border-left: 4px solid #3f7afc;">
                                                <div class="font-weight-bold text-dark mb-1" style="font-size: 0.9rem;">
                                                    {{ $cell->matiere->nom ?? 'Matière' }}
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="fas fa-chalkboard-teacher mr-1"></i> {{ $cell->enseignant->nom ?? '-' }}
                                                </div>
                                                @if($cell->salle)
                                                    <div class="text-muted small mt-1">
                                                        <i class="fas fa-map-marker-alt mr-1"></i> Salle: {{ $cell->salle }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-light">-</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .schedule-item {
            transition: all 0.2s ease;
        }
        .schedule-item:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
@endsection
