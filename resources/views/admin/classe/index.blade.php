@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Configuration Scolaire</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Liste des Classes</li>
        </ul>
    </div>

    <div class="row">
        <!-- Stats Cards -->
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue shadow-sm">
                            <i class="flaticon-classmates text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Classes</div>
                            <div class="item-number"><span class="text-dark font-weight-bold">{{ $allClasses->count() }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-green shadow-sm">
                            <i class="flaticon-user text-green"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Élèves Totaux</div>
                            <div class="item-number"><span class="text-dark font-weight-bold">{{ $allClasses->sum(fn($c) => $c->inscriptions->count()) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Classe Table Area Start Here -->
    <div class="card height-auto shadow-sm">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Toutes les Classes</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.classe.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark shadow-sm">
                        <i class="fas fa-plus mg-r-8"></i> Nouvelle Classe
                    </a>
                </div>
            </div>

            <!-- Unified Search -->
            <div class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-lg-10 col-12 form-group">
                        <input type="text" id="classeSearch" placeholder="Rechercher une classe, un niveau..." class="form-control" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
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
                            <th>Nom de la Classe</th>
                            <th>Niveau</th>
                            <th>Effectif</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classeTableBody">
                        @foreach($allClasses as $classe)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light-blue rounded mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-chalkboard text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="font-weight-bold d-block">{{ $classe->nom }}</span>
                                        <small class="text-muted">Créée le {{ $classe->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-light p-2 px-3 border text-dark">
                                    <i class="fas fa-layer-group text-muted mg-r-5"></i> {{ $classe->niveau->nom }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-info p-2 px-3">
                                    <i class="fas fa-users mg-r-5"></i> {{ $classe->inscriptions->count() }} Élèves
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                    <a href="{{ route('admin.classe.show', $classe->id) }}" class="btn btn-sm bg-light text-blue border-blue" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.classe.export_students', $classe->id) }}" class="btn btn-sm bg-light text-warning border-warning" title="Exporter la liste des élèves">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('admin.classe.edit', $classe->id) }}" class="btn btn-sm bg-light text-success border-success" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.classe.destroy', $classe->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-light text-danger border-danger" title="Supprimer" onclick="return confirm('Confirmer la suppression de cette classe ?');">
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
                    {{ $allClasses->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('classeSearch').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelector("#classeTableBody").rows;
            for (let i = 0; i < rows.length; i++) {
                let text = rows[i].textContent.toUpperCase();
                if (text.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    </script>
    @endpush
@endsection