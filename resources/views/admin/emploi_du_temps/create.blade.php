@extends('layouts.app')
@section('title', "Créer l'emploi du temps")
@section('content')
<div class="breadcrumbs-area">
    <h3>Emploi du temps</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
        <li>Créer</li>
    </ul>
    </div>

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Formulaire de création d'un créneau</h3>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="new-added-form" method="POST" action="{{ route('admin.emploi_du_temps.store') }}">
            @csrf
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Année scolaire *</label>
                    <select name="annee_scolaire_id" class="select2" required>
                        <option value="" disabled selected>Choisissez l'année</option>
                        @isset($annees)
                            @foreach($annees as $annee)
                                <option value="{{ $annee->id }}" {{ old('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->annee }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Classe *</label>
                    <select name="classe_id" class="select2" required id="classeSelect">
                        <option value="" disabled selected>Choisissez une classe</option>
                        @isset($classes)
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id', $selectedClasseId ?? null) == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Matière *</label>
                    <select name="matiere_id" class="select2" required id="matiereSelect">
                        <option value="" disabled selected>Choisissez une matière</option>
                        @isset($matieres)
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Enseignant *</label>
                    <select name="enseignant_id" class="select2" required id="enseignantSelect">
                        <option value="" disabled selected>Choisissez un enseignant</option>
                        @isset($enseignants)
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                    {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Jour *</label>
                    <select name="jours_id" class="select2" required>
                        <option value="" disabled selected>Choisissez un jour</option>
                        @isset($jours)
                            @foreach($jours as $jour)
                                <option value="{{ $jour->id }}" {{ old('jours_id') == $jour->id ? 'selected' : '' }}>
                                    {{ $jour->jours }}
                                </option>
                            @endforeach
                        @endisset   
                    </select>
                </div>

                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Horaire *</label>
                    <select name="horaire_id" class="select2" required id="horaireSelect">
                        <option value="" disabled selected>Choisissez un horaire</option>
                        @isset($horaires)
                            @foreach($horaires as $horaire)
                                <option value="{{ $horaire->id }}" {{ old('horaire_id') == $horaire->id ? 'selected' : '' }}>
                                    {{ $horaire->heure_debut }} - {{ $horaire->heure_fin }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>


                <div class="col-12 form-group">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
