@extends('layouts.app')
@section('content')



<div class="breadcrumbs-area">
    <h3>Toute les classe</h3>
    <ul>
        <li>
            <a href="index.html">Home</a>
        </li>
        <li>Subjects</li>
    </ul>
</div>

<div class="row">
    <div class="col-4-xxxl col-12">
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Créer une classe </h3>
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
                <form  class="new-added-form" method="POST" action="{{ route('admin.classe.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="name">Nom de la classe *</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="niveau_id">Niveau *</label>
                            <select name="niveau_id" id="niveau_id" class="form-control" required>
                                @foreach($niveaux as $niveau)
                                <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                     <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
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
                        <h3>Toute les classes</h3>
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
                                <th>Nom</th>
                                <th>Niveau</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $classe)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input">
                                        <label class="form-check-label"><a href="{{ route('admin.classe.show', $classe->id) }}">#{{ $classe->id }}</a></label>
                                    </div>
                                </td>
                                <td>{{ $classe->nom }}</td>
                                <td>{{ $classe->niveau->nom }}</td>
                                <td>{{ $classe->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.classe.show', $classe->id) }}"><i
                                                    class="fas fa-times text-orange-red"></i>Voir</a>
                                            <a class="dropdown-item" href="{{ route('admin.classe.edit', $classe->id) }}"><i
                                                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <form action="{{ route('admin.classe.destroy', $classe->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')"><i
                                                        class="fas fa-trash-alt text-orange-red"></i>Supprimer</button>
                                            </form>
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