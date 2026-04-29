@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Configuration Scolaire</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Liste des Matières</li>
        </ul>
    </div>

    <div class="row">
        <!-- Stats Cards -->
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-yellow shadow-sm">
                            <i class="flaticon-open-book text-orange"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Matières</div>
                            <div class="item-number"><span class="text-dark font-weight-bold">{{ count($matieres) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon bg-light-magenta shadow-sm">
                            <i class="flaticon-classmates text-magenta"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Assignations</div>
                            <div class="item-number"><span>{{ $matieres->sum(fn($m) => $m->classes->count()) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Matiere Table Area Start Here -->
    <div class="card height-auto shadow-sm">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Toutes les Matières</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.matiere.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark shadow-sm">
                        <i class="fas fa-plus mg-r-8"></i> Nouvelle Matière
                    </a>
                </div>
            </div>

            <!-- Unified Search -->
            <div class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-lg-10 col-12 form-group">
                        <input type="text" id="matiereSearch" placeholder="Rechercher une matière (Nom, Code...)" class="form-control" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
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
                            <th>Nom de la Matière</th>
                            <th>Code</th>
                            <th>Classes Assignées</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="matiereTableBody">
                        @foreach($matieres as $matiere)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light-magenta rounded mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-book text-magenta"></i>
                                    </div>
                                    <span class="font-weight-bold">{{ $matiere->nom }}</span>
                                </div>
                            </td>
                            <td>
                                <code class="p-2 px-3 bg-light rounded text-dark border">{{ $matiere->code }}</code>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-light p-2 px-3 border text-dark">
                                    <i class="fas fa-school text-muted mg-r-5"></i> {{ $matiere->classes->count() }} Classes
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                    <a href="{{ route('admin.matiere.edit', $matiere->id) }}" class="btn btn-sm bg-light text-success border-success" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.matiere.destroy', $matiere->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-light text-danger border-danger" title="Supprimer" onclick="return confirm('Confirmer la suppression de cette matière ?');">
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
                    {{ $matieres->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('matiereSearch').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelector("#matiereTableBody").rows;
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