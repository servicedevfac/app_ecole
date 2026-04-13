@extends('layouts.app')   
@section('content')

    
        <div class="breadcrumbs-area">
            <h3>Créer un rôle</h3>
            <ul>
                <li>
                    <a href="{{ route('admin.role.index') }}">Rôles</a>
                </li>
                <li>Créer</li>
            </ul>
        </div>  
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Nouveau Rôle</h3>
                    </div>
                </div>
                <form action="{{ route('admin.role.store') }}" method="POST" class="new-added-form">
                    @csrf
                    <div class="row gutters-20">
                        <div class="col-xl-12 col-lg-12 col-12 form-group">
                            <label for="name">Nom du rôle *</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="ex: Comptable" required>
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                                <i class="fas fa-redo mr-2"></i> Réinitialiser
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
