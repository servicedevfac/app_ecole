@extends('layouts.app')
@section('title', 'Gestion des Utilisateurs')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Gestion des utilisateurs</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Tous les utilisateurs</li>
        </ul>
    </div>

    <!-- Summary Cards -->
    <div class="row gutters-20 mg-b-20">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #667eea; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-users text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #777;">Total Utilisateurs</h6>
                            <h2 class="text-dark font-weight-bold mb-0" style="font-size: 32px;">{{ $users->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #48bb78; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #48bb78, #38a169); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-school text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #777;">Avec École</h6>
                            <h2 class="text-dark font-weight-bold mb-0" style="font-size: 32px;">{{ $users->whereNotNull('ecole_id')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="dashboard-summery-one" style="border-top: 4px solid #f6ad55; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #f6ad55, #ed8936); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-shield-alt text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #777;">Sans École</h6>
                            <h2 class="text-dark font-weight-bold mb-0" style="font-size: 32px;">{{ $users->whereNull('ecole_id')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
        <div class="card-body">
            <div class="heading-layout1 mg-b-25">
                <div class="item-title">
                    <h3 style="font-weight: 700; color: #2d3748;">Liste des Utilisateurs</h3>
                </div>
                @can('utilisateurs.create')
                <div>
                    <a href="{{ route('admin.user.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark shadow-sm" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-plus mg-r-8"></i> Créer un utilisateur
                    </a>
                </div>
                @endcan
            </div>

            <div class="table-responsive">
                <div class="col-xl-3 col-lg-4 col-12 form-group">
                    <label>Choisir une école</label>
                    <form action="{{ route('admin.user.index') }}" method="GET">
                        <select class="form-control search-input" name="ecole_id" id="ecole_id" onchange="this.form.submit()">
                            <option value="">Toutes les écoles</option>
                            @foreach ($ecoles as $ecole)
                                <option value="{{ $ecole->id }}" {{ request('ecole_id') == $ecole->id ? 'selected' : '' }}>{{ $ecole->nom }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <table class="table display data-table text-nowrap" style="border-collapse: separate; border-spacing: 0 8px;">
                    <thead style="background-color: #f7fafc;">
                        <tr>
                            <th style="border: none; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: #718096;">#</th>
                            <th style="border: none; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Nom</th>
                            <th style="border: none; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Email</th>
                            <th style="border: none; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Établissement</th>
                            <th style="border: none; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Rôle</th>
                            <th style="border: none; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: #718096;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr style="background-color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: transform 0.2s;">
                            <td style="padding: 14px 20px; border: none; border-radius: 12px 0 0 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:14px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </td>
                            <td style="padding: 14px 20px; border: none; font-weight: 700; color: #2d3748;">{{ $user->name }}</td>
                            <td style="padding: 14px 20px; border: none; color: #718096; font-size: 14px;">{{ $user->email }}</td>
                            <td style="padding: 14px 20px; border: none;">
                                @if($user->ecole)
                                    <span class="badge" style="background: #ebf8ff; color: #2b6cb0; padding: 5px 12px; border-radius: 8px; font-weight: 600; font-size: 12px;">
                                        <i class="fas fa-school mr-1"></i>{{ $user->ecole->nom }}
                                    </span>
                                @elseif($user->hasRole('Super Admin'))
                                    <span class="badge" style="background: #2d3748; color: #fff; padding: 5px 12px; border-radius: 8px; font-weight: 600; font-size: 12px;">
                                        <i class="fas fa-globe mr-1"></i>Global
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size: 13px;">—</span>
                                @endif
                            </td>
                            <td style="padding: 14px 20px; border: none;">
                                @foreach($user->roles as $role)
                                    <span class="badge" style="background: linear-gradient(135deg, #667eea, #764ba2); color:#fff; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td style="padding: 14px 20px; border: none; border-radius: 0 12px 12px 0;">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color: #cbd5e0; font-size: 18px;">
                                        <span class="flaticon-more-button-of-three-dots"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 10px;">
                                        <a class="dropdown-item" href="{{ route('admin.user.show', $user->id) }}" style="border-radius: 8px; padding: 8px 15px; font-size: 14px;">
                                            <i class="fas fa-eye text-primary mg-r-10"></i> Voir
                                        </a>
                                        @can('utilisateurs.update')
                                        <a class="dropdown-item" href="{{ route('admin.user.edit', $user->id) }}" style="border-radius: 8px; padding: 8px 15px; font-size: 14px;">
                                            <i class="fas fa-edit text-success mg-r-10"></i> Modifier
                                        </a>
                                        @endcan
                                        @can('utilisateurs.delete')
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Confirmer la suppression de {{ $user->name }} ?')" style="border-radius: 8px; padding: 8px 15px; font-size: 14px;">
                                                <i class="fas fa-trash-alt mg-r-10"></i> Supprimer
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-users-slash" style="font-size: 48px; color: #cbd5e0; display: block; margin-bottom: 15px;"></i>
                                <p class="text-muted">Aucun utilisateur trouvé.</p>
                                <a href="{{ route('admin.user.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 10px;">
                                    <i class="fas fa-plus mg-r-8"></i> Créer le premier
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-summery-one { background: #fff; padding: 25px; margin-bottom: 20px; }
        .table tbody tr:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important; }
        .dropdown-item:hover { background-color: #f7fafc; }
    </style>

@endsection