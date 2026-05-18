@extends('layouts.app')
@section('title', 'Détails du Parent')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Parents / Tuteurs</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.parent.index') }}">Parents</a></li>
            <li>Détails</li>
        </ul>
    </div>
    
    <!-- Parent Profile Header -->
    <div class="card height-auto mg-b-20">
        <div class="card-body">
            <div class="single-info-details">
                <div class="item-img">
                    <div style="width: 150px; height: 150px; border-radius: 50%; background: #061557ff; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 48px; border: 4px solid #e8e8e8;">
                        {{ strtoupper(substr($parent->prenom, 0, 1)) }}{{ strtoupper(substr($parent->nom, 0, 1)) }}
                    </div>
                </div>
                <div class="item-content">
                    <div class="header-inline item-header">
                        <h3 class="text-dark-medium font-medium">{{ $parent->prenom }} {{ $parent->nom }}</h3>
                        <div class="header-elements">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.parent.edit', $parent->id) }}" title="Modifier">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:window.print()" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap mt-2" style="gap: 10px;">
                        <span class="badge" style="background-color: #667eea; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 13px;">
                            <i class="fas fa-envelope mg-r-5"></i> {{ $parent->email ?? 'Aucun email' }}
                        </span>
                        <span class="badge" style="background-color: #4facfe; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 13px;">
                            <i class="fas fa-phone mg-r-5"></i> {{ $parent->telephone }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Personal Information -->
        <div class="col-12 col-xl-6">
            <div class="card height-auto mg-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3><i class="fas fa-user text-dark-pastel-green mg-r-10"></i>Informations personnelles</h3>
                        </div>
                    </div>
                    <div class="info-table table-responsive mt-3">
                        <table class="table text-nowrap" style="border-top: none;">
                            <tbody >
                                <tr>
                                    <td style="width: 180px; color: #6c757d;"><i class="fas fa-user mg-r-8"></i>Nom complet</td>
                                    <td class="font-medium text-dark-medium">{{ $parent->nom }} {{ $parent->prenom }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-envelope mg-r-8"></i>E-mail</td>
                                    <td class="font-medium text-dark-medium">{{ $parent->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-phone mg-r-8"></i>Téléphone</td>
                                    <td class="font-medium text-dark-medium">{{ $parent->telephone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-mobile-alt mg-r-8"></i>Autre Téléphone</td>
                                    <td class="font-medium text-dark-medium">{{ $parent->autre_telephone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-map-marker-alt mg-r-8"></i>Adresse</td>
                                    <td class="font-medium text-dark-medium">{{ $parent->adresse ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6c757d;"><i class="fas fa-calendar-plus mg-r-8"></i>Date d'ajout</td>
                                    <td class="font-medium text-dark-medium">{{ $parent->created_at->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Children / Students -->
        <div class="col-12 col-xl-6">
            <div class="card height-auto mg-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3><i class="fas fa-user-graduate text-orange-peel mg-r-10"></i>Enfants / Élèves</h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        @forelse($parent->students as $student)
                            <div class="d-flex align-items-center p-3 mb-2" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #4facfe;">
                                <div style="width: 45px; height: 45px; border-radius: 50%; background: #061557ff; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 16px; margin-right: 15px;">
                                    {{ strtoupper(substr($student->prenom, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.etudiant.show', $student->id) }}" class="text-dark">
                                        <strong>{{ $student->nom }} {{ $student->prenom }}</strong>
                                    </a>
                                    @if($student->pivot && $student->pivot->relation)
                                        <span class="badge ml-2" style="background-color: #e3f2fd; color: #1976d2; padding: 2px 8px; border-radius: 8px; font-size: 11px;">
                                            {{ $student->pivot->relation }}
                                        </span>
                                    @endif
                                    <div class="mt-1" style="font-size: 13px; color: #6c757d;">
                                        <i class="fas fa-id-card mg-r-5"></i> Matricule: {{ $student->matricule }}
                                        @if($student->classe)
                                            <span class="mg-l-10"><i class="fas fa-chalkboard mg-r-5"></i> Classe: {{ $student->classe->nom }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-user-graduate fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                Aucun enfant associé
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
