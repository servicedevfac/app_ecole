@extends('layouts.app')   
@section('content')

 
        <div class="breadcrumbs-area">
            <h3>Créer un niveau</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.niveau.index') }}">Niveaux</a>
                </li>
                <li>Créer un niveau</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.niveau.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom du niveau *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                                <label for="cycle_id">Cycle *</label>
                                <select name="cycle_id" id="cycle_id" class="form-control" required>
                                    @foreach($cycles as $cycle)
                                        <option value="{{ $cycle->id }}">{{ $cycle->nom }}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
