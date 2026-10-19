@extends('layouts.app')
@section('title', 'Emploi du temps')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Emploi du temps</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li>Emploi du temps par classe</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Liste des Classes</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.create') }}"><i
                                class="fas fa-plus text-green"></i>Nouveau créneau</a>
                    </div>
                </div>
            </div>

                <form class="mg-b-20" action="{{ route('admin.emploi_du_temps.index') }}" method="GET">
                    <div class="row gutters-8">
                        <div class="col-lg-4 col-12 form-group">
                            <select name="niveau_id" class="select2" onchange="this.form.submit()">
                                <option value="">Tous les niveaux</option>
                                @foreach($niveaux as $n)
                                    <option value="{{ $n->id }}" {{ request('niveau_id') == $n->id ? 'selected' : '' }}>
                                        {{ $n->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 form-group">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une classe..." class="form-control border-start-0 ps-0">
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
                            <tr class="bg-light">
                                <th>Classe</th>
                                <th>Niveau</th>
                                <th>Nombre de cours</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $classe)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm mr-3 bg-yellow-light text-yellow rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-school"></i>
                                            </div>
                                            <span class="font-weight-bold">{{ $classe->nom }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $classe->niveau->nom ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-pill badge-info" style="font-size: 13px; padding: 5px 15px;">
                                            {{ $classe->emplois_du_temps_count }} cours
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="flaticon-more-button-of-three-dots"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.by_classe', $classe->id) }}">
                                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>Voir l'emploi du temps
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.create', ['classe_id' => $classe->id]) }}">
                                                    <i class="fas fa-plus text-success mr-2"></i>Ajouter un cours
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.emploi_du_temps.classe_pdf', $classe->id) }}">
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>Télécharger PDF
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-5">
                                        <img src="{{ asset('img/no-data.png') }}" alt="No Data" style="max-width: 150px; opacity: 0.5;">
                                        <p class="mt-3 text-muted">Aucune classe trouvée pour cette sélection.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endsection