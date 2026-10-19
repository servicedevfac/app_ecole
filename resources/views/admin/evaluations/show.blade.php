@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Détails de l'évaluation</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>
                <a href="{{ route('admin.evaluations.index') }}">Évaluations</a>
            </li>
            <li>Détails</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{ $evaluation->libelle }}</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if($evaluation->statut !== 'validee')
                            <a class="dropdown-item" href="{{ route('admin.evaluations.notes.create', $evaluation->id) }}">
                                <i class="fas fa-pen text-green"></i> Saisir notes
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.evaluations.edit', $evaluation->id) }}">
                                <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('admin.evaluations.index') }}">
                            <i class="fas fa-arrow-left text-blue"></i> Retour
                        </a>
                    </div>
                </div>
            </div>

            <div class="single-info-details">
                <div class="item-content">
                    <div class="header-inline item-header">
                        <h3 class="text-dark-medium font-medium">{{ $evaluation->matiere->nom }}</h3>
                        <div class="header-elements">
                            <ul>
                                <li><a href="#"><i class="fas fa-print"></i></a></li>
                                <li><a href="#"><i class="fas fa-download"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="info-table table-responsive">
                        <table class="table text-nowrap">
                            <tbody>
                                <tr>
                                    <td>Classe:</td>
                                    <td class="font-medium text-dark-medium">{{ $evaluation->classe->nom }}</td>
                                </tr>
                                <tr>
                                    <td>Enseignant:</td>
                                    <td class="font-medium text-dark-medium">{{ $evaluation->enseignant->nom }}
                                        {{ $evaluation->enseignant->prenom }}</td>
                                </tr>
                                <tr>
                                    <td>Période:</td>
                                    <td class="font-medium text-dark-medium">{{ $evaluation->periode->nom ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td class="font-medium text-dark-medium">
                                        {{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td class="font-medium text-dark-medium">{{ $evaluation->type }}</td>
                                </tr>
                                <tr>
                                    <td>Coefficient:</td>
                                    <td class="font-medium text-dark-medium">{{ $evaluation->coefficient }}</td>
                                </tr>
                                <tr>
                                    <td>Note Max:</td>
                                    <td class="font-medium text-dark-medium">{{ $evaluation->note_max }}</td>
                                </tr>
                                <tr>
                                    <td>Statut:</td>
                                    <td class="font-medium text-dark-medium">
                                        @if($evaluation->statut === 'validee')
                                            <span class="badge badge-success">Validée</span>
                                        @else
                                            <span class="badge badge-warning">Brouillon</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="heading-layout1 mt-5">
                <div class="item-title">
                    <h3>Liste des notes</h3>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>Note (/{{ $evaluation->note_max }})</th>
                            <th>Appréciation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $note = $student->notes->first();
                            @endphp
                            <tr>
                                <td>{{ $student->matricule }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}" alt="student"
                                                class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle mr-2 bg-light d-flex align-items-center justify-content-center text-secondary"
                                                style="width: 30px; height: 30px; font-weight: bold;">
                                                {{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}
                                            </div>
                                        @endif
                                        {{ $student->nom }} {{ $student->prenom }}
                                    </div>
                                </td>
                                <td>
                                    @if($note)
                                        <span
                                            class="font-weight-bold {{ $note->note < ($evaluation->note_max / 2) ? 'text-danger' : 'text-success' }}">
                                            {{ $note->note }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $note ? $note->appreciation : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection