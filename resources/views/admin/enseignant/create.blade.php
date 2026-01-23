@extends('layouts.app')   
@section('content')

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Créer un enseignant</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.enseignant.index') }}">Enseignants</a>
                </li>
                <li>Créer un enseignant </li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.enseignant.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Prenoms *</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Spécialité *</label>
                        <input type="text" name="specialite" id="specialite" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Adresse  *</label>
                        <input type="text" name="adresse" id="adresse" class="form-control" required>   
                    </div>
                    <div class="form-group">
                        <label for="name">Téléphone *</label>
                        <input type="text" name="telephone" id="telephone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required>
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
