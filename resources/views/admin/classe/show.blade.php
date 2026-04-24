@extends('layouts.app')
@section('title', 'Détails de la Classe : ' . $classe->nom)

@section('content')
<div class="breadcrumbs-area mx-3 mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 font-weight-bold" style="color: #2c3e50;">{{ $classe->nom }}</h3>
            <ul class="d-flex align-items-center p-0" style="list-style: none; font-size: 0.9rem;">
                <li><a href="{{ route('dashboard') }}" class="text-muted">Tableau de bord</a></li>
                <li class="mx-2 text-muted">/</li>
                <li><a href="{{ route('admin.classe.index') }}" class="text-muted">Classes</a></li>
                <li class="mx-2 text-muted">/</li>
                <li class="text-primary font-weight-600">Détails</li>
            </ul>
        </div>
        <div class="header-elements">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.classe.edit', $classe->id) }}" class="btn btn-primary shadow-sm px-4">
                    <i class="far fa-edit mr-2"></i> Modifier
                </a>
                <button onclick="window.print()" class="btn btn-white shadow-sm border px-3">
                    <i class="fas fa-print"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-white shadow-sm border px-3" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 border-radius-10 mt-2">
                        <a class="dropdown-item py-2" href="#"><i class="fas fa-file-pdf text-danger mr-2"></i>Exporter PDF</a>
                        <a class="dropdown-item py-2" href="#"><i class="fas fa-file-excel text-success mr-2"></i>Exporter Excel</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.classe.destroy', $classe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette classe ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-trash-alt mr-2"></i>Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <!-- Statistics Cards Section -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="glass-card stat-card blue">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase mb-1 small font-weight-bold opacity-75">Étudiants Inscrits</p>
                            <h2 class="mb-0 font-weight-bold">{{ $nombre_etudiants }}</h2>
                        </div>
                        <div class="icon-shape shadow-sm rounded-circle bg-white text-blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress progress-xs mb-0 bg-white-transparent">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="glass-card stat-card pink">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase mb-1 small font-weight-bold opacity-75">Filles (Femmes)</p>
                            <h2 class="mb-0 font-weight-bold">{{ $nombre_de_femmes }}</h2>
                        </div>
                        <div class="icon-shape shadow-sm rounded-circle bg-white text-pink">
                            <i class="fas fa-female"></i>
                        </div>
                    </div>
                    <div class="mt-2 small opacity-75 d-flex align-items-center">
                        <i class="fas fa-chart-pie mr-1"></i>
                        <span>{{ $nombre_etudiants > 0 ? round(($nombre_de_femmes / $nombre_etudiants) * 100) : 0 }}% de la classe</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="glass-card stat-card indigo">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase mb-1 small font-weight-bold opacity-75">Garçons (Hommes)</p>
                            <h2 class="mb-0 font-weight-bold">{{ $nombre_de_hommes }}</h2>
                        </div>
                        <div class="icon-shape shadow-sm rounded-circle bg-white text-indigo">
                            <i class="fas fa-male"></i>
                        </div>
                    </div>
                    <div class="mt-2 small opacity-75 d-flex align-items-center">
                        <i class="fas fa-chart-pie mr-1"></i>
                        <span>{{ $nombre_etudiants > 0 ? round(($nombre_de_hommes / $nombre_etudiants) * 100) : 0 }}% de la classe</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="glass-card stat-card orange">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase mb-1 small font-weight-bold opacity-75">Niveau Scolaire</p>
                            <h2 class="mb-0 font-weight-bold" style="font-size: 1.5rem;">{{ $classe->niveau->nom }}</h2>
                        </div>
                        <div class="icon-shape shadow-sm rounded-circle bg-white text-orange">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                    <div class="mt-2 small opacity-75 d-flex align-items-center text-truncate">
                        <i class="fas fa-layer-group mr-1"></i>
                        <span>Cycle: {{ $classe->niveau->cycle->nom ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section with Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 border-radius-15 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-0">
                    <ul class="nav nav-pills custom-pills" id="classeTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="students-tab" data-toggle="pill" href="#students" role="tab"><i class="fas fa-user-graduate mr-2"></i>Liste des Élèves</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="schedule-tab" data-toggle="pill" href="#schedule" role="tab"><i class="fas fa-calendar-alt mr-2"></i>Emploi du Temps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab"><i class="fas fa-chalkboard-teacher mr-2"></i>Équipe Pédagogique</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="classeTabContent">
                        <!-- Tab: Students List -->
                        <div class="tab-pane fade show active p-4" id="students" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 font-weight-bold">Effectif de la classe</h4>
                                <a href="{{ route('admin.etudiant.create') }}?classe_id={{ $classe->id }}" class="btn btn-success btn-sm shadow-sm">
                                    <i class="fas fa-plus mr-1"></i> Inscrire un nouvel élève
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th>Matricule</th>
                                            <th>Nom Complet</th>
                                            <th>Genre</th>
                                            <th>Contact Parents</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($etudiants as $etudiant)
                                        <tr>
                                            <td>
                                                <div class="avatar-circle">
                                                    @if($etudiant->photo)
                                                        <img src="{{ url('storage/' . $etudiant->photo) }}" alt="Avatar">
                                                    @else
                                                        <span class="avatar-label">{{ strtoupper(substr($etudiant->nom, 0, 1) . substr($etudiant->prenom, 0, 1)) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td><span class="badge badge-light-primary px-3 py-2 font-weight-bold">{{ $etudiant->matricule }}</span></td>
                                            <td>
                                                <div class="font-weight-600 text-dark">{{ $etudiant->nom }} {{ $etudiant->prenom }}</div>
                                                <div class="small text-muted">{{ $etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->age . ' ans' : 'Âge N/A' }}</div>
                                            </td>
                                            <td>
                                                @if($etudiant->sexe === 'F')
                                                    <span class="badge badge-outline-pink px-2"><i class="fas fa-female mr-1"></i> Feminin</span>
                                                @else
                                                    <span class="badge badge-outline-blue px-2"><i class="fas fa-male mr-1"></i> Masculin</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="small">{{ $etudiant->phone ?? 'N/A' }}</div>
                                                <div class="small text-muted text-truncate" style="max-width: 150px;">{{ $etudiant->email ?? '' }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="d-flex justify-content-end gap-1">
                                                    <a href="{{ route('admin.etudiant.show', $etudiant->id) }}" class="btn btn-icon btn-light btn-sm" title="Voir profil"><i class="fas fa-eye text-primary"></i></a>
                                                    <a href="{{ route('admin.etudiant.edit', $etudiant->id) }}" class="btn btn-icon btn-light btn-sm" title="Modifier"><i class="fas fa-pen text-info"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <img src="{{ url('img/figure/empty.png') }}" alt="Vide" style="max-width: 150px; opacity: 0.5;">
                                                <p class="mt-3 text-muted">Aucun élève trouvé dans cette classe.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab: Schedule -->
                        <div class="tab-pane fade p-4" id="schedule" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 font-weight-bold">Grille horaire de la semaine</h4>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.emploi_du_temps.create') }}?classe_id={{ $classe->id }}" class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="fas fa-plus mr-1"></i> Gérer l'emploi du temps
                                    </a>
                                </div>
                            </div>
                            
                            @if(count($emploiOrganise) > 0)
                            <div class="table-responsive">
                                <table class="table timetable-grid text-center">
                                    <thead>
                                        <tr>
                                            <th class="time-col">Heure</th>
                                            @foreach($joursSemaine as $jour)
                                                <th class="day-col">{{ $jour }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($emploiOrganise as $ligne)
                                        <tr>
                                            <td class="time-slot font-weight-bold">
                                                <span class="time-start">{{ \Carbon\Carbon::parse($ligne['debut'])->format('H:i') }}</span>
                                                <span class="time-divider"></span>
                                                <span class="time-end text-muted small">{{ \Carbon\Carbon::parse($ligne['fin'])->format('H:i') }}</span>
                                            </td>
                                            @foreach($joursSemaine as $jour)
                                                <td class="class-cell-container">
                                                    @if(isset($ligne['jours'][$jour]) && !empty($ligne['jours'][$jour]['matiere']))
                                                        @php
                                                            $cours = $ligne['jours'][$jour];
                                                            $colors = ['#e3f2fd', '#fce4ec', '#f3e5f5', '#e8f5e9', '#fff3e0'];
                                                            $bgColor = $colors[abs(crc32($cours['matiere'])) % count($colors)];
                                                        @endphp
                                                        <div class="class-cell shadow-sm" style="background-color: {{ $bgColor }};">
                                                            <div class="matiere-name">{{ $cours['matiere'] }}</div>
                                                            @if(!empty($cours['enseignant']))
                                                                <div class="enseignant-name small text-muted"><i class="far fa-user mr-1"></i>{{ $cours['enseignant'] }}</div>
                                                            @endif
                                                        </div>
                                                    @elseif($ligne['type'] !== 'cours')
                                                        <div class="break-cell">
                                                            <span class="text-uppercase small font-weight-bold opacity-50">{{ $ligne['type'] }}</span>
                                                        </div>
                                                    @else
                                                        <div class="empty-cell"></div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 border-dashed rounded-15 bg-light">
                                <div class="bg-white icon-shape shadow-sm rounded-circle text-warning mx-auto mb-3">
                                    <i class="far fa-calendar-times"></i>
                                </div>
                                <h5 class="font-weight-600">Aucun planning configuré</h5>
                                <p class="text-muted">L'emploi du temps de cette classe n'a pas encore été généré.</p>
                                <a href="{{ route('admin.emploi_du_temps.create') }}?classe_id={{ $classe->id }}" class="btn btn-outline-primary btn-sm rounded-pill mt-2 px-4 font-weight-bold">
                                    Configurer maintenant
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Tab: Pedagogical Team -->
                        <div class="tab-pane fade p-4" id="team" role="tabpanel">
                            <h4 class="mb-4 font-weight-bold">Matières et Enseignants Responsables</h4>
                            <div class="row">
                                @php
                                    // Utilisation de la relation matieres de la classe
                                    $classeMatieres = $classe->matieres ?? collect();
                                @endphp
                                @forelse($classeMatieres as $matiere)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card shadow-sm h-100 border-radius-15 hover-y">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="badge badge-light-blue px-3 py-2 font-weight-bold">{{ $matiere->code ?? 'MAT' }}</div>
                                                <div class="text-primary font-weight-bold small">Coeff: {{ $matiere->pivot->coefficient ?? '1' }}</div>
                                            </div>
                                            <h5 class="font-weight-700 mb-3">{{ $matiere->nom }}</h5>
                                            
                                            <!-- Trouver l'enseignant affecté à cette matière pour cette classe -->
                                            @php
                                                $affectation = \App\Models\AffectationsPedagogiques::where('classe_id', $classe->id)
                                                    ->where('matiere_id', $matiere->id)
                                                    ->first();
                                                $enseignant = $affectation ? $affectation->enseignant : null;
                                            @endphp
                                            
                                            <div class="d-flex align-items-center mt-auto p-2 bg-light border-radius-10">
                                                <div class="avatar-sm rounded-circle bg-white mr-2 border">
                                                    <i class="fas fa-user-circle text-muted"></i>
                                                </div>
                                                <div class="small">
                                                    <div class="font-weight-600 text-dark">{{ $enseignant ? ($enseignant->nom . ' ' . $enseignant->prenom) : 'Non affecté' }}</div>
                                                    <div class="small text-muted">{{ $enseignant ? 'Enseignant principal' : 'Veuillez assigner un prof' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted">Aucune matière affectée spécifiquement à cette classe dans le registre des coefficients.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Look & Glassmorphism */
    .border-radius-10 { border-radius: 10px; }
    .border-radius-15 { border-radius: 15px; }
    .font-weight-600 { font-weight: 600; }
    .font-weight-700 { font-weight: 700; }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(5px);
        color: white;
    }
    
    .stat-card.blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stat-card.pink { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
    .stat-card.indigo { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-card.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    
    .bg-white-transparent { background: rgba(255, 255, 255, 0.3); }
    
    .icon-shape {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .text-blue { color: #0093E9; }
    .text-pink { color: #FF416C; }
    .text-indigo { color: #764ba2; }
    .text-orange { color: #f5576c; }
    
    /* Tabs & Navigation */
    .custom-pills .nav-link {
        color: #7f8c8d;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s;
    }
    .custom-pills .nav-link.active {
        background-color: #f0f7ff !important;
        color: #2b7cfc !important;
        box-shadow: none;
    }
    
    /* Tables */
    .custom-table thead th {
        background-color: #f8f9fa;
        color: #7f8c8d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-top: none;
        padding: 15px;
    }
    .custom-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }
    
    /* Avatar Circle */
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .avatar-circle img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-label { font-weight: bold; color: #6c757d; font-size: 0.8rem; }
    
    .avatar-sm { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
    
    /* Badges */
    .badge-light-primary { background-color: #e7f1ff; color: #0d6efd; }
    .badge-light-blue { background-color: #edf2ff; color: #448aff; }
    .badge-outline-pink { border: 1px solid #ff9a9e; color: #ff9a9e; background: none; }
    .badge-outline-blue { border: 1px solid #4facfe; color: #4facfe; background: none; }
    
    /* Timetable Grid */
    .timetable-grid { border-collapse: separate; border-spacing: 5px; }
    .timetable-grid thead th { border: none; padding: 15px 5px; color: #2c3e50; font-weight: 700; background: none; }
    .time-slot { background: #f8f9fa; border-radius: 10px; min-width: 100px; padding: 15px 5px !important; }
    .time-start { display: block; font-size: 1.1rem; color: #2c3e50; }
    .time-divider { display: block; height: 2px; width: 20px; background: #dee2e6; margin: 4px auto; }
    
    .class-cell-container { padding: 0 !important; width: 150px; min-width: 140px; }
    .class-cell {
        border-radius: 12px;
        padding: 12px 8px;
        transition: transform 0.2s;
        height: 100%;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-left: 4px solid rgba(0,0,0,0.1);
    }
    .class-cell:hover { transform: translateY(-3px); cursor: pointer; }
    .matiere-name { font-weight: 700; font-size: 0.85rem; color: #2c3e50; margin-bottom: 4px; line-height: 1.2; }
    
    .break-cell { border-radius: 12px; background-color: #f1f3f5; padding: 10px; height: 100%; border-radius: 12px; opacity: 0.6; }
    .empty-cell { height: 100%; min-height: 80px; }
    
    .border-dashed { border: 2px dashed #dee2e6 !important; }
    .hover-y:hover { transform: translateY(-5px); transition: 0.3s; }
</style>
@endsection
 
