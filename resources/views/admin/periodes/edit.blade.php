@extends('layouts.app')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Modifier la période</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li><a href="{{ route('admin.periodes.index') }}">Périodes</a></li>
            <li>Modifier</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Modifier la période : {{ $periode->nom }}</h3>
                </div>
            </div>
            <form class="new-added-form" method="POST" action="{{ route('admin.periodes.update', $periode->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Nom *</label>
                        <input type="text" name="nom" class="form-control" value="{{ $periode->nom }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Type *</label>
                        <select name="type" class="select2" required>
                            <option value="trimestre" {{ $periode->type == 'trimestre' ? 'selected' : '' }}>Trimestre</option>
                            <option value="semestre" {{ $periode->type == 'semestre' ? 'selected' : '' }}>Semestre</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Année Scolaire *</label>
                        <select name="annee_scolaire_id" class="select2" required>
                            @foreach($annees as $annee)
                                <option value="{{ $annee->id }}" {{ $periode->annee_scolaire_id == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->annee }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Status *</label>
                        <select name="status" class="select2" required>
                            <option value="ouvert" {{ $periode->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="fermé" {{ $periode->status == 'fermé' ? 'selected' : '' }}>Fermé</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date de début *</label>
                        <input type="date" name="date_debut" class="form-control" value="{{ $periode->date_debut }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date de fin *</label>
                        <input type="date" name="date_fin" class="form-control" value="{{ $periode->date_fin }}" required>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Mettre à jour</button>
                        <a href="{{ route('admin.periodes.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
