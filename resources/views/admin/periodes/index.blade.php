@extends('layouts.app')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Périodes scolaires</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li>Toutes les périodes</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Toutes les périodes scolaires</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.periodes.create') }}"
                        class="btn-fill-lg btn-gradient-yellow text-white">Ajouter une période</a>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Année Scolaire</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periodes as $periode)
                            <tr>
                                <td>{{ $periode->nom }}</td>
                                <td>{{ ucfirst($periode->type) }}</td>
                                <td>{{ $periode->anneeScolaire->annee }}</td>
                                <td>{{ $periode->date_debut }}</td>
                                <td>{{ $periode->date_fin }}</td>
                                <td>
                                    <span class="badge {{ $periode->status == 'ouvert' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($periode->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.periodes.edit', $periode->id) }}"><i
                                                    class="fas fa-edit text-green"></i>Modifier</a>
                                            <form action="{{ route('admin.periodes.destroy', $periode->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Confirmer la suppression ?');">
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

@endsection