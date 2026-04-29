@extends('layouts.app')   
@section('content')

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Modifier un enseignant</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.enseignant.index') }}">Enseignants</a>
                </li>
                <li>Modifier un enseignant </li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.enseignant.update', $enseignant) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ $enseignant->nom }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenoms *</label>
                        <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ $enseignant->prenom }}" required>
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="specialite">Spécialité *</label>
                        <input type="text" name="specialite" id="specialite" class="form-control @error('specialite') is-invalid @enderror" value="{{ $enseignant->specialite }}" required>
                        @error('specialite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="text" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ $enseignant->telephone }}" required>
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $enseignant->email }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                        <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
