@extends('layouts.app')
@section('title', 'Liste des inscriptions')
@section('content')

<div class="breadcrumbs-area">
    <h3>Inscriptions</h3>  
    <ul>
        <li><a href="index.html">Home</a></li>
        <li>Liste des inscriptions</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">

        <div class="heading-layout1">
            <div class="item-title">
                <h3>Liste des inscriptions</h3>
            </div>
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.inscription.create') }}">
                        <i class="fas fa-plus text-dark-pastel-green"></i>Nouvelle inscription
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table display data-table text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Étudiant</th>
                        <th>Année scolaire</th>
                        <th>Cycle</th>
                        <th>Niveau</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $inscription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($inscription->student)->nom }} {{ optional($inscription->student)->prenom }}</td>
                        <td>{{ $inscription->anneeScolaire->annee ?? 'N/A' }}</td>
                        <td>{{ optional($inscription->cycle)->nom ?? 'N/A' }}</td>
                        <td>{{ optional($inscription->niveau)->nom ?? 'N/A' }}</td>
                        <td>{{ optional($inscription->classe)->nom ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.inscription.edit', $inscription->id) }}" class="btn btn-sm btn-info">Éditer</a>

                            <form action="{{ route('admin.inscription.destroy', $inscription->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cette inscription ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
