@extends('layouts.app')   
@section('content')

    
        <div class="breadcrumbs-area">
            <h3>Créer un utilisateur</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.utilisateur.index') }}">Utilisateurs</a>
                </li>
                <li>Créer</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <form action="{{ route('admin.utilisateur.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe *</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmation du mot de passe *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Rôle *</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
