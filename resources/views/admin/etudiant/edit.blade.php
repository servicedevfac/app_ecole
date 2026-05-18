@extends('layouts.app')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Étudiants</h3>
        <ul>
            <li>
                <a href="{{ route('admin.etudiant.index') }}">Étudiants</a>
            </li>
            <li>Modifier l'étudiant</li>
        </ul>
    </div>
    
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Modifier : {{ $etudiant->nom }} {{ $etudiant->prenom }}</h3>
                </div>
            </div>

            <form action="{{ route('admin.etudiant.update', $etudiant->id) }}" method="POST" class="new-added-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-4" id="studentTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab">
                            <i class="fas fa-user mr-2"></i>Personnel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic" role="tab">
                            <i class="fas fa-graduation-cap mr-2"></i>Scolarité
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="medical-tab" data-toggle="tab" href="#medical" role="tab">
                            <i class="fas fa-heartbeat mr-2"></i>Médical
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="parents-tab" data-toggle="tab" href="#parents" role="tab">
                            <i class="fas fa-users mr-2"></i>Parents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="observations-tab" data-toggle="tab" href="#observations" role="tab">
                            <i class="fas fa-comment-alt mr-2"></i>Observations
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content border p-4 rounded bg-light">
                    <!-- Tab: Personnel -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Nom *</label>
                                <input name="nom" type="text" class="form-control" value="{{ old('nom', $etudiant->nom) }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Prénoms *</label>
                                <input name="prenom" type="text" class="form-control" value="{{ old('prenom', $etudiant->prenom) }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Sexe *</label>
                                <select name="sexe" class="form-control" required>
                                    <option value="M" {{ old('sexe', $etudiant->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe', $etudiant->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Date de naissance *</label>
                                <input name="date_naissance" type="date" class="form-control" value="{{ old('date_naissance', $etudiant->date_naissance) }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Lieu de naissance</label>
                                <input name="lieu_naissance" type="text" class="form-control" value="{{ old('lieu_naissance', $etudiant->lieu_naissance) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Nationalité</label>
                                <input name="nationalite" type="text" class="form-control" value="{{ old('nationalite', $etudiant->nationalite) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>N° CNI ou Extrait</label>
                                <input name="cni_extrait_numero" type="text" class="form-control" value="{{ old('cni_extrait_numero', $etudiant->cni_extrait_numero) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Numéro de téléphone</label>
                                <input name="phone" type="text" class="form-control" value="{{ old('phone', $etudiant->phone) }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Adresse de résidence</label>
                                <input name="address" type="text" class="form-control" value="{{ old('address', $etudiant->address) }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>E-mail élève</label>
                                <input name="email" type="email" class="form-control" value="{{ old('email', $etudiant->email) }}">
                            </div>
                            <div class="col-12 form-group mg-t-10">
                                <label class="text-dark-medium">Photo de l'élève (Laissez vide pour conserver l'actuelle)</label>
                                <input type="file" class="form-control-file" name="photo">
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Scolarité -->
                    <div class="tab-pane fade" id="academic" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Filière / Série</label>
                                <input name="filiere_serie" type="text" class="form-control" value="{{ old('filiere_serie', $etudiant->filiere_serie) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Statut Inscription</label>
                                <select name="statut_inscription" class="form-control">
                                    <option value="nouvel_eleve" {{ old('statut_inscription', $etudiant->statut_inscription) == 'nouvel_eleve' ? 'selected' : '' }}>Nouvel élève</option>
                                    <option value="redoublant" {{ old('statut_inscription', $etudiant->statut_inscription) == 'redoublant' ? 'selected' : '' }}>Redoublant</option>
                                    <option value="transfere" {{ old('statut_inscription', $etudiant->statut_inscription) == 'transfere' ? 'selected' : '' }}>Transféré</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Établissement précédent</label>
                                <input name="etablissement_precedent" type="text" class="form-control" value="{{ old('etablissement_precedent', $etudiant->etablissement_precedent) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Groupe / Promotion</label>
                                <input name="groupe_promotion" type="text" class="form-control" value="{{ old('groupe_promotion', $etudiant->groupe_promotion) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Affecté de l'état *</label>
                                <select name="est_affecte" class="form-control" required>
                                    <option value="0" {{ old('est_affecte', $etudiant->est_affecte) == 0 ? 'selected' : '' }}>Non</option>
                                    <option value="1" {{ old('est_affecte', $etudiant->est_affecte) == 1 ? 'selected' : '' }}>Oui</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Médical -->
                    <div class="tab-pane fade" id="medical" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Groupe Sanguin</label>
                                <select name="groupe_sanguin" class="form-control">
                                    <option value="" {{ $etudiant->groupe_sanguin == '' ? 'selected' : '' }}>Inconnu</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gs)
                                        <option value="{{ $gs }}" {{ old('groupe_sanguin', $etudiant->groupe_sanguin) == $gs ? 'selected' : '' }}>{{ $gs }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Contact Urgence</label>
                                <input name="contact_urgence" type="text" class="form-control" value="{{ old('contact_urgence', $etudiant->contact_urgence) }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Médecin traitant</label>
                                <input name="medecin_traitant" type="text" class="form-control" value="{{ old('medecin_traitant', $etudiant->medecin_traitant) }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Allergies</label>
                                <textarea name="allergies" class="form-control" rows="3">{{ old('allergies', $etudiant->allergies) }}</textarea>
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Maladies particulières</label>
                                <textarea name="maladies" class="form-control" rows="3">{{ old('maladies', $etudiant->maladies) }}</textarea>
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Handicap éventuel</label>
                                <textarea name="handicap" class="form-control" rows="3">{{ old('handicap', $etudiant->handicap) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Parents -->
                    <div class="tab-pane fade" id="parents" role="tabpanel">
                        <div class="row">
                            @php
                                $parent = $etudiant->parents->first();
                                $relation = $parent ? $parent->pivot->relation : '';
                            @endphp
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Parent</label>
                                <select name="parent_id" class="form-control">
                                    @foreach($parents as $p)
                                        <option value="{{ $p->id }}" {{ ($parent && $parent->id == $p->id) ? 'selected' : '' }}>{{ $p->nom }} {{ $p->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Relation *</label>
                                <select name="relation" class="form-control" required>
                                    <option value="pere" {{ $relation == 'pere' ? 'selected' : '' }}>Père</option>
                                    <option value="mere" {{ $relation == 'mere' ? 'selected' : '' }}>Mère</option>
                                    <option value="tuteur" {{ $relation == 'tuteur' ? 'selected' : '' }}>Tuteur</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="alert alert-info py-2" style="font-size: 13px;">
                                    <i class="fas fa-info-circle mr-1"></i> Pour modifier les détails du parent (téléphone, profession, etc.), rendez-vous dans le module "Parents".
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Observations -->
                    <div class="tab-pane fade" id="observations" role="tabpanel">
                        <div class="col-12 form-group">
                            <label>Observations des enseignants / Direction</label>
                            <textarea name="observations" class="form-control" rows="5">{{ old('observations', $etudiant->observations) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 form-group mg-t-30">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Mettre à jour le dossier</button>
                    <a href="{{ route('admin.etudiant.show', $etudiant->id) }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
