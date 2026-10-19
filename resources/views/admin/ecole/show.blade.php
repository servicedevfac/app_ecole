@extends('layouts.app')
@section('title', 'Détails de l\'Établissement')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Détails de l'Établissement</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.ecole.index') }}">Écoles</a></li>
            <li>{{ $ecole->nom }}</li>
        </ul>
    </div>

    <div class="row gutters-20">
        <!-- School Card -->
        <div class="col-xl-4 col-12">
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden;">
                <div class="card-body p-0">
                    <div style="height: 120px; background: linear-gradient(135deg, #667eea, #764ba2);"></div>
                    <div class="text-center" style="margin-top: -60px; padding: 0 20px 30px;">
                        @if($ecole->logo)
                            <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo" style="width: 120px; height: 120px; border-radius: 20px; border: 5px solid #fff; background: #fff; object-fit: cover; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                        @else
                            <div style="width: 120px; height: 120px; border-radius: 20px; border: 5px solid #fff; background: #f7fafc; display: flex; align-items: center; justify-content: center; color: #a0aec0; font-size: 40px; margin: 0 auto; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                                <i class="fas fa-school"></i>
                            </div>
                        @endif
                        <h3 class="mt-3 mb-1" style="font-weight: 800; color: #2d3748;">{{ $ecole->nom }}</h3>
                        <p class="text-muted mb-3"><i class="fas fa-link mr-1"></i> {{ $ecole->slug }}</p>
                        
                        <div class="mb-3">
                            @if($ecole->is_active)
                                <span class="badge" style="background-color: #c6f6d5; color: #22543d; padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                    <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> Actif
                                </span>
                            @else
                                <span class="badge" style="background-color: #fed7d7; color: #822727; padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                    <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> Suspendu
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-center" style="gap: 10px;">
                            <a href="{{ route('admin.ecole.edit', $ecole->slug) }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 10px; font-size: 13px; padding: 8px 20px;">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </a>
                            <form action="{{ route('admin.ecole.destroy', $ecole->slug) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet établissement ?')" style="margin:0;">
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
                        <h6 style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: 700; color: #718096; margin-bottom: 15px;">Contact & Localisation</h6>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="far fa-envelope mr-2 text-muted" style="width: 20px;"></i>
                                <span style="font-size: 14px; color: #4a5568;">{{ $ecole->email ?? 'Non renseigné' }}</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-phone-alt mr-2 text-muted" style="width: 20px;"></i>
                                <span style="font-size: 14px; color: #4a5568;">{{ $ecole->telephone ?? 'Non renseigné' }}</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2 text-muted" style="width: 20px;"></i>
                                <span style="font-size: 14px; color: #4a5568;">{{ $ecole->adresse ?? 'Aucune adresse enregistrée' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats & Details -->
        <div class="col-xl-8 col-12">
            <!-- Stats Row -->
            <div class="row gutters-20 mb-4">
                <div class="col-md-4 col-12">
                    <div class="dashboard-summery-one" style="border-radius: 15px; background: #fff; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.04); border-top: 4px solid #667eea;">
                        <div class="item-content">
                            <h6 style="color: #718096; text-transform: uppercase; font-size: 11px; font-weight: 700;">Éleves & Capacité</h6>
                            <h2 style="font-weight: 800; color: #2d3748;">{{ $ecole->etudiants_count }} <small style="font-size: 13px; color: #a0aec0;">/ {{ $ecole->limite_etudiants ?? '∞' }}</small></h2>
                            <div class="progress" style="height: 6px; border-radius: 10px; margin-top: 10px; background: #edf2f7;">
                                <div class="progress-bar" style="width: {{ $ecole->limite_etudiants ? ($ecole->etudiants_count / $ecole->limite_etudiants) * 100 : 0 }}%; background: #667eea; border-radius: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="dashboard-summery-one" style="border-radius: 15px; background: #fff; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.04); border-top: 4px solid #48bb78;">
                        <div class="item-content">
                            <h6 style="color: #718096; text-transform: uppercase; font-size: 11px; font-weight: 700;">Personnel (Staff)</h6>
                            <h2 style="font-weight: 800; color: #2d3748;">{{ $ecole->enseignants_count }} <small style="font-size: 13px; color: #a0aec0;">profs</small></h2>
                            <p style="font-size: 12px; color: #718096; margin: 0;">{{ $ecole->users_count }} comptes utilisateurs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="dashboard-summery-one" style="border-radius: 15px; background: #fff; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.04); border-top: 4px solid #f6ad55;">
                        <div class="item-content">
                            <h6 style="color: #718096; text-transform: uppercase; font-size: 11px; font-weight: 700;">Inscriptions</h6>
                            <h2 style="font-weight: 800; color: #2d3748;">{{ $ecole->inscriptions_count }}</h2>
                            <p style="font-size: 12px; color: #718096; margin: 0;">Historique complet</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Grid -->
            <div class="row gutters-20 mb-4">
                <div class="col-md-6 col-12">
                    <div class="p-4" style="background: #fff; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.04); display: flex; align-items: center; gap: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: #ebf8ff; color: #3182ce; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 800; color: #2d3748; margin: 0;">{{ $ecole->classes_count }}</h3>
                            <p style="color: #718096; font-size: 13px; margin: 0;">Classes créées</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="p-4" style="background: #fff; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.04); display: flex; align-items: center; gap: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: #fff5f5; color: #e53e3e; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 800; color: #2d3748; margin: 0;">{{ $ecole->matieres_count }}</h3>
                            <p style="color: #718096; font-size: 13px; margin: 0;">Matières référencées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription & Payments Block -->
            <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); padding: 25px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 style="font-weight: 800; color: #2d3748; margin: 0;">Finances & Abonnement</h4>
                    <button type="button" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 10px; font-size: 13px; padding: 8px 16px;" data-toggle="modal" data-target="#recordPaymentModal">
                        <i class="fas fa-plus mr-1"></i> Enregistrer un paiement
                    </button>
                </div>

                <div class="row gutters-20 mb-4">
                    <div class="col-md-6">
                        <div style="background: #f7fafc; border-radius: 15px; padding: 20px; height: 100%;">
                            <span class="badge" style="background: #4299e1; color: #fff; padding: 5px 12px; border-radius: 6px; font-size: 11px; text-transform: uppercase; margin-bottom: 8px; display: inline-block;">
                                Plan {{ $ecole->plan ?? 'Standard' }}
                            </span>
                            <h5 style="font-weight: 700; color: #2d3748; margin-bottom: 4px;">Statut de l'abonnement</h5>
                            @if($ecole->trial_ends_at)
                                <p style="color: #718096; font-size: 14px; margin-bottom: 0;">
                                    Essai jusqu'au : <strong>{{ \Carbon\Carbon::parse($ecole->trial_ends_at)->format('d M Y') }}</strong>
                                </p>
                            @else
                                <p style="color: #718096; font-size: 14px; margin-bottom: 0;">Abonnement actif</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background: #ebf8ff; border-radius: 15px; padding: 20px; height: 100%;">
                            <h6 style="color: #2b6cb0; text-transform: uppercase; font-size: 11px; font-weight: 700; margin-bottom: 8px;">Total Payé à la Plateforme</h6>
                            <h3 style="font-weight: 800; color: #2c5282; margin: 0;">{{ number_format($ecole->ecolePayments->sum('montant'), 0, ',', ' ') }} <small style="font-size: 12px;">FCFA</small></h3>
                            <p style="color: #4299e1; font-size: 13px; margin: 0;">{{ $ecole->ecolePayments->count() }} règlements enregistrés</p>
                        </div>
                    </div>
                </div>

                <!-- Last Payments Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="background: #f7fafc;">
                                <th style="border:none; font-size: 12px; color: #718096;">Date</th>
                                <th style="border:none; font-size: 12px; color: #718096;">Montant</th>
                                <th style="border:none; font-size: 12px; color: #718096;">Mode</th>
                                <th style="border:none; font-size: 12px; color: #718096;">Référence</th>
                                <th style="border:none; font-size: 12px; color: #718096;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ecole->ecolePayments as $payment)
                                <tr>
                                    <td>{{ $payment->date_paiement->format('d/m/Y') }}</td>
                                    <td style="font-weight: 700; color: #2d3748;">{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</td>
                                    <td><span class="badge" style="background: #edf2f7; color: #4a5568;">{{ $payment->mode_paiement }}</span></td>
                                    <td style="font-size: 12px; color: #718096;">{{ $payment->reference ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('admin.ecole_payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce record de paiement ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border:none; background:none; color: #e53e3e; cursor:pointer;"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted" style="font-size: 13px;">Aucun paiement enregistré pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Users List -->
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 style="font-weight: 700; color: #2d3748; margin: 0;">
                            <i class="fas fa-users mr-2"></i>Utilisateurs de cette école
                        </h4>
                        <a href="{{ route('admin.user.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 10px; font-size: 13px; padding: 8px 16px;">
                            <i class="fas fa-plus mr-1"></i> Ajouter
                        </a>
                    </div>

                    @forelse($ecole->users as $user)
                        <div class="d-flex align-items-center p-3 mb-2" style="background: #f7fafc; border-radius: 12px; transition: all 0.2s;">
                            <!-- Avatar initial -->
                            <div style="width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-weight:800; color:#fff; font-size:16px; margin-right:15px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div style="font-weight: 700; color: #2d3748; font-size: 14px;">{{ $user->name }}</div>
                                <div style="font-size: 12px; color: #718096;">{{ $user->email }}</div>
                            </div>
                            <div style="margin-right: 15px;">
                                @foreach($user->roles as $role)
                                    <span class="badge" style="background: #ebf8ff; color: #2b6cb0; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">{{ $role->name }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex" style="gap: 8px;">
                                <a href="{{ route('admin.user.show', $user->id) }}" style="color: #667eea; background: #ebf8ff; border-radius: 8px; padding: 6px 10px; font-size: 12px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.user.edit', $user->id) }}" style="color: #48bb78; background: #f0fff4; border-radius: 8px; padding: 6px 10px; font-size: 12px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-user-slash" style="font-size: 36px; color: #cbd5e0; margin-bottom: 15px;"></i>
                            <p style="font-size: 14px;">Aucun utilisateur n'est encore associé à cette école.</p>
                            <a href="{{ route('admin.user.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 10px;">
                                <i class="fas fa-user-plus mr-1"></i> Créer un utilisateur
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div class="modal fade" id="recordPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 20px 25px;">
                    <h5 class="modal-title" style="font-weight: 800; color: #2d3748;">Enregistrer un paiement école</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.ecole_payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ecole_id" value="{{ $ecole->id }}">
                    <div class="modal-body" style="padding: 25px;">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label style="font-weight: 700; color: #4a5568; margin-bottom: 8px;">Montant (FCFA) *</label>
                                <input type="number" name="montant" class="form-control" placeholder="Ex: 500000" required style="border-radius: 10px; padding: 12px;">
                            </div>
                            <div class="col-6 form-group">
                                <label style="font-weight: 700; color: #4a5568; margin-bottom: 8px;">Date de paiement *</label>
                                <input type="date" name="date_paiement" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 10px; padding: 12px;">
                            </div>
                            <div class="col-6 form-group">
                                <label style="font-weight: 700; color: #4a5568; margin-bottom: 8px;">Mode *</label>
                                <select name="mode_paiement" class="form-control" required style="border-radius: 10px; padding: 12px;">
                                    <option value="Virement">Virement</option>
                                    <option value="Espèces">Espèces</option>
                                    <option value="Chèque">Chèque</option>
                                    <option value="Stripe">Stripe</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label style="font-weight: 700; color: #4a5568; margin-bottom: 8px;">Référence</label>
                                <input type="text" name="reference" class="form-control" placeholder="N° de transaction, chèque..." style="border-radius: 10px; padding: 12px;">
                            </div>
                            <div class="col-12 form-group">
                                <label style="font-weight: 700; color: #4a5568; margin-bottom: 8px;">Notes</label>
                                <textarea name="notes" class="form-control" rows="3" style="border-radius: 10px; padding: 12px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 20px 25px;">
                        <button type="button" class="btn-fill-lg bg-blue-dark text-white" data-dismiss="modal" style="border-radius: 10px; border:none; padding: 10px 20px;">Annuler</button>
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow text-white" style="border-radius: 10px; border:none; padding: 10px 20px;">Enregistrer le règlement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .dashboard-summery-one { background: #fff; margin-bottom: 0; }
        .d-flex[style*="background: #f7fafc"]:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>

@endsection
