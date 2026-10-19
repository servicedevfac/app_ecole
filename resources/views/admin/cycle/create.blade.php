@extends('layouts.app')   
@section('content')

    
        <div class="breadcrumbs-area">
            <h3>Créer un cycle</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.cycle.index') }}">Cycle</a>
                </li>
                <li>Créer un cycle</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.cycle.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom du cycle *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
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
