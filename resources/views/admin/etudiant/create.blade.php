@extends('layouts.app')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Étudiants</h3>
        <ul>
            <li>
                <a href="{{route('dashboard')}}">Accueil</a>
            </li>
            <li>Ajouter un étudiant</li>
        </ul>
    </div>
    
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Nouvelle Inscription</h3>
                </div>
            </div>

            <form action="{{ route('admin.etudiant.store') }}" method="POST" class="new-added-form" enctype="multipart/form-data">
                @csrf
                
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-4" id="studentTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-selected="true">
                            <i class="fas fa-user mr-2"></i>Personnel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic" role="tab" aria-selected="false">
                            <i class="fas fa-graduation-cap mr-2"></i>Scolarité
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="medical-tab" data-toggle="tab" href="#medical" role="tab" aria-selected="false">
                            <i class="fas fa-heartbeat mr-2"></i>Médical
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="parents-tab" data-toggle="tab" href="#parents" role="tab" aria-selected="false">
                            <i class="fas fa-users mr-2"></i>Parents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="observations-tab" data-toggle="tab" href="#observations" role="tab" aria-selected="false">
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
                                <input name="nom" type="text" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Prénoms *</label>
                                <input name="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Sexe *</label>
                                <select name="sexe" class="form-control @error('sexe') is-invalid @enderror" required>
                                    <option value="">Sélectionner</option>
                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Date de naissance *</label>
                                <input name="date_naissance" type="date" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Lieu de naissance</label>
                                <input name="lieu_naissance" type="text" class="form-control" value="{{ old('lieu_naissance') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Nationalité</label>
                                <input name="nationalite" type="text" class="form-control" value="{{ old('nationalite') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>N° CNI ou Extrait</label>
                                <input name="cni_extrait_numero" type="text" class="form-control" value="{{ old('cni_extrait_numero') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Numéro de téléphone</label>
                                <input name="phone" type="text" class="form-control" value="{{ old('phone') }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Adresse de résidence</label>
                                <input name="address" type="text" class="form-control" value="{{ old('address') }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>E-mail élève</label>
                                <input name="email" type="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="col-12 form-group mg-t-10">
                                <label class="text-dark-medium">Photo de l'élève</label>
                                <input type="file" class="form-control-file" name="photo">
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Scolarité -->
                    <div class="tab-pane fade" id="academic" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Filière / Série</label>
                                <input name="filiere_serie" type="text" class="form-control" value="{{ old('filiere_serie') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Statut Inscription</label>
                                <select name="statut_inscription" class="form-control">
                                    <option value="nouvel_eleve" {{ old('statut_inscription') == 'nouvel_eleve' ? 'selected' : '' }}>Nouvel élève</option>
                                    <option value="redoublant" {{ old('statut_inscription') == 'redoublant' ? 'selected' : '' }}>Redoublant</option>
                                    <option value="transfere" {{ old('statut_inscription') == 'transfere' ? 'selected' : '' }}>Transféré</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Établissement précédent</label>
                                <input name="etablissement_precedent" type="text" class="form-control" value="{{ old('etablissement_precedent') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Groupe / Promotion</label>
                                <input name="groupe_promotion" type="text" class="form-control" value="{{ old('groupe_promotion') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Affecté de l'état *</label>
                                <select name="est_affecte" class="form-control" required>
                                    <option value="false" {{ old('est_affecte') == 'false' ? 'selected' : '' }}>Non</option>
                                    <option value="true" {{ old('est_affecte') == 'true' ? 'selected' : '' }}>Oui</option>
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
                                    <option value="">Inconnu</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Contact Urgence</label>
                                <input name="contact_urgence" type="text" class="form-control" value="{{ old('contact_urgence') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Médecin traitant</label>
                                <input name="medecin_traitant" type="text" class="form-control" value="{{ old('medecin_traitant') }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Allergies</label>
                                <textarea name="allergies" class="form-control" rows="3">{{ old('allergies') }}</textarea>
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Maladies particulières</label>
                                <textarea name="maladies" class="form-control" rows="3">{{ old('maladies') }}</textarea>
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Handicap éventuel</label>
                                <textarea name="handicap" class="form-control" rows="3">{{ old('handicap') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Parents -->
                    <div class="tab-pane fade" id="parents" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Nom du parent *</label>
                                <input name="parent_nom" type="text" class="form-control @error('parent_nom') is-invalid @enderror" value="{{ old('parent_nom') }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Prénom(s) parent *</label>
                                <input name="parent_prenom" type="text" class="form-control @error('parent_prenom') is-invalid @enderror" value="{{ old('parent_prenom') }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Profession parent</label>
                                <input name="profession" type="text" class="form-control" value="{{ old('profession') }}">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Relation *</label>
                                <select name="relation" class="form-control" required>
                                    <option value="pere">Père</option>
                                    <option value="mere">Mère</option>
                                    <option value="tuteur">Tuteur</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Téléphone parent *</label>
                                <input name="parent_telephone" type="text" class="form-control @error('parent_telephone') is-invalid @enderror" value="{{ old('parent_telephone') }}" required>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Email parent</label>
                                <input name="parent_email" type="email" class="form-control" value="{{ old('parent_email') }}">
                            </div>
                            <div class="col-xl-6 col-12 form-group">
                                <label>Adresse parent *</label>
                                <input name="parent_adresse" type="text" class="form-control @error('parent_adresse') is-invalid @enderror" value="{{ old('parent_adresse') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Observations -->
                    <div class="tab-pane fade" id="observations" role="tabpanel">
                        <div class="col-12 form-group">
                            <label>Observations des enseignants / Direction</label>
                            <textarea name="observations" class="form-control" rows="5">{{ old('observations') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 form-group mg-t-30">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer le dossier</button>
                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                </div>
            </form>
        </div>
    </div>
@endsection