@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Sécurité du Compte</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Modifier le mot de passe</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Modifier le mot de passe</h3>
                </div>
            </div>
            <form action="{{ route('parent.password.update') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Mot de passe actuel *</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Nouveau mot de passe *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Confirmer le nouveau mot de passe *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
