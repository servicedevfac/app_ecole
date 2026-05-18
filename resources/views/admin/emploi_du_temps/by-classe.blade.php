@extends('layouts.app')
@section('title', 'Emploi du temps - ' . $classe->nom)
@section('content')
    <div class="breadcrumbs-area">
        <h3>Emploi du temps : {{ $classe->nom }}</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li><a href="{{ route('admin.emploi_du_temps.index') }}">Emploi du temps</a></li>
            <li>{{ $classe->nom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Grille Hebdomadaire</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.emploi_du_temps.classe_pdf', $classe->id) }}"
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
                                    @if($horaire->type == 'pause')
                                        <br><span class="badge badge-pill badge-warning">PAUSE</span>
                                    @endif
                                </td>
                                @foreach($jours as $jour)
                                    <td class="align-middle p-2" style="height: 100px; width: 150px;">
                                        @if(isset($grid[$horaire->id][$jour->id]))
                                            @php $s = $grid[$horaire->id][$jour->id]; @endphp
                                            <div class="schedule-item p-2 rounded shadow-sm" style="background-color: rgba(255, 188, 0, 0.1); border-left: 4px solid #ffbc00;">
                                                <div class="font-weight-bold text-dark">{{ $s->matiere->nom }}</div>
                                                <div class="small text-muted mb-1">
                                                    <i class="fas fa-user-tie mr-1"></i> {{ $s->enseignant->prenom }} {{ $s->enseignant->nom }}
                                                </div>
                                                @if($s->salle)
                                                    <div class="small text-primary">
                                                        <i class="fas fa-door-open mr-1"></i> {{ $s->salle }}
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <a href="{{ route('admin.emploi_du_temps.edit', $s->id) }}" class="text-warning mr-2" title="Modifier"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.emploi_du_temps.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce cours ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent text-danger p-0" title="Supprimer"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        @elseif($horaire->type == 'pause')
                                            <div class="text-muted small italic">---</div>
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
        .schedule-item:hover {
            transform: scale(1.02);
            background-color: rgba(255, 188, 0, 0.2) !important;
        }
    </style>
@endsection