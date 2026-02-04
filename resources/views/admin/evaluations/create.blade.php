@extends('layouts.app')   
@section('content')

    
        <div class="breadcrumbs-area">
            <h3>Créer une évaluation</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.evaluation.index') }}">Évaluation</a>
                </li>
                <li>Créer une évaluation</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.evaluation.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom de l'évaluation *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Type d'évaluation *</label>
                        <input type="text" name="type" id="type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Date d'évaluation *</label>
                        <input type="date" name="date_evaluation" id="date_evaluation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Coefficient *</label>
                        <input type="number" name="coefficient" id="coefficient" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Note maximale *</label>
                        <input type="number" name="note_max" id="note_max" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Statut *</label>
                        <input type="text" name="statut" id="statut" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Classe *</label>
                        <input type="text" name="classe_id" id="classe_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Matière *</label>
                        <input type="text" name="matiere_id" id="matiere_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Enseignant *</label>
                        <input type="text" name="enseignant_id" id="enseignant_id" class="form-control" required>
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
