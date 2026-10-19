@extends('layouts.app')

@section('content')
<div class="breadcrumbs-area">
    <h3>Gestion des Permissions</h3>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">Home</a>
        </li>
        <li>
            <a href="{{ route('admin.role.index') }}">Rôles</a>
        </li>
        <li>Permissions pour {{ $role->name }}</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Assigner des permissions au rôle : <span class="text-orange-peel">{{ $role->name }}</span></h3>
            </div>
        </div>

        <form action="{{ route('admin.role.update_permissions', $role->id) }}" method="POST" class="new-added-form">
            @csrf
            
            <div class="row gutters-20">
                @php
                    // Regroupement des permissions par module (ex: etudiants.view -> etudiants)
                    $groupedPermissions = $permissions->groupBy(function($item) {
                        $parts = explode('.', $item->name);
                        return count($parts) > 1 ? $parts[0] : 'Autres';
                    });
                @endphp

                @foreach($groupedPermissions as $module => $perms)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="permission-group-card p-4 border rounded shadow-sm bg-light h-100">
                        <h4 class="text-dark bg-yellow p-2 rounded text-center text-capitalize mb-3">
                            <i class="fas fa-folder-open mr-2"></i> {{ $module }}
                        </h4>
                        <div class="permission-list">
                            @foreach($perms as $permission)
                            <div class="form-check mb-2 d-flex align-items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                    id="perm_{{ $permission->id }}" class="form-check-input"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                <label for="perm_{{ $permission->id }}" class="form-check-label ml-2">
                                    {{ str_replace(['.', '_'], ' ', $permission->name) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-12 form-group mg-t-30">
                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                    <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('admin.role.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow ml-2 text-white">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .permission-group-card {
        transition: transform 0.2s ease, shadow 0.2s ease;
        border-bottom: 4px solid #fec107 !important;
    }
    .permission-group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .permission-group-card h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: -10px;
    }
    .form-check-label {
        font-weight: 400;
        color: #555;
        cursor: pointer;
        transition: color 0.2s;
    }
    .form-check-input:checked + .form-check-label {
        color: #000;
        font-weight: 500;
    }
</style>
@endsection
