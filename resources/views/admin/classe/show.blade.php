 @extends('layouts.app')
 @section('title', 'liste des étudiants')
 @section('content')
<div class="breadcrumbs-area">
                    <h3>Étudiants</h3>
                    <ul>
                        <li>
                            <a href="index.html">Accueil</a>
                        </li>
                        <li>Détails de la classe</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Student Details Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>About Me</h3>
                            </div>
                           <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" 
                                data-toggle="dropdown" aria-expanded="false">...</a>
        
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-info-details">

                            <div class="item-content">
                                <div class="header-inline item-header">
                                    <h3 class="text-dark-medium font-medium">{{$classe->nom}}</h3>
                                    <div class="header-elements">
                                        <ul>
                                            <li><a href="#"><i class="far fa-edit"></i></a></li>
                                            <li><a href="#"><i class="fas fa-print"></i></a></li>
                                            <li><a href="#"><i class="fas fa-download"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p>Aliquam erat volutpat. Curabiene natis massa sedde lacu stiquen sodale 
                                word moun taiery.Aliquam erat volutpaturabiene natis massa sedde  sodale 
                                word moun taiery.</p>
                                <div class="info-table table-responsive">
                                    <table class="table text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td>Nombre d'étudiants:</td>
                                                <td class="font-medium text-dark-medium">{{$nombre_etudiants}}</td>
                                            </tr>
                                            <tr>
                                                <td>Nombre de femmes:</td>
                                                <td class="font-medium text-dark-medium">{{$nombre_de_femmes}}</td>
                                            </tr>
                                            <tr>
                                                <td>Nombre d'hommes:</td>
                                                <td class="font-medium text-dark-medium">{{$nombre_de_hommes}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Liste des étudiants</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Sexe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etudiants as $etudiant)
                                    <tr>
                                        <td>{{ $etudiant->matricule }}</td>
                                        <td>{{ $etudiant->nom }}</td>
                                        <td>{{ $etudiant->prenom }}</td>
                                        <td>{{ $etudiant->sexe }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Emploi du temps -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Emploi du temps - Classe: {{ $classe->nom }}</h3>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.create') }}?classe_id={{ $classe->id }}">
                                        <i class="fas fa-plus text-green"></i> Ajouter un créneau
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.index') }}?classe_id={{ $classe->id }}">
                                        <i class="fas fa-list text-blue"></i> Voir tous les créneaux
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            @if(count($emploiOrganise) > 0)
                            <table class="table table-bordered text-center" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f0f0f0; font-weight: bold; width: 120px;">Horaires</th>
                                        @foreach($joursSemaine as $jour)
                                            <th style="background-color: #e8f4f8; font-weight: bold;">{{ strtoupper($jour) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($emploiOrganise as $ligne)
                                    <tr>
                                        <td style="background-color: #f9f9f9; font-weight: bold; vertical-align: middle;">
                                            @if(!empty($ligne['debut']) && !empty($ligne['fin']))
                                                <div>{{ \Carbon\Carbon::parse($ligne['debut'])->format('H:i') }}</div>
                                                <div style="font-size: 0.9em; color: #666;">{{ \Carbon\Carbon::parse($ligne['fin'])->format('H:i') }}</div>
                                                @if($ligne['type'] !== 'cours')
                                                    <div style="font-size: 0.75em; color: #999; margin-top: 3px;">({{ $ligne['type'] }})</div>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @foreach($joursSemaine as $jour)
                                            <td style="padding: 12px; vertical-align: middle; min-height: 60px;">
                                                @if(isset($ligne['jours'][$jour]) && !empty($ligne['jours'][$jour]['matiere']))
                                                    @php
                                                        $cours = $ligne['jours'][$jour];
                                                    @endphp
                                                    <div style="font-weight: 600; color: #2c3e50; margin-bottom: 5px;">
                                                        {{ $cours['matiere'] }}
                                                    </div>
                                                    @if(!empty($cours['enseignant']))
                                                        <div style="font-size: 0.85em; color: #7f8c8d;">
                                                            <i class="fas fa-user"></i> {{ $cours['enseignant'] }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <span style="color: #bdc3c7;">—</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="alert alert-warning">
                                @if($totalEmploiDuTemps > 0)
                                    <p><strong><i class="fas fa-exclamation-triangle"></i> Attention :</strong> {{ $totalEmploiDuTemps }} emploi(s) du temps trouvé(s) pour cette classe, mais {{ $emploiIncomplets }} sont incomplets.</p>
                                    <p class="mb-2"><strong>Problèmes possibles :</strong></p>
                                    <ul class="mb-3">
                                        <li>Les relations avec les <strong>jours</strong>, <strong>horaires</strong> ou <strong>matières</strong> sont manquantes</li>
                                        <li>Les données référencées n'existent plus dans la base de données</li>
                                        <li>Les clés étrangères ne correspondent pas</li>
                                    </ul>
                                    <p class="mb-2"><strong>Solution :</strong> Vérifiez les logs Laravel pour plus de détails, ou modifiez/supprimez les emplois du temps incomplets.</p>
                                @else
                                    <p><i class="fas fa-info-circle"></i> Aucun emploi du temps n'a été configuré pour cette classe.</p>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('admin.emploi_du_temps.create') }}?classe_id={{ $classe->id }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Créer un emploi du temps pour cette classe
                                    </a>
                                    <a href="{{ route('admin.emploi_du_temps.index') }}?classe_id={{ $classe->id }}" class="btn btn-secondary btn-sm ml-2">
                                        <i class="fas fa-list"></i> Voir tous les emplois du temps
                                    </a>
                                    @if($totalEmploiDuTemps > 0 && $emploiIncomplets > 0)
                                        <a href="{{ route('admin.emploi_du_temps.index') }}?classe_id={{ $classe->id }}" class="btn btn-warning btn-sm ml-2">
                                            <i class="fas fa-exclamation-triangle"></i> Corriger les emplois du temps
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @endsection 
