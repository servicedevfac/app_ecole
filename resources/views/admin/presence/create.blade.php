@extends('layouts.app')
@section('title', "Faire l'appel")
@section('content')

    <div class="breadcrumbs-area">
        <h3>Faire l'appel</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Saisie des présences</li>
        </ul>
    </div>

    <div class="card mg-b-20">
        <div class="card-body">
            <form id="presence-filter-form" method="GET" action="{{ route('admin.presences.create') }}" class="row gutters-8 align-items-end">
                <div class="col-xl-4 col-lg-4 col-12 form-group">
                    <label>Date *</label>
                    <input type="date" name="date" id="date-input" value="{{ $date }}" class="form-control" required>
                </div>
                <div class="col-xl-4 col-lg-4 col-12 form-group">
                    <label>Classe *</label>
                    <select name="classe_id" id="classe-select" class="form-control select2" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classe_id == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-12 form-group">
                    <label>Séance / Cours *</label>
                    <select name="emploi_du_temps_id" id="lesson-select" class="form-control select2" required>
                        <option value="">-- Choisir une séance --</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ $emploi_du_temps_id == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->matiere->nom }} ({{ $lesson->horaire->heure_debut }} - {{ $lesson->horaire->heure_fin }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                        <i class="fas fa-users mr-2"></i> Afficher la liste
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($emploi_du_temps_id && count($students) > 0)
    <div class="card">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Feuille d'appel : {{ $classes->find($classe_id)->nom }}</h3>
                    <p class="text-muted">Séance du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                </div>
            </div>

            <form action="{{ route('admin.presences.store') }}" method="POST">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="classe_id" value="{{ $classe_id }}">
                <input type="hidden" name="emploi_du_temps_id" value="{{ $emploi_du_temps_id }}">

                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Élève</th>
                                <th class="text-center">Présent</th>
                                <th class="text-center">Absent</th>
                                <th class="text-center">Retard</th>
                                <th class="text-center">Justifié</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $student->nom }} {{ $student->prenom }}</div>
                                    <small class="text-muted">{{ $student->matricule }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="radio radio-success">
                                        <input type="radio" name="presences[{{ $student->id }}]" value="present" id="p-{{ $student->id }}" checked>
                                        <label for="p-{{ $student->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="radio radio-danger">
                                        <input type="radio" name="presences[{{ $student->id }}]" value="absent" id="a-{{ $student->id }}">
                                        <label for="a-{{ $student->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="radio radio-warning">
                                        <input type="radio" name="presences[{{ $student->id }}]" value="retard" id="r-{{ $student->id }}">
                                        <label for="r-{{ $student->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="radio radio-info">
                                        <input type="radio" name="presences[{{ $student->id }}]" value="justifié" id="j-{{ $student->id }}">
                                        <label for="j-{{ $student->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mg-t-30">
                    <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                        <i class="fas fa-save mr-2"></i> Enregistrer les présences
                    </button>
                    <a href="{{ route('admin.presences.index') }}" class="btn-fill-lg bg-light text-dark shadow-sm ml-2">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
    @elseif($emploi_du_temps_id)
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-2"></i> Aucun élève trouvé pour cette classe.
    </div>
    @endif

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#classe-select, #date-input').on('change', function() {
            var classe_id = $('#classe-select').val();
            var date = $('#date-input').val();
            
            if(classe_id && date) {
                console.log("Fetching lessons for classe:", classe_id, "on date:", date);
                var baseUrl = "{{ route('admin.presences.get_lessons', '') }}";
                if (!baseUrl.endsWith('/')) baseUrl += '/';
                
                $.ajax({
                    url: baseUrl + classe_id,
                    data: { date: date },
                    success: function(data) {
                        console.log("Lessons received:", data);
                        var select = $('#lesson-select');
                        select.empty().append('<option value="">-- Choisir une séance --</option>');
                        $.each(data, function(index, lesson) {
                            select.append('<option value="'+ lesson.id +'">'+ lesson.text +'</option>');
                        });
                        // Trigger change for Select2 if active
                        select.trigger('change');
                    },
                    error: function(xhr) {
                        console.error("Error fetching lessons:", xhr);
                    }
                });
            }
        });
    });
</script>
<style>
    /* Styling for radio buttons to make them look like circle options */
    .radio label {
        cursor: pointer;
        padding-left: 0;
        margin-bottom: 0;
    }
    .radio input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .radio-success input[type="radio"] { accent-color: #28a745; }
    .radio-danger input[type="radio"] { accent-color: #dc3545; }
    .radio-warning input[type="radio"] { accent-color: #ffc107; }
    .radio-info input[type="radio"] { accent-color: #17a2b8; }
</style>
@endpush
