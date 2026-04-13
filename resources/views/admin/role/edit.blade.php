@extends('layouts.app')   
@section('content')

    <div class="breadcrumbs-area">
        <h3>Modifier le rôle</h3>
        <ul>
            <li>
                <a href="{{ route('admin.role.index') }}">Rôles</a>
            </li>
            <li>Modifier</li>
        </ul>
    </div>  
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Modifier : {{ $role->name }}</h3>
                </div>
            </div>
            <form action="{{ route('admin.role.update', $role->id) }}" method="POST" class="new-added-form">
                @csrf
                @method('PUT')
                <div class="row gutters-20">
                    <div class="col-xl-12 col-lg-12 col-12 form-group">
                        <label for="name">Nom du rôle *</label>
                        <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control" required>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer les modifications</button>
                        <a href="{{ route('admin.role.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow text-white">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
