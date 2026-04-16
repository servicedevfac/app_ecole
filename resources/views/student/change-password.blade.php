@extends('layouts.app')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Changement de mot de passe</h3>
        <ul>
            <li>
                <a href="{{ route('student.dashboard') }}">Accueil</a>
            </li>
            <li>Modification du mot de passe</li>
        </ul>
    </div>

    <div class="row gutters-20">
        <div class="col-xl-12 col-12">
            <div class="card dashboard-card-one pd-b-20">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Sécurisez votre compte</h3>
                        </div>
                    </div>
                    
                    @if(auth()->user()->must_change_password)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Ceci est votre première connexion. Pour la sécurité de votre compte, vous devez obligatoirement modifier votre mot de passe par défaut.
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <form action="{{ route('student.password.update') }}" method="POST" class="new-added-form">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4 mg-b-20">
                                <label>Mot de passe actuel *</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mg-b-20">
                                <label>Nouveau mot de passe *</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mg-b-20">
                                <label>Confirmer le nouveau mot de passe *</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            
                            <div class="col-12 mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluewood">Enregistrer les changements</button>
                                @if(!auth()->user()->must_change_password)
                                    <a href="{{ route('student.dashboard') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Annuler</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
