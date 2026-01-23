@extends('layouts.app')
@section('content') 
            <!-- Sidebar Area End Here -->
       
                <div class="breadcrumbs-area">
                    <h3>Étudiants</h3>
                    <ul>
                        <li>
                            <a href="{{ route('dashboard') }}">Étudiants</a>
                        </li>
                        <li>Formulaire pour modifier un étudiant</li>
                    </ul>
                </div>

                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Modifier les informations de l'étudiant </h3>   
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">...</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-times text-orange-red"></i>Fermer</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-cogs text-dark-pastel-green"></i>Modifier</a> 
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.etudiant.update', $etudiant->id) }}" method="POST" class="new-added-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <h4>Informations Élève</h4>
                                </div>
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
                                    <select name="sexe" class="form-select form-select-lg mb-3 px-3 bg-gray-200" required>
                                        <option value="">Veuillez sélectionner le sexe *</option>
                                        <option value="M" {{ old('sexe', $etudiant->sexe)=='M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe', $etudiant->sexe)=='F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Parent *</label>
                                    <select name="parent_id" class="select2" required>
                                        <option value="">Sélectionner un parent *</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_id')==$parent->id ? 'selected' : '' }}>{{ $parent->nom }} {{ $parent->prenom }}</option>
                                        @endforeach
                                    </select>
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
                                    <input name="date_naissance" type="date" class="form-control" value="{{ old('date_naissance', $etudiant->date_naissance) }}" required>
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Numéro de téléphone</label>
                                    <input name="phone" type="text" class="form-control" value="{{ old('phone', $etudiant->phone) }}">
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Adresse</label>
                                    <input name="address" type="text" class="form-control" value="{{ old('address', $etudiant->address) }}">
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>E-mail</label>
                                    <input name="email" type="email" class="form-control" value="{{ old('email', $etudiant->email) }}">
                                </div>
                                <div class="col-xl-3 col-lg-6 col-12 form-group">
                                    <label>Photo</label>
                                    <input name="photo" type="file" class="form-control">
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
