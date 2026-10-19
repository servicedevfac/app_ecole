@extends('layouts.app')
@section('content')

<!-- Breadcubs Area Start Here -->
<div class="breadcrumbs-area">
    <h3>Gestion des Parents</h3>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">Accueil</a>
        </li>
        <li>Parents</li>
    </ul>
</div>
<!-- Breadcubs Area End Here -->

<!-- Parent Table Area Start Here -->
<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Liste des Parents</h3>
            </div>
            <div class="dropdown">
                <a class="fw-btn-fill btn-gradient-yellow" href="{{ route('admin.parent.create') }}">
                    <i class="fas fa-plus"></i> Nouveau Parent
                </a>
            </div>
        </div>
        
        <form class="mg-b-20" method="GET" action="{{ route('admin.parent.index') }}">
            <div class="row gutters-8">
                <div class="col-lg-10 col-12 form-group">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, email ou téléphone..." class="form-control border-start-0 ps-0">
                    </div>
                </div>
                <div class="col-lg-2 col-12 form-group">
                    <button type="submit" class="fw-btn-fill btn-gradient-yellow w-100">FILTRER</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table display data-table text-nowrap table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Parent</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Enfants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parents as $parent)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.parent.show', $parent->id) }}'">
                        <td>{{ $parent->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-container mr-3">
                                    <div class="bg-gradient-yellow text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold; background-color: #ffbc00;">
                                        {{ strtoupper(substr($parent->nom, 0, 1)) }}{{ strtoupper(substr($parent->prenom, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold text-dark">{{ $parent->nom }} {{ $parent->prenom }}</div>
                                    <small class="text-muted">Parent ID: {{ $parent->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="far fa-envelope text-orange-peel mr-2"></i>{{ $parent->email }}
                        </td>
                        <td>
                            <i class="fas fa-phone text-dark-pastel-green mr-2"></i>{{ $parent->telephone }}
                        </td>
                        <td>
                            <span class="badge badge-pill badge-info" style="font-size: 14px;">
                                {{ $parent->students_count }} {{ Str::plural('enfant', $parent->students_count) }}
                            </span>
                        </td>
                        <td onclick="event.stopPropagation();" style="text-align: center;">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 10px;">
                                    <i class="fas fa-ellipsis-v text-dark"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('admin.parent.show', $parent->id) }}">
                                        <i class="fas fa-eye text-primary mr-2"></i>Détails
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.parent.edit', $parent->id) }}">
                                        <i class="fas fa-edit text-success mr-2"></i>Modifier
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('admin.parent.destroy', $parent->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash-alt mr-2"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle mr-2"></i> Aucun parent trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Affichage de {{ $parents->firstItem() ?? 0 }} à {{ $parents->lastItem() ?? 0 }} sur {{ $parents->total() }} parents
                </div>
                <div>
                    {{ $parents->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-container {
        flex-shrink: 0;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 188, 0, 0.05) !important;
    }
    .badge-info {
        background-color: #3f51b5;
    }
    .input-group-text {
        border-radius: 4px 0 0 4px;
    }
    .form-control {
        border-radius: 0 4px 4px 0;
    }
    .btn-gradient-yellow {
        color: #ffffff;
        background: linear-gradient(180deg, #ffbc00 0%, #ff9800 100%);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gradient-yellow:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        color: #fff;
    }
    .dropdown-item {
        padding: 0.5rem 1.5rem;
        transition: all 0.2s;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    .table-responsive {
        overflow: visible !important;
    }
    .dropdown-toggle::after {
        display: none !important;
    }
</style>

@endsection
 