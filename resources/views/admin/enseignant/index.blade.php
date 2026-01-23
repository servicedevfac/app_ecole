@extends('layouts.app')
@section('content')


          
            <!-- Sidebar Area End Here -->
         
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Tous les enseignants</h3>
                    <ul>
                        <li>
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li>Tous les enseignants</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Class Table Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Tous les enseignants</h3>   
                            </div>
                           <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" 
                                data-toggle="dropdown" aria-expanded="false">...</a>
        
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red "></i>Close</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <form class="mg-b-20">
                            <div class="row gutters-8">
                                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by ID ..." class="form-control">
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Name ..." class="form-control">
                                </div>
                                <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Specialité ..." class="form-control">
                                </div>
                                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th> 
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkAll">
                                                <label class="form-check-label">Enseignant ID</label>
                                            </div>
                                        </th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Spécialité</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enseignants as $enseignant)   
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">{{ $enseignant->id }}</label>
                                            </div>
                                        </td>
                                        <td>{{ $enseignant->nom }}</td>
                                        <td>{{ $enseignant->prenom }}</td>
                                        <td>{{ $enseignant->specialite }}</td>
                                        <td>{{ $enseignant->email }}</td>
                                        <td>{{ $enseignant->telephone }}</td>   
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ route('admin.enseignant.show', $enseignant->id) }}"><i class="fas fa-eye text-blue"></i>Voir</a>
                                                    <a class="dropdown-item" href="{{ route('admin.enseignant.edit', $enseignant->id) }}"><i class="fas fa-edit text-green"></i>Modifier</a>
                                                    <form action="{{ route('admin.enseignant.destroy', $enseignant->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Confirmer la suppression ?');">
                                                            <i class="fas fa-trash text-red"></i>Supprimer
                                                        </button>
                                                    </form>
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