@extends('layouts.app')
@section('title', 'Dossier Individuel de l\'Élève')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Dossier Élève</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.etudiant.index') }}">Élèves</a></li>
            <li>{{ $etudiant->nom }} {{ $etudiant->prenom }}</li>
        </ul>
    </div>

    <!-- Student Profile Header (Premium Design) -->
    <div class="card height-auto mg-b-20" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; border: none; overflow: hidden; position: relative;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div class="card-body">
            <div class="single-info-details">
                <div class="item-img" style="position: relative; z-index: 2;">
                    @if($etudiant->photo)
                        <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="{{ $etudiant->prenom }}"
                            style="width: 140px; height: 140px; object-fit: cover; border-radius: 20px; border: 4px solid rgba(255,255,255,0.3); box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                    @else
                        <div style="width: 140px; height: 140px; border-radius: 20px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 48px; border: 4px solid rgba(255,255,255,0.3);">
                            {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="item-content" style="z-index: 2;">
                    <div class="header-inline item-header">
                        <h2 class="text-white font-bold mb-1" style="font-size: 28px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h2>
                        <div class="header-elements">
                            <ul class="d-flex align-items-center" style="gap: 12px; list-style: none; margin: 0; padding: 0;">
                                <li>
                                    <a href="{{ route('admin.etudiant.edit', $etudiant->id) }}" class="btn btn-sm btn-light" style="border-radius: 10px; color: #1e3a8a;" title="Modifier">
                                        <i class="far fa-edit"></i> Modifier
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.etudiant.fiche', $etudiant->id) }}" class="btn btn-sm btn-warning" style="border-radius: 10px; font-weight: bold;" target="_blank" title="Imprimer Fiche">
                                        <i class="fas fa-print"></i> Imprimer
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap mt-3" style="gap: 12px;">
                        <span class="badge" style="background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.4); padding: 6px 15px; border-radius: 30px;">
                            <i class="fas fa-fingerprint mg-r-8"></i> Matricule: <strong>{{ $etudiant->matricule }}</strong>
                        </span>
                        <span class="badge" style="background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.4); padding: 6px 15px; border-radius: 30px;">
                            <i class="fas fa-chalkboard-teacher mg-r-8"></i> {{ $etudiant->classe->nom ?? 'Non assigné' }}
                        </span>
                        <span class="badge" style="background: {{ $etudiant->status == 'actif' ? '#22c55e' : '#ef4444' }}; color: #fff; padding: 6px 15px; border-radius: 30px;">
                            <i class="fas fa-circle mg-r-8" style="font-size: 8px;"></i> {{ ucfirst($etudiant->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Main Column -->
        <div class="col-12 col-xl-8">
            <!-- Summary Info -->
            <div class="row gutters-10">
                <div class="col-sm-4">
                    <div class="card p-4 text-center mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <div class="text-muted small mb-1">Moyenne Générale</div>
                        <h4 class="mb-0 font-bold" style="color: #667eea;">14.50</h4> <!-- Placeholder pour l'instant -->
                        <div class="small mt-1 text-success"><i class="fas fa-arrow-up"></i> +0.5</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card p-4 text-center mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <div class="text-muted small mb-1">Solde Financier</div>
                        <h4 class="mb-0 font-bold" style="color: #ef4444;">-15.000 FCFA</h4>
                        <div class="small mt-1 text-danger">En retard</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card p-4 text-center mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <div class="text-muted small mb-1">Absences</div>
                        <h4 class="mb-0 font-bold" style="color: #1e293b;">{{ $etudiant->presences_count ?? 0 }}</h4>
                        <div class="small mt-1 text-muted">Ce trimestre</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Info Tabs -->
            <div class="card height-auto mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <ul class="nav nav-tabs border-0" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-bold" id="personal-tab" data-toggle="tab" href="#personal-info" role="tab" style="border: none; color: #64748b; padding: 10px 20px;">Personnel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-bold" id="academic-tab" data-toggle="tab" href="#academic-info" role="tab" style="border: none; color: #64748b; padding: 10px 20px;">Scolarité</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-bold" id="medical-tab" data-toggle="tab" href="#medical-info" role="tab" style="border: none; color: #64748b; padding: 10px 20px;">Santé</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-bold" id="history-tab" data-toggle="tab" href="#history" role="tab" style="border: none; color: #64748b; padding: 10px 20px;">Historique</a>
                        </li>
                    </ul>
                    <hr class="mt-0 mb-4">
                    
                    <div class="tab-content" id="profileTabContent">
                        <!-- Tab: Personnel -->
                        <div class="tab-pane fade show active" id="personal-info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Nom & Prénoms</label>
                                    <span class="font-medium">{{ $etudiant->nom }} {{ $etudiant->prenom }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Date & Lieu de naissance</label>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }} à {{ $etudiant->lieu_naissance ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Nationalité</label>
                                    <span class="font-medium">{{ $etudiant->nationalite ?? 'Ivoirienne' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">N° CNI / Extrait</label>
                                    <span class="font-medium">{{ $etudiant->cni_extrait_numero ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">E-mail</label>
                                    <span class="font-medium">{{ $etudiant->email ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Téléphone</label>
                                    <span class="font-medium">{{ $etudiant->phone ?? '-' }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block">Adresse de résidence</label>
                                    <span class="font-medium">{{ $etudiant->address ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Scolarité -->
                        <div class="tab-pane fade" id="academic-info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Filière / Série</label>
                                    <span class="badge badge-info py-2 px-3">{{ $etudiant->filiere_serie ?? 'Général' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Statut Inscription</label>
                                    <span class="font-medium">{{ str_replace('_', ' ', ucfirst($etudiant->statut_inscription)) ?? 'Nouvel élève' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Établissement précédent</label>
                                    <span class="font-medium">{{ $etudiant->etablissement_precedent ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Promotion / Groupe</label>
                                    <span class="font-medium">{{ $etudiant->groupe_promotion ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Affecté par l'état</label>
                                    <span class="badge badge-{{ $etudiant->est_affecte ? 'success' : 'secondary' }}">
                                        {{ $etudiant->est_affecte ? 'Oui' : 'Non' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Santé -->
                        <div class="tab-pane fade" id="medical-info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="p-3 rounded text-center" style="background: #fff5f5; border: 1px solid #feb2b2;">
                                        <label class="text-danger small d-block font-bold">Groupe Sanguin</label>
                                        <h3 class="mb-0 text-danger">{{ $etudiant->groupe_sanguin ?? '?' }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-4">
                                    <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <label class="text-muted small d-block">Contact d'urgence</label>
                                        <span class="font-bold d-block"><i class="fas fa-phone-alt mg-r-8"></i>{{ $etudiant->contact_urgence ?? 'Non renseigné' }}</span>
                                        <label class="text-muted small d-block mt-2">Médecin traitant</label>
                                        <span class="font-medium">{{ $etudiant->medecin_traitant ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="text-muted small d-block"><i class="fas fa-exclamation-triangle text-warning mg-r-5"></i> Allergies</label>
                                            <p class="font-medium">{{ $etudiant->allergies ?? 'Aucune' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="text-muted small d-block"><i class="fas fa-notes-medical text-primary mg-r-5"></i> Maladies</label>
                                            <p class="font-medium">{{ $etudiant->maladies ?? 'Aucune' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="text-muted small d-block"><i class="fas fa-wheelchair text-info mg-r-5"></i> Handicap</label>
                                            <p class="font-medium">{{ $etudiant->handicap ?? 'Aucun' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Historique -->
                        <div class="tab-pane fade" id="history" role="tabpanel">
                             <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr class="text-muted small uppercase">
                                            <th>Année</th>
                                            <th>Classe</th>
                                            <th>Niveau</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($etudiant->inscriptions as $ins)
                                            <tr>
                                                <td class="font-bold">{{ $ins->anneeScolaire->annee ?? '-' }}</td>
                                                <td>{{ $ins->classe->nom ?? '-' }}</td>
                                                <td>{{ $ins->niveau->nom ?? '-' }}</td>
                                                <td><span class="badge badge-success">Actif</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grades & Performance -->
            <div class="card height-auto mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title">
                            <h3><i class="fas fa-chart-line text-blue mg-r-10"></i>Notes Récentes</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Matière</th>
                                    <th>Évaluation</th>
                                    <th class="text-center">Note</th>
                                    <th>Appréciation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiant->notes->take(5) as $note)
                                    <tr>
                                        <td><strong>{{ $note->evaluation->matiere->nom ?? '-' }}</strong></td>
                                        <td class="small">{{ $note->evaluation->libelle ?? '-' }}</td>
                                        <td class="text-center font-bold" style="color: {{ $note->note >= 10 ? '#22c55e' : '#ef4444' }};">
                                            {{ $note->note }} <span class="text-muted small">/{{ $note->evaluation->note_max ?? 20 }}</span>
                                        </td>
                                        <td class="small">{{ $note->appreciation ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Aucune note disponible</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Sidebar) -->
        <div class="col-12 col-xl-4">
            <!-- Parents Card -->
            <div class="card height-auto mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title">
                            <h3><i class="fas fa-users text-orange-peel mg-r-10"></i>Famille / Tuteurs</h3>
                        </div>
                    </div>
                    @forelse($etudiant->parents as $parent)
                        <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 40px; height: 40px; background: #667eea; color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px;">
                                    {{ substr($parent->prenom, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="mb-0 font-bold" style="font-size: 14px;">{{ $parent->nom }} {{ $parent->prenom }}</h5>
                                    <span class="badge badge-light text-primary small">{{ $parent->pivot->relation ?? 'Parent' }}</span>
                                </div>
                            </div>
                            <div class="mt-2 small">
                                <div class="mb-1 text-muted"><i class="fas fa-briefcase mg-r-8"></i>{{ $parent->profession ?? 'Non renseignée' }}</div>
                                <div class="mb-1 font-bold"><i class="fas fa-phone-alt mg-r-8"></i>{{ $parent->telephone }}</div>
                                <div class="text-muted"><i class="fas fa-envelope mg-r-8"></i>{{ $parent->email ?? '-' }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">Aucun parent lié</p>
                    @endforelse
                </div>
            </div>

            <!-- Financial Card -->
            <div class="card height-auto mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <div class="heading-layout1 mb-4">
                        <div class="item-title">
                            <h3><i class="fas fa-wallet text-success mg-r-10"></i>Comptabilité</h3>
                        </div>
                    </div>
                    @forelse($factures->take(3) as $facture)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                            <div>
                                <div class="font-bold small">Facture #{{ $facture->id }}</div>
                                <div class="text-muted tiny">{{ $facture->created_at->format('d/m/Y') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold small text-dark">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</div>
                                <span class="badge badge-{{ $facture->statut == 'paye' ? 'success' : 'warning' }}" style="font-size: 9px;">{{ $facture->statut }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">Aucun historique de paiement</p>
                    @endforelse
                    <a href="#" class="btn btn-block btn-outline-success btn-sm mt-2">Détails financiers</a>
                </div>
            </div>

            <!-- Observations Card -->
            <div class="card height-auto mg-b-20" style="border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <div class="heading-layout1 mb-3">
                        <div class="item-title">
                            <h3><i class="fas fa-comment-dots text-purple mg-r-10"></i>Observations</h3>
                        </div>
                    </div>
                    <div class="p-3 bg-light rounded italic small" style="border-left: 3px solid #9333ea;">
                        {{ $etudiant->observations ?? 'Aucune observation particulière enregistrée pour cet élève.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection