@extends('layouts.app')   
@section('content')

    
        <div class="breadcrumbs-area">
            <h3>Modifier une année scolaire</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.annee.index') }}">Année scolaire</a>
                </li>
                <li>Modifier une année scolaire</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.annee.update', $annee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Année scolaire *</label> 
                        <input type="text" name="annee" id="annee" class="form-control" required value="{{ $annee->annee }}">
                    </div>
                    <div class="form-group">
                        <legend>Date de l'année scolaire *</legend>
                        <label for="name">Date de début *</label> 
                        <input type="date" name="date_debut" id="date_debut" class="form-control" required value="{{ $annee->date_debut }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Date de fin *</label> 
                        <input type="date" name="date_fin" id="date_fin" class="form-control" required value="{{ $annee->date_fin }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Statut *</label> 
                        <select name="status" id="status" class="form-control" required>
                            <option value="actif" {{ $annee->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactif" {{ $annee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
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
