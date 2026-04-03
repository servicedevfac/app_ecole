@extends('layouts.app')
@section('title', 'Liste des inscriptions')
@section('content')

<div class="breadcrumbs-area">
    <h3>Gestion des Inscriptions</h3>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">Accueil</a>
        </li>
        <li>Inscriptions</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">

        <div class="heading-layout1">
            <div class="item-title">
                <h3>Toutes les Inscriptions</h3>
            </div>
        </div>

        <!-- Section de recherche et filtres rapides -->
        <form class="mg-b-20 mt-4" method="GET" action="{{ route('admin.inscription.index') }}">
            <div class="row gutters-8">
                <div class="col-lg-3 col-12 form-group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou matricule..." class="form-control bg-light border-0 shadow-sm">
                </div>
                <div class="col-lg-3 col-12 form-group">
                    <select name="status" class="select2 bg-light border-0 shadow-sm">
                        <option value="">Tous les status</option>
                        <option value="inscrite" {{ request('status') == 'inscrite' ? 'selected' : '' }}>Inscrite</option>
                        <option value="suspendue" {{ request('status') == 'suspendue' ? 'selected' : '' }}>Suspendue</option>
                        <option value="abandon" {{ request('status') == 'abandon' ? 'selected' : '' }}>Abandon</option>
                    </select>
                </div>
                <div class="col-lg-2 col-12 form-group d-flex" style="gap: 5px;">
                    <button type="submit" class="fw-btn-fill btn-gradient-yellow" title="Rechercher">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->has('search') || request()->has('status'))
                        <a href="{{ route('admin.inscription.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow" style="display: flex; align-items: center; justify-content: center; width: 50px;" title="Réinitialiser">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
                <div class="col-lg-4 col-12 form-group text-right">
                    <a href="{{ route('admin.inscription.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark w-100" style="display: block; text-align: center;">
                        <i class="fas fa-plus mr-2"></i>Nouvelle Inscription
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table display data-table text-nowrap">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Étudiant</th>
                        <th class="border-0">Année</th>
                        <th class="border-0">Parcours (C/N/C)</th>
                        <th class="border-0">Statut</th>
                        <th class="border-0 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $inscription)
                    <tr class="hover-shadow">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm mr-3">
                                    @if($inscription->student && $inscription->student->photo)
                                        <img src="{{ asset('storage/' . $inscription->student->photo) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold" 
                                             style="width: 40px; height: 40px; background: linear-gradient(45deg, #3f51b5, #5c6bc0);">
                                            {{ strtoupper(substr($inscription->student->nom ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="student-identity">
                                    <h6 class="mb-0 text-dark font-weight-600">{{ $inscription->student->nom ?? 'N/A' }} {{ $inscription->student->prenom ?? '' }}</h6>
                                    <small class="text-muted"><i class="fas fa-id-badge mr-1"></i>{{ $inscription->student->matricule ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="badge badge-pill badge-light text-dark px-3 p-2 shadow-sm border">
                                {{ $inscription->anneeScolaire->annee ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <span class="text-dark font-weight-bold">{{ optional($inscription->cycle)->nom ?? 'N/A' }}</span>
                            <div class="text-muted small">
                                {{ optional($inscription->niveau)->nom ?? 'N/A' }} <i class="fas fa-angle-right mx-1"></i> {{ optional($inscription->classe)->nom ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'inscrite' => 'btn-success',
                                    'suspendue' => 'btn-warning',
                                    'abandon' => 'btn-danger'
                                ][$inscription->status] ?? 'btn-secondary';
                                
                                $statusLabel = [
                                    'inscrite' => 'Inscrite',
                                    'suspendue' => 'Suspendue',
                                    'abandon' => 'Abandon'
                                ][$inscription->status] ?? $inscription->status;
                            @endphp
                            <span class="badge {{ $statusClass }} p-2 px-3 text-white" style="border-radius: 30px;">
                                <i class="fas {{ $inscription->status == 'inscrite' ? 'fa-check-circle' : ($inscription->status == 'suspendue' ? 'fa-pause-circle' : 'fa-times-circle') }} mr-1"></i>
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.inscription.edit', $inscription->id) }}" 
                                   class="btn btn-primary d-flex align-items-center justify-content-center p-2 mr-2" 
                                   title="Modifier" style="width: 35px; height: 35px; border-radius: 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.inscription.destroy', $inscription->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cette inscription ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center p-2" 
                                            title="Supprimer" style="width: 35px; height: 35px; border-radius: 8px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


<style>
    .hover-shadow:hover {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    }
    .student-identity h6 {
        letter-spacing: 0.3px;
    }
    .avatar-sm {
        flex-shrink: 0;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
</style>

@endsection
