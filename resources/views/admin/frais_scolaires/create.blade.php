@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Ajouter Frais Scolaire</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>
                <a href="{{ route('frais_scolaires.index') }}">Frais Scolaires</a>
            </li>
            <li>Ajouter</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Ajouter Frais Scolaire</h3>
                        </div>
                    </div>
                    <form class="new-added-form" method="POST" action="{{ route('frais_scolaires.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Niveau *</label>
                                <select name="niveau_id" class="select2" required>
                                    <option value="" disabled selected>Choisir un niveau</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Année Scolaire *</label>
                                <select name="annee_scolaire_id" class="select2" required>
                                    <option value="" disabled selected>Choisir une année</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}" {{ $annee->status == 'actif' ? 'selected' : '' }}>
                                            {{ $annee->annee }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Frais d'inscription</label>
                                <input type="number" name="frais_inscription" class="form-control" min="0" step="0.01"
                                    placeholder="Montant inscription">
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Frais de scolarité</label>
                                <input type="number" name="frais_Scolarité" class="form-control" min="0" step="0.01"
                                    placeholder="Montant scolarité">
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit"
                                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                                <button type="reset"
                                    class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection