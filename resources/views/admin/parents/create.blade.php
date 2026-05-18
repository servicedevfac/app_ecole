@extends('layouts.app')   
@section('content')

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Ajouter un Parent</h3>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">Accueil</a>
                </li>
                <li>
                    <a href="{{ route('admin.parent.index') }}">Parents</a>
                </li>
                <li>Ajouter un parent</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Informations du Nouveau Parent</h3>
                    </div>
                </div>
                <form action="{{ route('admin.parent.store') }}" method="POST" class="new-added-form">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Nom *</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Prénom *</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Téléphone *</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Autre téléphone</label>
                            <input type="text" name="autre_telephone" value="{{ old('autre_telephone') }}" class="form-control">
                        </div>
                        <div class="col-xl-9 col-lg-12 col-12 form-group">
                            <label>Adresse *</label>
                            <input type="text" name="adresse" value="{{ old('adresse') }}" class="form-control" required>
                        </div>
                        
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
