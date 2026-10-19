@extends('layouts.app')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Ajouter une période</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li><a href="{{ route('admin.periodes.index') }}">Périodes</a></li>
            <li>Nouvelle période</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Nouvelle période scolaire</h3>
                </div>
            </div>
            <form class="new-added-form" method="POST" action="{{ route('admin.periodes.store') }}">
                @csrf
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Nom *</label>
                        <input type="text" name="nom" class="form-control" placeholder="ex: 1er Trimestre" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Type *</label>
                        <select name="type" class="form-control" required>
                            <option value="">Sélectionner</option>
                            <option value="trimestre">Trimestre</option>
                            <option value="semestre">Semestre</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Année Scolaire *</label>
                        <select name="annee_scolaire_id" class="form-control" required>
                            <option value="">Sélectionner</option>
                            @foreach($annees as $annee)
                                <option value="{{ $annee->id }}">{{ $annee->annee }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="ouvert">Ouvert</option>
                            <option value="fermé">Fermé</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date de début *</label>
                        <input type="date" name="date_debut" class="form-control" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date de fin *</label>
                        <input type="date" name="date_fin" class="form-control" required>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit"
                            class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                        <a href="{{ route('admin.periodes.index') }}"
                            class="btn-fill-lg bg-blue-dark btn-hover-yellow">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection