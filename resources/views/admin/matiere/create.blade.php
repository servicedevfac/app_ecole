@extends('layouts.app')   
@section('content')

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Créer une matière</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.matiere.index') }}">Matières</a>
                </li>
                <li>Créer une matière </li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.matiere.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Code *</label>
                        <input type="text" name="code" id="code" class="form-control" required>
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
