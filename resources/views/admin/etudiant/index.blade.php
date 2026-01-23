 
 @extends('layouts.app')
 @section('title', 'All Students')
 @section('content')
 


                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Students</h3>
                    <ul>
                        <li>
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li>Tous les étudiants</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Student Table Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Tous les étudiants</h3>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">...</a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <form class="mg-b-20">
                            <div class="row gutters-8">
                                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Roll ..." class="form-control">
                                </div>
                                <div class="col-3-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Name ..." class="form-control">
                                </div>
                                <div class="col-3-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Class ..." class="form-control">
                                </div>
                                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                                     <div class="col-2-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                     <a href="{{ route('admin.etudiant.create') }}" class="fw-btn-fill btn-gradient-blue">CRÉER UN ETUDIANT</a>
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
                                                <label class="form-check-label">Matricule</label>
                                            </div>
                                        </th>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Genre</th>
                                        <th>Classe</th>
                                        <th>Parents</th>
                                        <th>Adresse</th>
                                        <th>Date de naissance</th>
                                        <th>Téléphone</th>  
                                        <th>E-mail</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($etudiants as $etudiant)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">{{$etudiant->matricule}}</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="{{ asset('storage/' . $etudiant->photo) }}" alt="student" style="width: 50px; height: 50px;"></td>
                                        <td>{{$etudiant->nom}}</td>
                                        <td>{{$etudiant->prenom}}</td>
                                        <td>{{ $etudiant->sexe ?? $etudiant->gender }}</td>
                                        <td>{{ optional($etudiant->classe)->nom ?? 'Non assigné' }}</td>
            
                                        <td>
                                            @if($etudiant->parents && $etudiant->parents->count())
                                                @foreach($etudiant->parents as $parent)
                                                    {{ $parent->nom }} {{ $parent->prenom }}@if($parent->pivot && $parent->pivot->relation) ({{ $parent->pivot->relation }})@endif<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>   
                                        <td>{{$etudiant->address}}</td>
                                        <td>{{$etudiant->date_naissance}}</td>
                                        <td>+ {{$etudiant->phone}}</td>
                                        <td>{{$etudiant->email}}</td>
                                        <td>            
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('admin.etudiant.show', $etudiant->id)}}"><i
                                                            class="fas fa-times text-orange-red"></i>Voir</a>
                                                    <a class="dropdown-item" href="{{ route('admin.etudiant.edit', $etudiant->id)}}"><i
                                                            class="fas fa-cogs text-dark-pastel-green"></i>Modifier</a>
                                                    <a class="dropdown-item" href="{{ route('admin.etudiant.destroy', $etudiant->id) }}"><i
                                                            class="fas fa-redo-alt text-orange-peel"></i>Supprimer</a>
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
@endsection
