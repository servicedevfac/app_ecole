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

        <form class="new-added-form" method="POST" action="{{ route('admin.inscription.store') }}">
            @csrf
            <div class="row">

                <!-- Année scolaire -->
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Année scolaire *</label>
                    <select name="annee_scolaire_id" class="select2" required>
                        <option value="" disabled selected>Choisissez l'année</option>
                        @foreach($annees as $annee)
                            <option value="{{$annee->id}}" {{ old('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                {{$annee->annee}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Étudiant -->
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                    <label>Nom de l'élève *</label>
                    <select name="student_id" class="select2" required>
                        <option value="" disabled selected>Choisissez un étudiant</option>  
                        @foreach($etudiants as $etudiant)
                            <option value="{{$etudiant->id}}" {{ old('student_id') == $etudiant->id ? 'selected' : '' }}>
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
                            <option value="{{$cycle->id}}" {{ old('cycle_id') == $cycle->id ? 'selected' : '' }}>
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
                            <option value="{{$niveau->id}}" data-cycle="{{$niveau->cycle_id}}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
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
                            <option value="{{$classe->id}}" data-niveau="{{$classe->niveau_id}}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{$classe->nom}}
                            </option>
                        @endforeach  
                    </select>
                </div>

                <!-- Boutons -->
                <div class="col-12 form-group mg-t-8">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Inscrire</button>
                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(function() {
    var $cycle  = $('#cycleSelect');
    var $niveau = $('#niveauSelect');
    var $classe = $('#classeSelect');

    // Conserver les options originales pour reconstruire proprement (compat. Select2)
    var $niveauTemplate = $niveau.find('option').clone();
    var $classeTemplate = $classe.find('option').clone();

    function rebuildNiveaux(cycleId, selectedNiveau) {
        var $opts = $niveauTemplate.clone();
        $niveau.empty();
        $opts.each(function() {
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
        $opts.each(function() {
            var val = $(this).val();
            if (val === '') { $classe.append(this); return; }
            if ($(this).data('niveau') == niveauId) { $classe.append(this); }
        });
        if (selectedClasse) { $classe.val(selectedClasse); }
        $classe.trigger('change.select2');
    }

    $cycle.on('change', function() {
        var cycleId = $(this).val();
        rebuildNiveaux(cycleId, null);
        rebuildClasses(null, null);
    });

    $niveau.on('change', function() {
        var niveauId = $(this).val();
        rebuildClasses(niveauId, null);
    });

    // Initialisation avec valeurs déjà sélectionnées (old())
    var initialCycle  = $cycle.val();
    var initialNiveau = $niveau.val();
    var initialClasse = $classe.val();

    if (initialCycle) {
        rebuildNiveaux(initialCycle, initialNiveau);
    }
    if (initialNiveau) {
        rebuildClasses(initialNiveau, initialClasse);
    }
});
</script>
@endpush

@endsection
