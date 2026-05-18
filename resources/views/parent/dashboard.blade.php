@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Espace Parent</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Tableau de bord</li>
        </ul>
    </div>
    @if($parent)
    <!-- Student Selection Tabs -->
    <div class="row gutters-20 mg-b-20">
        <div class="col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Mes Enfants</h3>
                        </div>
                    </div>
                    <div class="row gutters-10">
                        @foreach($students as $student)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <a href="{{ route('parent.select_student', $student->id) }}" 
                                   class="student-card {{ $selectedStudent && $selectedStudent->id == $student->id ? 'active' : '' }}">
                                    <div class="card-content d-flex align-items-center p-3">
                                        <div class="item-img mr-3">
                                            @if($student->photo)
                                                <img src="{{ url('storage/'.$student->photo) }}" alt="student" style="width: 50px; height: 50px; border-radius: 50%;">
                                            @else
                                                <div class="bg-light-blue p-3 rounded-circle">
                                                    <i class="fas fa-user text-blue"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="item-title">
                                            <h6 class="mb-0 text-dark font-weight-bold">{{ $student->nom }} {{ $student->prenom }}</h6>
                                            <span class="text-muted small">{{ $student->classe->nom ?? 'Non affecté' }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($selectedStudent)
    <!-- Selected Student Stats -->
    <div class="row gutters-20">
        <!-- Quick Stats -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-script text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title text-muted">Notes</div>
                            <div class="item-number"><span>{{ $recentNotes->count() }}</span> Récents</div>
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
                            <i class="flaticon-calendar text-yellow"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title text-muted">Absences</div>
                            <div class="item-number"><span>{{ $recentPresences->where('statut', 'absent')->count() }}</span> Total</div>
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
                            <i class="flaticon-money text-red"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title text-muted">À payer</div>
                            <div class="item-number"><span>{{ number_format($unpaidFactures->sum('reste'), 0, ',', ' ') }}</span> FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-green">
                            <i class="flaticon-calendar text-green"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title text-muted">Année</div>
                            <div class="item-number"><span>{{ $anneeActive->annee ?? 'N/A' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Recent Notes -->
        <div class="col-lg-6 col-12">
            <div class="card dashboard-card-six height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Dernières Notes</h3>
                        </div>
                        <div class="dropdown">
                            <a class="text-blue" href="{{ route('parent.notes') }}">Voir tout</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Évaluation</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentNotes as $note)
                                    <tr>
                                        <td>{{ $note->evaluation->matiere->nom ?? '-' }}</td>
                                        <td>{{ $note->evaluation->titre }}</td>
                                        <td class="font-weight-bold {{ $note->note < 10 ? 'text-red' : 'text-success' }}">
                                            {{ $note->note }} / 20
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">Aucune note enregistrée</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-lg-6 col-12">
            <div class="card dashboard-card-six height-auto">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-20">
                        <div class="item-title">
                            <h3>Présences Récentes</h3>
                        </div>
                        <div class="dropdown">
                            <a class="text-blue" href="{{ route('parent.presences') }}">Voir tout</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPresences as $presence)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($presence->date)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($presence->statut == 'présent')
                                                <span class="badge badge-success px-3">PRÉSENT</span>
                                            @elseif($presence->statut == 'absent')
                                                <span class="badge badge-danger px-3">ABSENT</span>
                                            @else
                                                <span class="badge badge-warning px-3">RETARD</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center">Aucun relevé de présence</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">Aucun enfant n'est rattaché à votre profil. Veuillez contacter l'administration.</div>
    @endif

    @else
    {{-- Aucun profil parent lié à ce compte --}}
    <div class="card height-auto">
        <div class="card-body text-center py-5">
            <i class="fas fa-user-slash fa-4x text-muted mb-4"></i>
            <h4 class="text-muted mb-3">Aucun profil parent associé</h4>
            <p class="text-muted">Votre compte utilisateur n'est pas encore lié à un profil parent dans le système.<br>
            Veuillez contacter l'administration de l'établissement pour faire le lien.</p>
        </div>
    </div>
    @endif

    <style>
        .student-card {
            display: block;
            border: 2px solid #f0f1f3;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            background: #fff;
            margin-bottom: 10px;
        }
        .student-card:hover {
            border-color: #ffae01;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .student-card.active {
            border-color: #ffae01;
            background: #fff9ed;
        }
        .student-card.active .item-title h6 {
            color: #ffae01;
        }
    </style>
@endsection
