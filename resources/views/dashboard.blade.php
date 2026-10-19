@extends('layouts.app')
@section('title', 'Tableau de bord - Akkhor Theme')

@section('content')
<div class="breadcrumbs-area mx-3 mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 font-weight-900" style="color: #111111;">Tableau de bord</h3>
            <ul class="d-flex align-items-center p-0" style="list-style: none; font-size: 0.9rem;">
                <li><a href="{{ route('dashboard') }}" class="text-muted">Tableau de bord</a></li>
                <li class="mx-2 text-muted">/</li>
                <li class="text-orange-peel font-bold"> Administrateur</li>
            </ul>
        </div>
        <div class="header-elements">
            <!-- Session Active Indicator -->
            @if($anneeActive)
            <div class=" bg-light-green text-dark-pastel-green px-4 py-2 rounded-pill font-bold size-15">
                <i class="fas fa-calendar-check mr-2"></i> Session {{ $anneeActive->annee }}
            </div>
            @endif
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <!-- Academic Pulse Statistics -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box blue shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-blue text-blue-sky">
                            <i class="flaticon-classmates"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Étudiants</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter" data-num="{{ $students }}">{{ $students }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box green shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-green text-dark-pastel-green">
                            <i class="flaticon-multiple-users-silhouette"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Enseignants</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter" data-num="{{ $teachers }}">{{ $teachers }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box yellow shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-yellow text-orange-peel">
                            <i class="flaticon-books"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Classes</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter" data-num="{{ $dashboardClasses }}">{{ $dashboardClasses }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="akkhor-stat-box red shadow-sm">
                <div class="card-body p-4 bg-white border-radius-15">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon bg-light-red text-orange-red">
                            <i class="flaticon-shopping-list text-red"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small text-uppercase font-bold tracking-1">Inscriptions</div>
                            <h2 class="mb-0 font-weight-900 text-dark-blue counter" data-num="{{ $inscriptionsCount }}">{{ $inscriptionsCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Pulse & Secondary Summaries Row -->
    <div class="row mb-5">
        <!-- Financial Summaries Section -->
        <div class="col-xl-7 col-12">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4 d-flex justify-content-between align-items-center">
                        <div class="item-title">
                            <h3 class="font-bold text-dark-medium"><i class="fas fa-hand-holding-usd text-dark-pastel-green mr-3"></i>Indicateurs Financiers</h3>
                        </div>
                        <a href="{{ route('frais_scolaires.index') }}" class="btn-fill-lmd text-light bg-true-v font-bold shadow-none border-none py-2 px-3 rounded small rounded-pill">
                            DÉTAILS FINANCIERS
                        </a>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="finance-card green shadow-sm p-4 border-radius-10">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="text-white small font-bold opacity-75">TOTAL ENCAISSÉ</div>
                                        <h3 class="text-white font-weight-900 mb-0 mt-2">{{ number_format($totalEncasse, 0, ',', ' ') }} FCFA</h3>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="finance-card red shadow-sm p-4 border-radius-10">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="text-white small font-bold opacity-75">RESTE À PERCEVOIR</div>
                                        <h3 class="text-white font-weight-900 mb-0 mt-2">{{ number_format($resteAPercevoir, 0, ',', ' ') }} FCFA</h3>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($overdueInvoices->count() > 0)
                    <div class="mt-2 text-center">
                        <div class="alert bg-light-red text-orange-red border-radius-pill py-3 px-4 d-inline-block font-bold shadow-none" style="border: 1px dashed #ff0000; cursor: pointer;" data-toggle="modal" data-target="#overdueModal">
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ $overdueInvoices->count() }} factures en retard de paiement
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Academic Summaries Column -->
        <div class="col-xl-5 col-12 mt-4 mt-xl-0">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title">
                            <h3 class="font-bold text-dark-medium"><i class="fas fa-layer-group text-blue-ky mr-3"></i>Synthèse Académique</h3>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6 mb-4 text-center border-right">
                            <div class="text-muted small text-uppercase font-bold mb-1 opacity-75 letter-spacing-1">Évaluations</div>
                            <h3 class="font-weight-900 text-dark-medium mb-0">{{ $evaluationsCount }}</h3>
                            <div class="badge-akkhor bg-light-blue text-blue-sky px-3 py-1 rounded-pill small mt-2 font-bold">{{ $evaluationsEnAttente }} en attente</div>
                        </div>
                        <div class="col-6 mb-4 text-center">
                            <div class="text-muted small text-uppercase font-bold mb-1 opacity-75 letter-spacing-1">Matières</div>
                            <h3 class="font-weight-900 text-dark-medium mb-0">{{ $matieresCount }}</h3>
                            <div class="badge-akkhor bg-light-yellow text-orange-peel px-3 py-1 rounded-pill small mt-2 font-bold">{{ $niveauxCount }} Niveaux</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top-akkhor">
                        <a href="{{ route('parametres_scolaires') }}" class="btn-fill-lmd font-bold text-light bg-dodger-blue btn-block mb-1 shadow-none rounded-pill py-3">
                            <i class="fas fa-cog mr-2"></i> Paramètres Scolaires & Gestion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section (Primary Distribution) -->
    <div class="row mb-5">
        <!-- Gender Mapping -->
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Répartition par sexe</h3></div>
                    </div>
                    <div class="doughnut-chart-wrap mb-4">
                        <canvas id="student-doughnut-chart" width="100" height="280"></canvas>
                    </div>
                    <div class="row mt-4 pt-4 border-top-akkhor text-center">
                        <div class="col-6 border-right">
                            <h2 class="font-weight-900 text-blue-sky mb-0">{{ $femaleStudents }}</h2>
                            <div class="small font-bold text-muted opacity-75">FILLES</div>
                        </div>
                        <div class="col-6">
                            <h2 class="font-weight-900 text-orange-peel mb-0">{{ $maleStudents }}</h2>
                            <div class="small font-bold text-muted opacity-75">GARÇONS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inscriptions Distribution -->
        <div class="col-lg-6">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Inscriptions par cycle</h3></div>
                    </div>
                    <div class="earning-chart-wrap" style="min-height: 380px;">
                        <canvas id="inscriptions-cycle-chart" width="100" height="380"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes Overview Table Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card height-auto border-none shadow-akkhor border-radius-10">
                <div class="card-body py-4 px-4">
                    <div class="heading-layout1 mb-4 d-flex justify-content-between align-items-center">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Perspective Globale des Classes</h3></div>
                        <a href="{{ route('admin.classe.index') }}" class="btn-fill-lmd text-light bg-dodger-blue font-bold shadow-none border-none py-2 px-4 rounded-pill small">GÉRER LES CLASSES</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap akkhor-table">
                            <thead>
                                <tr class="bg-ash">
                                    <th class="px-3">Classe</th>
                                    <th>Niveau</th>
                                    <th>Effectif</th>
                                    <th>Garçons</th>
                                    <th>Filles</th>
                                    <th>Matières</th>
                                    <th style="width: 250px;">Progression Capacité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classesOverview as $classe)
                                <tr>
                                    <td class="font-bold text-dark-medium px-3">{{ $classe->nom }}</td>
                                    <td class="font-medium text-dark-low small text-uppercase">{{ $classe->niveau->nom ?? '-' }}</td>
                                    <td><span class="badge-akkhor bg-light-blue text-blue-sky font-bold px-3 py-1 rounded-pill">{{ $classe->students_count }}</span></td>
                                    <td><span class="text-orange-peel font-bold">{{ $classe->male_count }}</span></td>
                                    <td><span class="text-blue-sky font-bold">{{ $classe->female_count }}</span></td>
                                    <td class="text-center">{{ $classe->matieres_count }}</td>
                                    <td>
                                        @php
                                            $capacity = 50;
                                            $percent = $capacity > 0 ? min(round(($classe->students_count / $capacity) * 100), 100) : 0;
                                            $barColor = $percent > 85 ? '#ff0000' : ($percent > 60 ? '#ffa001' : '#00c853');
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="progress w-100 mr-3" style="height: 6px; border-radius: 10px; background-color: #f0f1f3;">
                                                <div class="progress-bar" style="width: {{ $percent }}%; background-color: {{ $barColor }}; border-radius: 10px;"></div>
                                            </div>
                                            <span class="small font-bold" style="color: {{ $barColor }}; min-width: 35px;">{{ $percent }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-5">Aucune donnée disponible.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Charts & Summary Panel -->
    <div class="row">
        <!-- Effectifs Bar Chart -->
        <div class="col-xl-8 col-12 mb-4">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Occupation par Classe</h3></div>
                    </div>
                    <div class="expense-chart-wrap" style="min-height: 380px;">
                        <canvas id="students-per-class-chart" width="100" height="380"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary Panel -->
        <div class="col-xl-4 col-12 mb-4">
            <div class="card border-none shadow-akkhor border-radius-10 h-100">
                <div class="card-body py-4 px-5">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title"><h3 class="font-bold text-dark-medium mb-0">Réseau d'Enseignement</h3></div>
                    </div>
                    <div class="mt-4">
                        <div class="summery-list p-4 bg-ash border-radius-10 mb-4 hover-lift">
                            <div class="d-flex align-items-center">
                                <div class="item-icon bg-light-blue text-blue-sky rounded-pill mr-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <div class="text-muted small font-bold">ENSEIGNANTS ACTIFS</div>
                                    <div class="h5 font-weight-900 text-dark-medium mb-0">{{ $teachers }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="summery-list p-4 bg-ash border-radius-10 mb-4 hover-lift">
                            <div class="d-flex align-items-center">
                                <div class="item-icon bg-light-yellow text-orange-peel rounded-pill mr-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-chalkboard"></i></div>
                                <div>
                                    <div class="text-muted small font-bold">SALLES / CLASSES</div>
                                    <div class="h5 font-weight-900 text-dark-medium mb-0">{{ $dashboardClasses }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="summery-list p-4 bg-light-green border-radius-10 mb-4 hover-lift" style="border: 1px solid #c6f6d5;">
                            <div class="d-flex align-items-center">
                                <div class="item-icon bg-white text-dark-pastel-green shadow-sm rounded-pill mr-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-graduation-cap"></i></div>
                                <div>
                                    <div class="text-dark-pastel-green small font-bold">TOTAL ÉLÈVES</div>
                                    <div class="h5 font-weight-900 text-dark-blue mb-0">{{ $students }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Overdue Invoices -->
<div class="modal fade" id="overdueModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-none border-radius-10 overflow-hidden shadow-lg">
            <div class="modal-header bg-light-red py-4 px-5 border-none">
                <h5 class="modal-title text-orange-red font-bold"><i class="fas fa-exclamation-circle mr-3"></i>Factures en retard de paiement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table hover-table mb-0">
                        <thead class="bg-ash">
                            <tr>
                                <th class="px-5">ÉLÈVE / FAMILLE</th>
                                <th>CLASSE</th>
                                <th>ÉCHÉANCE</th>
                                <th>RESTE DU</th>
                                <th class="text-right px-5">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overdueInvoices as $invoice)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-dark-medium">{{ $invoice->inscription->student->nom }} {{ $invoice->inscription->student->prenom }}</div>
                                    <span class="small text-muted opacity-75">ID: #{{ $invoice->id }}</span>
                                </td>
                                <td class="font-bold">{{ $invoice->inscription->classe->nom ?? '-' }}</td>
                                <td class="text-orange-red font-bold small">{{ \Carbon\Carbon::parse($invoice->date_echeance)->format('d/m/Y') }}</td>
                                <td class="font-weight-900 text-dark-blue">{{ number_format($invoice->reste, 0, ',', ' ') }} FCFA</td>
                                <td class="text-right px-5">
                                    <a href="{{ route('admin.inscription.show', $invoice->inscription_id) }}" class="btn-fill-sm bg-dodger-blue text-light font-bold shadow-none rounded py-2 px-3 small"><i class="fas fa-eye mr-1"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-white border-top-akkhor py-3">
                <button type="button" class="btn-fill-lmd bg-ash text-dark-low font-bold shadow-none border-none py-2 px-4 rounded-pill small" data-dismiss="modal">FERMER</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Akkhor Reorganization Overrides */
    .font-weight-900 { font-weight: 900; }
    .tracking-1 { letter-spacing: 1px; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .border-radius-15 { border-radius: 15px; }
    .border-radius-10 { border-radius: 10px; }
    .shadow-akkhor { box-shadow: 0px 10px 20px 0px rgba(229, 229, 229, 0.75); }
    .hover-lift:hover { transform: translateY(-5px); transition: 0.3s; }
    .border-none { border: none !important; }
    
    /* Soft Colors Extension */
    .text-blue-sky { color: #3f7afc !important; }
    .bg-light-blue { background-color: #eff6ff !important; }
    .text-dark-blue { color: #042954 !important; }
    .text-dark-pastel-green { color: #00c853 !important; }
    .bg-light-green { background-color: #ecfdf5 !important; }
    .text-orange-peel { color: #ffa001 !important; }
    .bg-light-yellow { background-color: #fffbeb !important; }
    .text-orange-red { color: #ff0000 !important; }
    .bg-light-red { background-color: #fff1f2 !important; }
    .bg-ash { background-color: #f0f1f3 !important; }
    .bg-true-v { background-color: #9575cd !important; }
    .bg-dodger-blue { background-color: #2196f3 !important; }
    .border-top-akkhor { border-top: 1px solid #e5eef5 !important; }

    /* Stat Box Custom */
    .stat-icon {
        width: 55px; height: 55px; border-radius: 15px;
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
    }

    /* Financial Indicators */
    .finance-card { min-height: 120px; display: flex; align-items: center; transition: all 0.3s ease; }
    .finance-card.green { background: #00c853; }
    .finance-card.red { background: #ff0000; }
    .finance-card:hover { filter: brightness(1.1); transform: scale(1.02); }
    .finance-icon { width: 50px; height: 50px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }

    /* Table Improvements */
    .akkhor-table thead th {
        font-weight: 700; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;
        background-color: #f0f1f3; color: #111111; border: none !important;
    }
    .akkhor-table tbody td { vertical-align: middle; padding: 15px 20px; border-bottom: 1px solid #f1f3f5; }

    /* Modal Styling */
    .hover-table tr:hover { background-color: #fafbfc; }
    .badge-akkhor { font-size: 0.8rem; }
    .btn-fill-sm { padding: 8px 15px; }
</style>

<!-- Pass statistics to Chart Script -->
<script>
    window.studentStats = { female: {{ $femaleStudents }}, male: {{ $maleStudents }} };
    window.inscriptionsByCycle = @json($inscriptionsByCycle);
    window.studentsPerClass = @json($studentsPerClass);
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Student Doughnut
    var genderCtx = document.getElementById('student-doughnut-chart');
    if (genderCtx) {
        new Chart(genderCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Filles', 'Garçons'],
                datasets: [{
                    data: [window.studentStats.female, window.studentStats.male],
                    backgroundColor: ['#3f7afc', '#ffa001'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, legend: { display: false }, cutoutPercentage: 70 }
        });
    }

    // Cycles Distribution
    var cycleCtx = document.getElementById('inscriptions-cycle-chart');
    if (cycleCtx && window.inscriptionsByCycle) {
        var cycleColors = ['#042954', '#ffa001', '#00c853', '#ff0000', '#3f7afc', '#9575cd'];
        new Chart(cycleCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: window.inscriptionsByCycle.map(item => item.label),
                datasets: [{
                    data: window.inscriptionsByCycle.map(item => item.count),
                    backgroundColor: cycleColors.slice(0, window.inscriptionsByCycle.length),
                    borderWidth: 2, borderColor: '#fff'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, legend: { position: 'bottom', labels: { padding: 20, fontStyle: 'bold' } } }
        });
    }

    // Classes Bar Chart
    var classCtx = document.getElementById('students-per-class-chart');
    if (classCtx && window.studentsPerClass) {
        new Chart(classCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: window.studentsPerClass.map(item => item.label),
                datasets: [{
                    label: 'Étudiants',
                    data: window.studentsPerClass.map(item => item.count),
                    backgroundColor: ['#3f7afc', '#ffa001', '#00c853', '#ff0000', '#3f7afc', '#9575cd', '#00c853', '#ff0000', '#3f7afc', '#9575cd', '#00c853', '#ff0000', '#3f7afc', '#9575cd'],

                    borderRadius: 8,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, legend: { display: false },
                scales: {
                    yAxes: [{ gridLines: { color: "#f1f3f5" }, ticks: { beginAtZero: true, fontStyle: 'bold' } }],
                    xAxes: [{ gridLines: { display: false }, ticks: { fontStyle: 'bold' } }]
                }
            }
        });
    }
});
</script>
@endpush
