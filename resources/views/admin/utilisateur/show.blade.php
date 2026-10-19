@extends('layouts.app')
@section('title', 'Détails Utilisateur')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Profil Utilisateur</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.user.index') }}">Utilisateurs</a></li>
            <li>{{ $user->name }}</li>
        </ul>
    </div>

    <div class="row gutters-20">
        <!-- User Profile Card -->
        <div class="col-xl-4 col-12">
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.06); overflow: hidden;">
                <div class="card-body p-0">
                    <!-- Header banner -->
                    <div style="height: 110px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    <div class="text-center" style="margin-top: -55px; padding: 0 20px 30px;">
                        <!-- Avatar -->
                        <div style="width: 110px; height: 110px; border-radius: 50%; border: 5px solid #fff; background: linear-gradient(135deg, #ffae01, #f97316); display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 25px rgba(102,126,234,0.3);">
                            <span style="font-size: 42px; font-weight: 800; color: #fff; text-transform: uppercase;">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h3 class="mt-3 mb-1" style="font-weight: 800; color: #2d3748;">{{ $user->name }}</h3>
                        <p class="text-muted mb-1" style="font-size: 14px;"><i class="far fa-envelope mr-1"></i>{{ $user->email }}</p>

                        <!-- Role Badge -->
                        <div class="mt-2 mb-3">
                            @foreach($user->roles as $role)
                                <span class="badge" style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-shield-alt mr-1"></i> {{ $role->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            @if($user->email_verified_at)
                                <span class="badge" style="background: #c6f6d5; color: #22543d; padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-check-circle mr-1"></i> Email vérifié
                                </span>
                            @else
                                <span class="badge" style="background: #fed7d7; color: #822727; padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Non vérifié
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-center" style="gap: 10px;">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 10px; font-size: 13px; padding: 8px 20px;">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </a>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow" style="border-radius: 10px; font-size: 13px; padding: 8px 20px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="border-top p-4" style="background: #f7fafc; border-radius: 0 0 20px 20px;">
                        <h6 style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: 700; color: #718096; margin-bottom: 15px;">Informations</h6>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-id-badge mr-2 text-muted" style="width: 20px;"></i>
                                <span style="font-size: 14px; color: #4a5568;">ID: <strong>#{{ $user->id }}</strong></span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-school mr-2 text-muted" style="width: 20px;"></i>
                                <span style="font-size: 14px; color: #4a5568;">
                                    @if($user->ecole)
                                        <strong>{{ $user->ecole->nom }}</strong>
                                    @elseif($user->hasRole('Super Admin'))
                                        <em style="color: #a0aec0;">Global (Super Admin)</em>
                                    @else
                                        <em style="color: #a0aec0;">Non assigné</em>
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt mr-2 text-muted" style="width: 20px;"></i>
                                <span style="font-size: 14px; color: #4a5568;">Créé le: <strong>{{ $user->created_at->format('d/m/Y') }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="col-xl-8 col-12">
            <!-- Quick Stats -->
            <div class="row gutters-20 mb-4">
                <div class="col-md-4 col-12">
                    <div class="dashboard-summery-one" style="border-radius: 15px; border-top: 4px solid #667eea; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 20px;">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <div class="item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); width: 55px; height: 55px; border-radius: 12px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-key text-white" style="font-size: 20px;"></i>
                                </div>
                            </div>
                            <div class="col-8 text-right">
                                <h6 style="font-size: 11px; text-transform: uppercase; color: #718096; letter-spacing: 1px; margin-bottom: 4px;">Rôles</h6>
                                <h3 style="font-weight: 800; color: #2d3748; margin: 0;">{{ $user->roles->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="dashboard-summery-one" style="border-radius: 15px; border-top: 4px solid #48bb78; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 20px;">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <div class="item-icon" style="background: linear-gradient(135deg, #48bb78, #38a169); width: 55px; height: 55px; border-radius: 12px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-check text-white" style="font-size: 20px;"></i>
                                </div>
                            </div>
                            <div class="col-8 text-right">
                                <h6 style="font-size: 11px; text-transform: uppercase; color: #718096; letter-spacing: 1px; margin-bottom: 4px;">Permissions</h6>
                                <h3 style="font-weight: 800; color: #2d3748; margin: 0;">{{ $user->getAllPermissions()->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="dashboard-summery-one" style="border-radius: 15px; border-top: 4px solid #f6ad55; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 20px;">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <div class="item-icon" style="background: linear-gradient(135deg, #f6ad55, #ed8936); width: 55px; height: 55px; border-radius: 12px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-clock text-white" style="font-size: 20px;"></i>
                                </div>
                            </div>
                            <div class="col-8 text-right">
                                <h6 style="font-size: 11px; text-transform: uppercase; color: #718096; letter-spacing: 1px; margin-bottom: 4px;">Dernière modif.</h6>
                                <h3 style="font-weight: 700; color: #2d3748; margin: 0; font-size: 14px;">{{ $user->updated_at->diffForHumans() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Roles & Permissions Detail -->
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 20px;"><i class="fas fa-shield-alt mr-2 text-indigo-500"></i>Rôles & Permissions</h4>

                    @forelse($user->roles as $role)
                        <div class="mb-4 p-3" style="background: #f7fafc; border-radius: 12px; border-left: 4px solid #667eea;">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge mr-2" style="background: linear-gradient(135deg,#667eea,#764ba2); color:#fff; padding:5px 12px; border-radius:8px; font-weight:700;">{{ $role->name }}</span>
                            </div>
                            @if($role->permissions->count() > 0)
                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                    @foreach($role->permissions as $perm)
                                        <span style="background: #ebf8ff; color: #2b6cb0; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 500;">{{ $perm->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0" style="font-size: 13px;"><em>Aucune permission spécifique</em></p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-user-slash" style="font-size: 32px; margin-bottom: 10px;"></i>
                            <p>Aucun rôle assigné à cet utilisateur.</p>
                        </div>
                    @endforelse

                    <!-- Assigned School Info -->
                    @if($user->ecole)
                    <hr style="border-color: #edf2f7;">
                    <h5 style="font-weight: 700; color: #2d3748; margin-bottom: 15px;"><i class="fas fa-school mr-2"></i>École Associée</h5>
                    <div class="d-flex align-items-center p-3" style="background: #fffbeb; border-radius: 12px; border-left: 4px solid #ffae01;">
                        <div style="width: 50px; height: 50px; border-radius: 10px; background: #667eea; display:flex; align-items:center; justify-content:center; margin-right: 15px; flex-shrink:0;">
                            @if($user->ecole->logo)
                                <img src="{{ asset('storage/' . $user->ecole->logo) }}" style="width:100%; height:100%; object-fit:cover; border-radius:10px;" alt="logo">
                            @else
                                <i class="fas fa-school text-white"></i>
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:700; color:#2d3748;">{{ $user->ecole->nom }}</div>
                            <div style="font-size:13px; color:#718096;">{{ $user->ecole->email ?? 'Pas d\'email' }} &bull; {{ $user->ecole->telephone ?? 'Pas de tél.' }}</div>
                            @if($user->ecole->is_active)
                                <span style="background:#c6f6d5; color:#22543d; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:600;">ACTIF</span>
                            @else
                                <span style="background:#fed7d7; color:#822727; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:600;">INACTIF</span>
                            @endif
                        </div>
                        <div class="ml-auto">
                            <a href="{{ route('admin.ecole.show', $user->ecole->slug) }}" style="font-size:13px; color:#667eea; font-weight:600;">Voir l'école &rarr;</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-summery-one { background: #fff; margin-bottom: 0; }
    </style>

@endsection
