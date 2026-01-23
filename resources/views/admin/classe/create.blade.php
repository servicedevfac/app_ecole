@extends('layouts.app')   
@section('content')

   
        <div class="breadcrumbs-area">
            <h3>Créer une classe</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.classe.index') }}">Classes</a>
                </li>
                <li>Créer une classe</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.classe.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom de la classe *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                                <label for="niveau_id">Niveau *</label>
                                <select name="niveau_id" id="niveau_id" class="form-control" required>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
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
