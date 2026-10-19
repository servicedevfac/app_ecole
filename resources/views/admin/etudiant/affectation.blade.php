@extends('layouts.app')
@section('title', 'Inscription d\'un étudiant')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Étudiants</h3>
        <ul>
            <li><a href="{{route('dashboard')}}">Tableau de bord</a></li>
            <li>Inscription</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Formulaire d'inscription</h3>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="new-added-form" method="POST" action="{{ isset($inscription) ? route('admin.inscription.update', $inscription->id) : route('admin.inscription.store') }}">
                @csrf
                @if(isset($inscription))
                    @method('PUT')
                @endif
                
                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Année scolaire *</label>
                        <select name="annee_scolaire_id" class="select2" required id="anneeSelect">
                            <option value="" disabled selected>Choisissez l'année</option>
                            @foreach($annees as $annee)
                                <option value="{{$annee->id}}" {{ old('annee_scolaire_id', isset($inscription) ? $inscription->annee_scolaire_id : null) == $annee->id ? 'selected' : '' }}>
                                    {{$annee->annee}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Étudiant -->
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Nom de l'élève *</label>
                        <select name="student_id" class="select2" required>
                            <option value="" disabled {{ !isset($selected_student_id) && !old('student_id') && !isset($inscription) ? 'selected' : '' }}>Choisissez un étudiant</option>
                            @foreach($etudiants as $etudiant)
                                <option value="{{$etudiant->id}}" data-est_affecte="{{$etudiant->est_affecte ? 1 : 0}}" {{ (old('student_id', isset($inscription) ? $inscription->student_id : ($selected_student_id ?? null))) == $etudiant->id ? 'selected' : '' }}>
                                    {{$etudiant->nom}} {{$etudiant->prenom}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cycle -->
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Cycle *</label>
                        <select name="cycle_id" class="select2" required id="cycleSelect">
                            <option value="" disabled selected>Choisissez un cycle</option>
                            @foreach($cycles as $cycle)
                                <option value="{{$cycle->id}}" {{ old('cycle_id', isset($inscription) ? $inscription->cycle_id : null) == $cycle->id ? 'selected' : '' }}>
                                    {{$cycle->nom}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Niveau -->
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Niveau *</label>
                        <select name="niveau_id" class="select2" required id="niveauSelect">
                            <option value="" disabled selected>Choisissez un niveau</option>
                            @foreach($niveaux as $niveau)
                                <option value="{{$niveau->id}}" data-cycle="{{$niveau->cycle_id}}" {{ old('niveau_id', isset($inscription) ? $inscription->niveau_id : null) == $niveau->id ? 'selected' : '' }}>
                                    {{$niveau->nom}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Classe -->
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Classe *</label>
                        <select name="classe_id" class="select2" required id="classeSelect">
                            <option value="" disabled selected>Choisissez une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{$classe->id}}" data-niveau="{{$classe->niveau_id}}" {{ old('classe_id', isset($inscription) ? $inscription->classe_id : null) == $classe->id ? 'selected' : '' }}>
                                    {{$classe->nom}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-group">
                        <h4>Frais de scolarité</h4>
                        <p id="frais-message">Sélectionnez une année et un niveau pour voir les frais.</p>
                        <div class="table-responsive">
                            <table class="table" id="frais-table" style="display:none">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody id="frais-body"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th id="frais-total"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                            {{ isset($inscription) ? 'Mettre à jour' : 'Inscrire' }}
                        </button>
                        <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                var fraisData = @json($fraisData);

                var $cycle = $('#cycleSelect');
                var $niveau = $('#niveauSelect');
                var $classe = $('#classeSelect');
                var $annee = $('#anneeSelect');

                var $niveauTemplate = $niveau.find('option').clone();
                var $classeTemplate = $classe.find('option').clone();

                var $fraisTable = $('#frais-table');
                var $fraisBody = $('#frais-body');
                var $fraisTotal = $('#frais-total');
                var $fraisMessage = $('#frais-message');

                function rebuildNiveaux(cycleId, selectedNiveau) {
                    var $opts = $niveauTemplate.clone();
                    $niveau.empty();
                    $opts.each(function () {
                        var val = $(this).val();
                        if (val === '') { $niveau.append(this); return; }
                        if ($(this).data('cycle') == cycleId) { $niveau.append(this); }
                    });
                    if (selectedNiveau) { $niveau.val(selectedNiveau); }
                    $niveau.trigger('change.select2');
                }

                function rebuildClasses(niveauId, selectedClasse) {
                    var $opts = $classeTemplate.clone();
                    $classe.empty();
                    $opts.each(function () {
                        var val = $(this).val();
                        if (val === '') { $classe.append(this); return; }
                        if ($(this).data('niveau') == niveauId) { $classe.append(this); }
                    });
                    if (selectedClasse) { $classe.val(selectedClasse); }
                    $classe.trigger('change.select2');
                }

                function updateFrais() {
                    var anneeId = $annee.val();
                    var niveauId = $niveau.val();

                    if (!anneeId || !niveauId) {
                        $fraisTable.hide();
                        $fraisBody.empty();
                        $fraisTotal.text('');
                        $fraisMessage.text('Sélectionnez une année et un niveau pour voir les frais.');
                        return;
                    }

                    var filtered = fraisData.filter(function (item) {
                        return item.annee_scolaire_id == anneeId && item.niveau_id == niveauId;
                    });

                    if (!filtered.length) {
                        $fraisTable.hide();
                        $fraisBody.empty();
                        $fraisTotal.text('');
                        $fraisMessage.text('Aucun frais configuré pour ce niveau et cette année.');
                        return;
                    }

                    $fraisBody.empty();
                    var total = 0;
                    var item = filtered[0];

                    var inscription = parseFloat(item.frais_inscription) || 0;
                    var scolarite = parseFloat(item.frais_Scolarité) || 0;

                    // Vérifier si l'étudiant est affecté via l'attribut data
                    var $selectedStudent = $('select[name="student_id"] option:selected');
                    var isAffecte = $selectedStudent.data('est_affecte') == 1;

                    if (isAffecte) {
                        scolarite = 0;
                    }

                    if (inscription > 0) {
                        $fraisBody.append('<tr><td>Frais d\'inscription</td><td>' + inscription.toLocaleString('fr-FR') + ' FCFA</td></tr>');
                        total += inscription;
                    }
                    if (scolarite > 0) {
                        $fraisBody.append('<tr><td>Frais de scolarité</td><td>' + scolarite.toLocaleString('fr-FR') + ' FCFA</td></tr>');
                        total += scolarite;
                    }

                    $fraisTotal.text(total.toLocaleString('fr-FR') + ' FCFA');
                    $fraisTable.show();
                    $fraisMessage.text('');
                }

                $cycle.on('change', function () {
                    var cycleId = $(this).val();
                    rebuildNiveaux(cycleId, null);
                    rebuildClasses(null, null);
                    updateFrais();
                });

                $niveau.on('change', function () {
                    var niveauId = $(this).val();
                    rebuildClasses(niveauId, null);
                    updateFrais();
                });

                $annee.on('change', function () {
                    updateFrais();
                });

                $('select[name="student_id"]').on('change', function () {
                    updateFrais();
                });

                var initialCycle = $cycle.val();
                var initialNiveau = $niveau.val();
                var initialClasse = $classe.val();

                if (initialCycle) {
                    rebuildNiveaux(initialCycle, initialNiveau);
                }
                if (initialNiveau) {
                    rebuildClasses(initialNiveau, initialClasse);
                }

                updateFrais();
            });
        </script>
    @endpush

@endsection
