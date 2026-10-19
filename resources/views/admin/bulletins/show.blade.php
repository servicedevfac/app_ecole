@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Bulletins - {{ $classe->nom }}</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>
                <a
                    href="{{ route('admin.bulletins.index', ['periode_id' => $periode ? $periode->id : null]) }}">Bulletins</a>
            </li>
            <li>{{ $classe->nom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Moyennes de la classe : {{ $classe->nom }}
                        ({{ $annee->annee }}{{ $periode ? ' - ' . $periode->nom : '' }})</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"
                            href="{{ route('admin.bulletins.download_all', ['classe' => $classe->id, 'periode_id' => $periode ? $periode->id : null, 'annee_scolaire_id' => $annee->id]) }}">
                            <i class="fas fa-file-download text-primary"></i> Télécharger tous (ZIP)
                        </a>
                        <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Imprimer</a>
                        <a class="dropdown-item"
                            href="{{ route('admin.bulletins.index', ['periode_id' => $periode ? $periode->id : null]) }}"><i
                                class="fas fa-arrow-left"></i> Retour</a>
                    </div>
                </div>
            </div>

            <!-- Class Stats Summary -->
            <div class="row gutters-20 mb-4">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="ui-item bg-light-green">
                        <div class="media-body">
                            <span class="text-muted small">Moyenne de Classe</span>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($classStats['moyenne_generale'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-12">
                    <div class="ui-item bg-light-blue">
                        <div class="media-body">
                            <span class="text-muted small">Plus Forte</span>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($classStats['max'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-12">
                    <div class="ui-item bg-light-red">
                        <div class="media-body">
                            <span class="text-muted small">Plus Faible</span>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($classStats['min'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="ui-item bg-light-yellow">
                        <div class="media-body">
                            <span class="text-muted small">Taux de Réussite</span>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $classStats['total_students'] > 0 ? number_format(($classStats['passes'] / $classStats['total_students']) * 100, 1) : 0 }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4 text-right">
                <a href="{{ route('admin.bulletins.download_all', ['classe' => $classe->id, 'periode_id' => $periode ? $periode->id : null, 'annee_scolaire_id' => $annee->id]) }}"
                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                    <i class="fas fa-file-download mr-2"></i> Télécharger tous les bulletins (ZIP)
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle">Rang</th>
                            <th rowspan="2" class="align-middle">Matricule</th>
                            <th rowspan="2" class="align-middle">Nom & Prénom</th>
                            @foreach($matieres as $matiere)
                                <th class="text-center">{{ $matiere->nom }}</th>
                            @endforeach
                            <th rowspan="2" class="align-middle text-center bg-light font-weight-bold">Moyenne Générale</th>
                        </tr>
                        <tr>
                            @foreach($matieres as $matiere)
                                <th class="text-center small text-muted">Coef: {{ $matiere->pivot->coefficient }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bulletins as $data)
                            <tr>
                                <td class="text-center font-weight-bold">
                                    {{ $data['rang'] }}{{ $data['rang'] == 1 ? 'er' : ($data['rang'] > 1 ? 'ème' : '') }}{{ $data['is_ex'] ? ' ex' : '' }}
                                </td>
                                <td>{{ $data['student']->matricule }}</td>
                                <td>
                                    <a href="{{ route('admin.bulletins.student', ['classe' => $classe->id, 'student' => $data['student']->id, 'periode_id' => $periode ? $periode->id : null]) }}"
                                        class="text-dark">
                                        <div class="d-flex align-items-center">
                                            @if($data['student']->photo)
                                                <img src="{{ asset('storage/' . $data['student']->photo) }}" alt="student"
                                                    class="rounded-circle mr-2"
                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle mr-2 bg-light d-flex align-items-center justify-content-center text-secondary"
                                                    style="width: 30px; height: 30px; font-weight: bold;">
                                                    {{ substr($data['student']->prenom, 0, 1) }}{{ substr($data['student']->nom, 0, 1) }}
                                                </div>
                                            @endif
                                            {{ $data['student']->nom }} {{ $data['student']->prenom }}
                                        </div>
                                    </a>
                                </td>
                                @foreach($matieres as $matiere)
                                    @php
                                        $matData = $data['matieres'][$matiere->id] ?? null;
                                    @endphp
                                    <td class="text-center">
                                        @if($matData && $matData['moyenne'] !== null)
                                            <span class="font-weight-bold {{ $matData['moyenne'] < 10 ? 'text-danger' : 'text-dark' }}">
                                                {{ number_format($matData['moyenne'], 1) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-center font-weight-bold bg-light">
                                    @if($data['total_coef'] > 0)
                                        <span class="h6 {{ $data['moyenne_generale'] < 10 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($data['moyenne_generale'], 2) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection