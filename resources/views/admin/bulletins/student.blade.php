@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Bulletin de Notes</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>
                <a href="{{ route('admin.bulletins.index') }}">Bulletins</a>
            </li>
            <li>
                <a
                    href="{{ route('admin.bulletins.generate', ['classe' => $classe->id, 'periode_id' => $periode ? $periode->id : null]) }}">{{ $classe->nom }}</a>
            </li>
            <li>{{ $bulletin['student']->nom }} {{ $bulletin['student']->prenom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <!-- School Header -->
            <div class="row mb-5 pb-3 border-bottom align-items-center">
                <div class="col-md-2 text-center text-md-left">
                    @if(isset($ecole) && $ecole->logo)
                        <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo École" style="max-width: 120px; max-height: 120px;">
                    @else
                        <div class="h3 text-primary font-weight-bold">SGS</div>
                    @endif
                </div>
                <div class="col-md-10 text-md-right">
                    <h2 class="mb-1 text-uppercase font-weight-bold" style="color: #042954;">{{ $ecole->nom ?? 'SGS - ÉCOLE' }}</h2>
                    <div style="font-size: 14px; color: #555;">
                        @if(isset($ecole) && $ecole->adresse) <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $ecole->adresse }}</span> @endif
                        @if(isset($ecole) && $ecole->telephone) <span class="ml-3"><i class="fas fa-phone mr-1"></i> {{ $ecole->telephone }}</span> @endif
                        @if(isset($ecole) && $ecole->email) <span class="ml-3"><i class="fas fa-envelope mr-1"></i> {{ $ecole->email }}</span> @endif
                    </div>
                </div>
            </div>

            <div class="heading-layout1">
                <div class="item-title">
                    <h3 class="text-uppercase" style="letter-spacing: 1px;">Bulletin de Notes - {{ $annee->annee }}{{ $periode ? ' (' . $periode->nom . ')' : '' }}</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.bulletins.download_pdf', ['classe' => $classe->id, 'student' => $bulletin['student']->id, 'periode_id' => $periode ? $periode->id : null]) }}">
                            <i class="fas fa-file-pdf text-danger"></i> Télécharger PDF
                        </a>
                        <a class="dropdown-item" href="#" onclick="window.print()"><i class="fas fa-print"></i> Imprimer</a>
                        <a class="dropdown-item"
                            href="{{ route('admin.bulletins.generate', ['classe' => $classe->id, 'periode_id' => $periode ? $periode->id : null]) }}"><i
                                class="fas fa-arrow-left"></i> Retour</a>
                    </div>
                </div>
            </div>

            <!-- Student Info -->
            <div class="row mb-4 border-bottom pb-3">
                <div class="col-md-2 text-center">
                    @if($bulletin['student']->photo)
                        <img src="{{ asset('storage/' . $bulletin['student']->photo) }}" alt="student" class="rounded-circle"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary mx-auto"
                            style="width: 100px; height: 100px; font-size: 2rem; font-weight: bold;">
                            {{ substr($bulletin['student']->prenom, 0, 1) }}{{ substr($bulletin['student']->nom, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="col-md-5">
                    <h5 class="mb-1">Nom: <span class="text-dark">{{ $bulletin['student']->nom }}</span></h5>
                    <h5 class="mb-1">Prénom: <span class="text-dark">{{ $bulletin['student']->prenom }}</span></h5>
                    <p class="mb-0">Matricule: <strong>{{ $bulletin['student']->matricule }}</strong></p>
                    <p class="mb-0">Date de naissance: <strong>{{ $bulletin['student']->date_naissance }}</strong></p>
                </div>
                <div class="col-md-5 text-md-right">
                    <h5 class="mb-1">Classe: <span class="text-dark">{{ $classe->nom }}</span></h5>
                    <h5 class="mb-1">Année Scolaire: <span class="text-dark">{{ $annee->annee }}</span></h5>
                    @if($periode)
                        <h5 class="mb-1">Période: <span class="text-dark">{{ $periode->nom }}</span></h5>
                    @endif
                    <div class="mt-2">
                        <span class="h5">Rang: <span
                                class="text-primary font-weight-bold">{{ $bulletin['rang'] }}{{ $bulletin['rang'] == 1 ? 'er' : ($bulletin['rang'] > 1 ? 'ème' : '') }}{{ $bulletin['is_ex'] ? ' ex' : '' }}</span>
                            / {{ $classStats['total_students'] }}</span>
                    </div>
                    <div class="mt-1">
                        <span class="h6 text-muted">Moyenne Classe:
                            {{ number_format($classStats['moyenne_generale'], 2) }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="h4 font-weight-bold">Moyenne:
                            <span class="{{ $bulletin['moyenne_generale'] < 10 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($bulletin['moyenne_generale'], 2) }} / 20
                            </span>
                        </span>
                    </div>
                    <div class="mt-1">
                        <span
                            class="badge {{ $bulletin['moyenne_generale'] >= 12 ? 'badge-success' : ($bulletin['moyenne_generale'] >= 10 ? 'badge-warning' : 'badge-danger') }} p-2">
                            @if($bulletin['moyenne_generale'] >= 18) FÉLICITATIONS (Excellent)
                            @elseif($bulletin['moyenne_generale'] >= 16) TRÈS BIEN (Tableau d'Honneur)
                            @elseif($bulletin['moyenne_generale'] >= 14) BIEN (Encouragements)
                            @elseif($bulletin['moyenne_generale'] >= 12) ASSEZ BIEN
                            @elseif($bulletin['moyenne_generale'] >= 10) PASSABLE
                            @else INSUFFISANT
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Marks Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Matière</th>
                            <th class="text-center">Coefficient</th>
                            <th class="text-center">Moyenne / 20</th>
                            <th class="text-center">Points</th>
                            <th>Appréciation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bulletin['matieres'] as $matiereId => $data)
                            <tr>
                                <td class="align-middle">
                                    <strong>{{ $data['nom'] }}</strong>
                                    @if(count($data['evaluations']) > 0)
                                        <br>
                                        <small class="text-muted">
                                            Détails:
                                            @foreach($data['evaluations'] as $eval)
                                                <span title="{{ $eval['libelle'] }} ({{ $eval['date'] }})">
                                                    {{ number_format($eval['note_sur_20'], 1) }}
                                                </span>{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </small>
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{ $data['coef'] }}</td>
                                <td class="text-center align-middle font-weight-bold">
                                    @if($data['moyenne'] !== null)
                                        <span class="{{ $data['moyenne'] < 10 ? 'text-danger' : 'text-dark' }}">
                                            {{ number_format($data['moyenne'], 2) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    {{ number_format($data['points'], 2) }}
                                </td>
                                <td class="align-middle">
                                    @if($data['moyenne'] !== null)
                                        @if($data['moyenne'] >= 16) Très Bien
                                        @elseif($data['moyenne'] >= 14) Bien
                                        @elseif($data['moyenne'] >= 12) Assez Bien
                                        @elseif($data['moyenne'] >= 10) Passable
                                        @else Insuffisant
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td class="text-right">TOTAL</td>
                            <td class="text-center">{{ $bulletin['total_coef'] }}</td>
                            <td class="text-center">
                                {{ number_format($bulletin['moyenne_generale'], 2) }}
                            </td>
                            <td class="text-center">{{ number_format($bulletin['total_points'], 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row mt-5">
                <div class="col-4 text-center">
                    <p><strong>L'enseignant titulaire</strong></p>
                    <br><br>
                </div>
                <div class="col-4 text-center">
                    <p><strong>Le Chef d'Etablissement</strong></p>
                    <br><br>
                </div>
                <div class="col-4 text-center">
                    <p><strong>Les Parents</strong></p>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@endsection