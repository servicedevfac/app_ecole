@extends('layouts.app')
@section('title', 'Emploi du temps - ' . $enseignant->nom)
@section('content')
    <div class="breadcrumbs-area">
        <h3>Emploi du temps : {{ $enseignant->prenom }} {{ $enseignant->nom }}</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li><a href="{{ route('admin.emploi_du_temps.index') }}">Emploi du temps</a></li>
            <li>{{ $enseignant->nom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Grille Hebdomadaire (Enseignant)</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.emploi_du_temps.teacher_pdf', $enseignant->id) }}"
                        class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                        <i class="fas fa-file-pdf"></i> Télécharger PDF
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center schedule-grid">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 150px;">Horaire</th>
                            @foreach($jours as $jour)
                                <th>{{ ucfirst($jour->jours) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horaires as $horaire)
                            <tr>
                                <td class="align-middle font-weight-bold bg-light">
                                    {{ \Carbon\Carbon::parse($horaire->heure_debut)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($horaire->heure_fin)->format('H:i') }}
                                </td>
                                @foreach($jours as $jour)
                                    <td class="align-middle p-2" style="height: 100px; width: 150px;">
                                        @if(isset($grid[$horaire->id][$jour->id]))
                                            @php $s = $grid[$horaire->id][$jour->id]; @endphp
                                            <div class="schedule-item p-2 rounded shadow-sm" style="background-color: rgba(79, 172, 254, 0.1); border-left: 4px solid #4facfe;">
                                                <div class="font-weight-bold text-dark">{{ $s->matiere->nom }}</div>
                                                <div class="small text-muted mb-1">
                                                    <i class="fas fa-chalkboard mr-1"></i> {{ $s->classe->nom }}
                                                </div>
                                                @if($s->salle)
                                                    <div class="small text-primary">
                                                        <i class="fas fa-door-open mr-1"></i> {{ $s->salle }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-light small">-</div>
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
        .schedule-grid th {
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        .schedule-item {
            transition: transform 0.2s;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
@endsection