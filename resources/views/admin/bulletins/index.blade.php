@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Bulletins</h3>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Accueil</a>
            </li>
            <li>Bulletins</li>
        </ul>
    </div>
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Sélectionnez une classe pour générer le bulletin</h3>
                </div>
            </div>

            <form class="mg-b-20" action="{{ route('admin.bulletins.index') }}" method="GET">
                <div class="row gutters-8">
                    <div class="col-lg-3 col-12 form-group">
                        <label>Année Scolaire</label>
                        <select name="annee_scolaire_id" class="select2" onchange="this.form.submit()">
                            @foreach($annees as $a)
                                <option value="{{ $a->id }}" {{ $annee->id == $a->id ? 'selected' : '' }}>
                                    {{ $a->annee }} {{ $a->status === 'archived' ? '(Archivée)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-12 form-group">
                        <label>Niveau</label>
                        <select name="niveau_id" class="select2" onchange="this.form.submit()">
                            <option value="">Tous les niveaux</option>
                            @foreach($niveaux as $n)
                                <option value="{{ $n->id }}" {{ request('niveau_id') == $n->id ? 'selected' : '' }}>
                                    {{ $n->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-12 form-group">
                        <label>Rechercher une classe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom de la classe..." class="form-control border-start-0 ps-0">
                        </div>
                    </div>
                    <div class="col-lg-2 col-12 form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow w-100">FILTRER</button>
                    </div>
                </div>
                
                <div class="row gutters-8 mt-2">
                    <div class="col-lg-3 col-12 form-group">
                        <label>Période (Optionnel)</label>
                        <select id="periodeSelector" class="select2">
                            <option value="">Année complète</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}" {{ (isset($selected_periode_id) && $selected_periode_id == $periode->id) ? 'selected' : '' }}>
                                    {{ $periode->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap table-hover">
                    <thead>
                        <tr class="bg-light">
                            <th>Classe</th>
                            <th>Niveau</th>
                            <th class="text-right">Action</th>
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
                                <td>{{ $classe->niveau ? $classe->niveau->nom : '-' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.bulletins.generate', $classe->id) }}"
                                        class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark generate-btn px-4">
                                        <i class="fas fa-file-alt"></i> Générer Bulletin
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-5">
                                    <img src="{{ asset('img/no-data.png') }}" alt="No Data" style="max-width: 150px; opacity: 0.5;">
                                    <p class="mt-3 text-muted">Aucune classe trouvée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selector = document.getElementById('periodeSelector');
            const anneeSelector = document.querySelector('select[name="annee_scolaire_id"]');
            // Event delegation to handle clicks on generate buttons
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.generate-btn');
                if (btn) {
                    const periodId = selector.value;
                    const anneeId = anneeSelector ? anneeSelector.value : null;
                    let url = new URL(btn.href);
                    
                    if (periodId) {
                        url.searchParams.set('periode_id', periodId);
                    } else {
                        url.searchParams.delete('periode_id');
                    }

                    if (anneeId) {
                        url.searchParams.set('annee_scolaire_id', anneeId);
                    }

                    btn.href = url.toString();
                }
            });
        });
    </script>
@endsection