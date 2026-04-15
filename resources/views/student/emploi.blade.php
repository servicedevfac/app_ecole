@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Mon Emploi du Temps</h3>
        <ul>
            <li>
                <a href="{{ route('student.dashboard') }}">Accueil</a>
            </li>
            <li>Emploi du Temps</li>
        </ul>
    </div>

    <!-- Schedule Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Emploi du temps - {{ $classe->nom ?? 'Ma Classe' }}</h3>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap table-bordered">
                    <thead>
                        <tr class="bg-light-blue text-white">
                            <th>Heure</th>
                            @foreach($jours as $jour)
                                <th>{{ $jour->nom }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horaires as $horaire)
                        <tr>
                            <td class="bg-light-gray font-bold">
                                {{ \Carbon\Carbon::parse($horaire->debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($horaire->fin)->format('H:i') }}
                            </td>
                            @foreach($jours as $jour)
                                @php
                                    $cours = $emplois->where('horaire_id', $horaire->id)->where('jour_id', $jour->id)->first();
                                @endphp
                                <td class="text-center" style="{{ $cours ? 'background-color: #f0f7ff;' : '' }}">
                                    @if($cours)
                                        <div class="font-bold text-primary">{{ $cours->matiere->nom }}</div>
                                        <div class="small text-muted">{{ $cours->enseignant->nom ?? '' }}</div>
                                        <div class="badge badge-pill badge-info small">Salle: {{ $cours->salle ?? '-' }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($horaires->isEmpty())
                <div class="alert alert-warning text-center mg-t-20">
                    L'emploi du temps n'a pas encore été configuré pour votre classe.
                </div>
            @endif

            <div class="mg-t-30">
                <button type="button" onclick="window.print();" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                    <i class="fas fa-print"></i> Imprimer
                </button>
            </div>
        </div>
    </div>
    <!-- Schedule Area End Here -->
</div>
@endsection
