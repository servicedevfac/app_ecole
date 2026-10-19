@extends('layouts.app')   
@section('content')

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
                <h3>Modifier une matière</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.matiere.index') }}">Matériers</a>
                </li>
                <li>Modifier une matière </li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.matiere.update', $matiere->id) }}" method="POST">
                    @csrf
                    @method('PUT')  
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control" value="{{ $matiere->nom }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Code *</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ $matiere->code }}" required>
                    </div>
            
                
                    <div class="form-group">
                        <label for="name">Cycle *</label>
                        <select type="text" name="cycle_id" id="cycle_id" class="form-control" required>
                            @foreach($cycles as $cycle)
                                <option value="{{ $cycle->id }}" {{ $cycle->id == $matiere->cycle_id ? 'selected' : '' }}>{{ $cycle->nom }}</option>
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
@endsection
