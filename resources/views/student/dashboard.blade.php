@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Tableau de Bord Élève</h3>
        <ul>
            <li>
                <a href="{{ route('student.dashboard') }}">Accueil</a>
            </li>
            <li>Dashboard</li>
        </ul>
    </div>

    <!-- Dashboard summery Start Here -->
    <div class="row gutters-20">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-magenta">
                            <i class="flaticon-shopping-list text-magenta"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Mes Notes</div>
                            <div class="item-number"><span>{{ $notesCount }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-calendar text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Absences</div>
                            <div class="item-number"><span>{{ $absencesCount }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-yellow">
                            <i class="flaticon-technological text-orange"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Reste à Payer</div>
                            <div class="item-number"><span>{{ number_format($resteAPayer, 0, ',', ' ') }} FCFA</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-red">
                            <i class="flaticon-script text-red"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Année</div>
                            <div class="item-number"><span>{{ $anneeActive->nom ?? 'N/A' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard summery End Here -->

    <div class="row gutters-20">
        <div class="col-12 col-xl-8 col-6-xxxl">
            <div class="card dashboard-card-one pd-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Notes Récentes</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Période</th>
                                    <th>Evaluation</th>
                                    <th>Note</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentNotes as $note)
                                <tr>
                                    <td>{{ $note->evaluation->matiere->nom }}</td>
                                    <td>{{ $note->evaluation->periode->nom }}</td>
                                    <td>{{ $note->evaluation->nom }}</td>
                                    <td>
                                        <span class="badge {{ $note->note >= 10 ? 'badge-success' : 'badge-danger' }}" style="font-size: 1rem;">
                                            {{ $note->note }}/20
                                        </span>
                                    </td>
                                    <td>{{ $note->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucune note enregistrée pour le moment.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-20 text-center">
                        <a href="{{ route('student.notes') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Voir tout mon relevé</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 col-3-xxxl">
            <div class="card dashboard-card-two pd-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Ma Classe</h3>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <div class="item-img" style="width: 100px; height: 100px; margin: 0 auto;">
                            <img src="{{ url('img/figure/student.png') }}" alt="student" class="rounded-circle">
                        </div>
                        <div class="item-content mg-t-20">
                            <h4 class="item-title">{{ $student->nom }} {{ $student->prenom }}</h4>
                            <p>Classe : <strong>{{ $inscription->classe->nom ?? 'Non affecté' }}</strong></p>
                            <p>Matricule : <strong>{{ $student->matricule }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
