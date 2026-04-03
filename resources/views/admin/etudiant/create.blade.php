@extends('layouts.app')
@section('content') 
            <!-- Sidebar Area End Here -->
       
                <div class="breadcrumbs-area">
                    <h3>Etudiants</h3>
                    <ul>
                        <li>
                            <a href="{{route('dashboard')}}">Home</a>
                        </li>
                        <li>Formulaire pour ajouter un étudiant</li>
                    </ul>
                </div>
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Ajouter un nouvel étudiant </h3>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">...</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.etudiant.store') }}" method="POST" class="new-added-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h4>Informations Élève</h4>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Nom *</label>
                                    <input name="nom" type="text" class="form-control" value="{{ old('nom') }}" required>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Prénoms *</label>
                                    <input name="prenom" type="text" class="form-control" value="{{ old('prenom') }}" required>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Sexe *</label>
                                    <select name="sexe" class="form-select form-select-lg mb-3 px-3 bg-gray-200" required>
                                        <option value="">Veuillez sélectionner le sexe *</option>
                                        <option value="M" {{ old('sexe')=='M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe')=='F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-4">
                                    <h4>Informations Parent (Nouveau ou Existant)</h4>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Nom du parent *</label>
                                    <input name="parent_nom" type="text" class="form-control" value="{{ old('parent_nom') }}" required>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Prénom(s) parent *</label>
                                    <input name="parent_prenom" type="text" class="form-control" value="{{ old('parent_prenom') }}" required>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Téléphone parent *</label>
                                    <input name="parent_telephone" type="text" class="form-control" value="{{ old('parent_telephone') }}" required>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Email parent</label>
                                    <input name="parent_email" type="email" class="form-control" value="{{ old('parent_email') }}">
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Adresse parent *</label>
                                    <input name="parent_adresse" type="text" class="form-control" value="{{ old('parent_adresse') }}" required>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Relation *</label>
                                    <select name="relation" class="select2" required>
                                        <option value="">Lien de parenté *</option>
                                        <option value="pere" {{ old('relation')=='pere' ? 'selected' : '' }}>Père</option>
                                        <option value="mere" {{ old('relation')=='mere' ? 'selected' : '' }}>Mère</option>
                                        <option value="tuteur" {{ old('relation')=='tuteur' ? 'selected' : '' }}>Tuteur</option>
                                        <option value="frere" {{ old('relation')=='frere' ? 'selected' : '' }}>Frère</option>
                                        <option value="soeur" {{ old('relation')=='soeur' ? 'selected' : '' }}>Sœur</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Date de naissance *</label>
                                    <input name="date_naissance" type="date" class="form-control" value="{{ old('date_naissance') }}" required>
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Numéro de téléphone</label>
                                    <input name="phone" type="text" class="form-control" value="{{ old('phone') }}">
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Adresse</label>
                                    <input name="address" type="text" class="form-control" value="{{ old('address') }}">
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>E-mail</label>
                                    <input name="email" type="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                    <div class="col-lg-6 col-12 form-group mg-t-30">
                                    <label class="text-dark-medium">Upload Student Photo (150px X 150px)</label>
                                    <input type="file" class="form-control-file" name='photo'>
                                </div>
                                       
                            </div>
                            <div class="row">
                                <div class="col-12 form-group mg-t-8">
                                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                                </div>
                               

                            </div>
                        </form>
                    </div>
                            
                </div>
            
@endsection
