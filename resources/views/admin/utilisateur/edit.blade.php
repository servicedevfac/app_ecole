@extends('layouts.app')   
@section('content')
  


    
        <div class="breadcrumbs-area">
            <h3>Modifier un utilisateur</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.user.index') }}">All Users</a>
                </li>
                <li>Modifier</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe (Laisser vide pour ne pas changer)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmation du mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Rôle *</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
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
