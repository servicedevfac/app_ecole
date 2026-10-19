@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Configuration Scolaire</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Liste des Cycles</li>
        </ul>
    </div>

    <div class="row">
        <!-- Stats Cards -->
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-calendar text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Cycles</div>
                            <div class="item-number"><span class="text-dark font-weight-bold">{{ count($cycles) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-green">
                            <i class="flaticon-list text-green"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Niveaux</div>
                            <div class="item-number"><span class="text-dark font-weight-bold">{{ $cycles->sum(fn($c) => $c->niveaux->count()) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cycle Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Tous les Cycles</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.cycle.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                        <i class="fas fa-plus mg-r-8"></i> Nouveau Cycle
                    </a>
                </div>
            </div>

            <!-- Simplified Search -->
            <div class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-lg-10 col-12 form-group">
                        <input type="text" id="cycleSearch" placeholder="Rechercher un cycle..." class="form-control" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>
                    <div class="col-lg-2 col-12 form-group">
                        <button type="button" class="fw-btn-fill btn-gradient-yellow">RECHERCHER</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Nom du Cycle</th>
                            <th>Niveaux Associés</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cycleTableBody">
                        @foreach($cycles as $cycle)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-graduation-cap text-primary"></i>
                                    </div>
                                    <span class="font-weight-bold">{{ $cycle->nom }}</span>
                                </div>
                            </td>
                             <td>
                                <span class="badge badge-pill badge-light p-2 px-3 border text-dark">
                                    <i class="fas fa-layer-group text-muted mg-r-5"></i> {{ $cycle->niveaux->count() }} Niveaux
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                    <a href="{{ route('admin.cycle.edit', $cycle->id) }}" class="btn btn-sm bg-light text-success border-success" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.cycle.destroy', $cycle->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-light text-danger border-danger" title="Supprimer" onclick="return confirm('Confirmer la suppression ?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $cycles->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('cycleSearch').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelector("#cycleTableBody").rows;
            for (let i = 0; i < rows.length; i++) {
                let firstCol = rows[i].cells[0].textContent.toUpperCase();
                if (firstCol.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    </script>
    @endpush
@endsection