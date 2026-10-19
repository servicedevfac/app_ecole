@extends('layouts.app')
@section('title', 'Gestion des Établissements')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Gestion des Établissements</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Liste des écoles</li>
        </ul>
    </div>

    <!-- Summary Cards -->
    <div class="row gutters-20 mg-b-20">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #667eea; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-school text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #777;">Toutes les Écoles</h6>
                            <h2 class="text-dark font-weight-bold mb-0" style="font-size: 32px;">{{ $totalSchools }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #4facfe; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-check-circle text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #777;">Actives / Inactives</h6>
                            <h2 class="text-dark font-weight-bold mb-0" style="font-size: 28px;">{{ $activeSchoolsCount }} / {{ $totalSchools - $activeSchoolsCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12 d-none d-xl-block">
            <div class="dashboard-summery-one" style="border-top: 4px solid #f093fb; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-clock text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #777;">Total Éleves (Plateforme)</h6>
                            <h2 class="text-dark font-weight-bold mb-0" style="font-size: 32px;">{{ number_format($totalStudentsCount) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Area -->
    <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
        <div class="card-body">
            <div class="heading-layout1 mg-b-25">
                <div class="item-title">
                    <h3 style="font-weight: 700; color: #2d3748;">Liste des Écoles</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.ecole.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark shadow-sm" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-plus mg-r-8"></i> Ajouter un établissement
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap" style="border-collapse: separate; border-spacing: 0 10px;">
                    <thead style="background-color: #f7fafc;">
                        <tr>
                            <th style="border: none; padding: 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Logo</th>
                            <th style="border: none; padding: 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Nom de l'école</th>
                            <th style="border: none; padding: 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Effectif / Staff</th>
                            <th style="border: none; padding: 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Statut</th>
                            <th style="border: none; padding: 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ecoles as $ecole)
                        <tr style="background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: transform 0.2s;">
                            <td style="padding: 15px 20px; border: none; border-radius: 15px 0 0 15px;">
                                <a href="{{ route('admin.ecole.show', $ecole) }}">
                                    @if($ecole->logo)
                                        <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover; border: 2px solid #edf2f7;">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 10px; background: #edf2f7; display: flex; align-items: center; justify-content: center; color: #a0aec0; font-size: 20px; border: 1px dashed #cbd5e0;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </a>
                            </td>
                            <td style="padding: 15px 20px; border: none;">
                                <a href="{{ route('admin.ecole.show', $ecole) }}">
                                    <div style="font-weight: 700; color: #2d3748; font-size: 15px;">{{ $ecole->nom }}</div>
                                    <div style="font-size: 12px; color: #a0aec0;">slug: {{ $ecole->slug }}</div>
                                </a>
                            </td>
                            <td style="padding: 15px 20px; border: none;">
                                <a href="{{ route('admin.ecole.show', $ecole) }}">
                                    <div style="font-weight: 700; color: #2d3748;"><i class="fas fa-user-graduate mg-r-5 text-muted"></i> {{ $ecole->etudiants_count }} <small>élèves</small></div>
                                    <div style="font-size: 13px; color: #718096;"><i class="fas fa-users-cog mg-r-5 text-muted"></i> {{ $ecole->users_count }} <small>comptes</small> / {{ $ecole->enseignants_count }} <small>profs</small></div>
                                </a>
                            </td>
                            <td style="padding: 15px 20px; border: none;">
                                @if($ecole->is_active)
                                        <span class="badge" style="background-color: #c6f6d5; color: #22543d; padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-circle mg-r-5" style="font-size: 8px;"></i> Actif
                                        </span>
                                    @else
                                        <span class="badge" style="background-color: #fed7d7; color: #822727; padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-circle mg-r-5" style="font-size: 8px;"></i> Inactif
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 15px 20px; border: none; border-radius: 0 15px 15px 0;">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color: #cbd5e0; font-size: 20px;">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 10px;">
                                            <a class="dropdown-item" href="{{ route('admin.ecole.show', $ecole->slug) }}" style="border-radius: 8px; padding: 8px 15px;">
                                                <i class="fas fa-eye text-primary mg-r-10"></i> Voir détails
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.ecole.edit', $ecole->slug) }}" style="border-radius: 8px; padding: 8px 15px;">
                                                <i class="fas fa-edit text-success mg-r-10"></i> Modifier
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.ecole.destroy', $ecole->slug) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet établissement ? Cette action est irréversible.')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" style="border-radius: 8px; padding: 8px 15px;">
                                                    <i class="fas fa-trash-alt mg-r-10"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </a>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mg-t-20 d-flex justify-content-center">
                {{ $ecoles->links() }}
            </div>
        </div>
    </div>

    <style>
        .dashboard-summery-one { background: #fff; padding: 25px; margin-bottom: 20px; }
        .table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important; cursor: pointer; }
        .badge { display: inline-flex; align-items: center; }
        .dropdown-item:hover { background-color: #f7fafc; color: #2d3748; }
    </style>

@endsection
