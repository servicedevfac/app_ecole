@extends('layouts.app')   
@section('content')

    
        <div class="breadcrumbs-area">
            <h3>Créer une année scolaire</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.annee.index') }}">Année scolaire</a>
                </li>
                <li>Créer une année scolaire</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.annee.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Année scolaire *</label> 
                        <input type="text" name="annee" id="annee" class="form-control" required>
                    </div>
                    <div class="form-group">  
                        <legend>Date de l'année scolaire *</legend>
                        <label for="name">Date de début *</label> 
                        <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Date de fin *</label> 
                        <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                    </div>
     
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
