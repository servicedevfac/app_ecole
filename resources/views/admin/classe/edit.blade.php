@extends('layouts.app')
@section('content')

<div class="breadcrumbs-area">
    <h3>Modifier une classe</h3>
    <ul>
        <li>
            <a href="{{ route('admin.classe.index') }}">Classes</a>
        </li>
        <li>Modifier une classe</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        <form action="{{ route('admin.classe.update', $classe->id) }}" method="POST" class="new-added-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-12 form-group">
                    <label for="nom">Nom de la classe *</label>
                    <input type="text" name="nom" id="nom" class="form-control" required value="{{ old('nom', $classe->nom) }}">
                </div>
                <div class="col-xl-6 col-lg-6 col-12 form-group">
                    <label for="niveau_id">Niveau *</label>
                    <select name="niveau_id" id="niveau_id" class="form-control" required>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ (old('niveau_id', $classe->niveau_id) == $niveau->id) ? 'selected' : '' }}>
                                {{ $niveau->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 form-group mg-t-8">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Mettre à jour</button>
                    <a href="{{ route('admin.classe.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
