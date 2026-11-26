@extends('layouts.app')
@section('content')


          
            <!-- Sidebar Area End Here -->
         
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Rôles</h3>
                    <ul>
                        <li>
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li>Tous les rôles</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Class Table Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Tous les rôles</h3>
                            </div>
                            @can('utilisateurs.create')
                            <div class="dropdown">
                                <a href="{{ route('admin.role.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark text-white">
                                    <i class="fas fa-plus mr-2"></i> Ajouter un rôle
                                </a>
                            </div>
                            @endcan
                        </div>
                       
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th> 
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkAll">
                                                <label class="form-check-label">ID</label>
                                            </div>
                                        </th>
                                        <th>Nom</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">{{ $role->id }}</label>
                                            </div>
                                        </td>
                                        <td>{{ $role->name }}</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
            
                                                    @can('utilisateurs.update')
                                                    @if ($role->name != 'Super Admin')
                                                    <a class="dropdown-item" href="{{ route('admin.role.permissions', $role->id) }}"><i class="fas fa-key text-orange-peel"></i> Permissions</a>
                                                    @endif
                                                    @if (!in_array($role->name, ['Utilisateur', 'Super Admin'])) {{-- pas modifier les roles Utilisateur et Super Admin --}}
                                                    <a class="dropdown-item" href="{{ route('admin.role.edit', $role->id) }}"><i class="fas fa-edit text-green"></i>  Modifier</a>
                                                    @endif
                                                    @endcan
                                                    @if ($role->name != 'Super Admin') {{-- pas supprimer le role super admin --}}
                                                    @can('utilisateurs.delete')
                                                    <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Confirmer la suppression ?');">
                                                            <i class="fas fa-trash text-red"></i>  Supprimer
                                                        </button>
                                                    </form>
                                                    @endcan
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                            
                             

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 