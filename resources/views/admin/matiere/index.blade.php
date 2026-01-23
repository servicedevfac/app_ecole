@extends('layouts.app')
@section('content')



<div class="breadcrumbs-area">
    <h3>All Subjects</h3>
    <ul>
        <li>
            <a href="index.html">Home</a>
        </li>
        <li>Subjects</li>
    </ul>
</div>
<!-- Breadcubs Area End Here -->
<!-- All Subjects Area Start Here -->
<div class="row">
    <div class="col-4-xxxl col-12">
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Add New Subject</h3>
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
                <form class="new-added-form" method="POST" action="{{ route('admin.matiere.assignematiere.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Classe *</label>
                            <select name="classe_id" class="select2" required id="classeSelect">
                                <option value="" disabled selected>Choisissez une classe</option>
                                @foreach($classes as $classe)
                                <option value="{{$classe->id}}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{$classe->nom}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Matière *</label>
                            <select name="matiere_id" class="select2" required id="matiereSelect">
                                <option value="" disabled selected>Choisissez une matière</option>
                                @foreach($matieres as $matiere)
                                <option value="{{$matiere->id}}" data-cycle="{{$matiere->cycle_id}}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{$matiere->nom}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Classe -->
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Coeficient *</label>
                            <input type="number" name="coefficient" id="coefficient" class="form-control" required>
                        </div>

                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-8-xxxl col-12">
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>All Subjects</h3>
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
                        <div class="col-lg-4 col-12 form-group">
                            <input type="text" placeholder="Search by Exam ..." class="form-control">
                        </div>
                        <div class="col-lg-3 col-12 form-group">
                            <input type="text" placeholder="Search by Subject ..." class="form-control">
                        </div>
                        <div class="col-lg-3 col-12 form-group">
                            <input type="text" placeholder="dd/mm/yyyy" class="form-control">
                        </div>
                        <div class="col-lg-2 col-12 form-group">
                            <button type="submit"
                                class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
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
                                        <label class="form-check-label">ID</label>
                                    </div>
                                </th>
                                <th>Matière</th>
                                <th>Code</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matieres as $matiere)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input">
                                        <label class="form-check-label">#{{ $matiere->id }}</label>
                                    </div>
                                </td>
                                <td>{{ $matiere->nom }}</td>
                                <td>{{ $matiere->code }}</td>
                                <td>{{ $matiere->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.matiere.show', $matiere->id) }}"><i
                                                    class="fas fa-times text-orange-red"></i>Voir</a>
                                            <a class="dropdown-item" href="{{ route('admin.matiere.edit', $matiere->id) }}"><i
                                                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="{{ route('admin.matiere.destroy', $matiere->id) }}"><i
                                                    class="fas fa-trash-alt text-orange-red"></i>Supprimer</a>
                                        </div>
                                    </div>
                                </td>
                                @endforeach
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection