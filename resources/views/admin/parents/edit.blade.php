@extends('layouts.app')
@section('content')

<!-- Breadcubs Area Start Here -->
<div class="breadcrumbs-area">
    <h3>Modifier le Parent</h3>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">Accueil</a>
        </li>
        <li>
            <a href="{{ route('admin.parent.index') }}">Parents</a>
        </li>
        <li>Modifier le parent</li>
    </ul>
</div>
<!-- Breadcubs Area End Here -->

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Informations du Parent : {{ $parent->nom }} {{ $parent->prenom }}</h3>
            </div>
        </div>
        <form action="{{ route('admin.parent.update', $parent->id) }}" method="POST" class="new-added-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $parent->nom) }}" class="form-control" required>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $parent->prenom) }}" class="form-control" required>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email', $parent->email) }}" class="form-control" required>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Téléphone *</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $parent->telephone) }}" class="form-control" required>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Autre téléphone</label>
                    <input type="text" name="autre_telephone" value="{{ old('autre_telephone', $parent->autre_telephone) }}" class="form-control">
                </div>
                <div class="col-xl-9 col-lg-12 col-12 form-group">
                    <label>Adresse *</label>
                    <input type="text" name="adresse" value="{{ old('adresse', $parent->adresse) }}" class="form-control" required>
                </div>
                
                <div class="col-12 form-group mg-t-8">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Mettre à jour</button>
                    <a href="{{ route('admin.parent.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
