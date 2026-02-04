@extends('layouts.app')

@section('content')
<div class="breadcrumbs-area">
    <h3>Saisie des notes</h3>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">Accueil</a>
        </li>
        <li>
            <a href="{{ route('admin.evaluations.index') }}">Évaluations</a>
        </li>
        <li>Saisie</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>{{ $evaluation->libelle }}</h3>
                <p class="text-muted">
                    Classe : <strong>{{ $evaluation->classe->nom }}</strong> | 
                    Matière : <strong>{{ $evaluation->matiere->nom }}</strong> | 
                    Date : <strong>{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}</strong> | 
                    Note Max : <strong>{{ $evaluation->note_max }}</strong>
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.evaluations.notes.store', $evaluation->id) }}" method="POST">
            @csrf
            
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>Note (/{{ $evaluation->note_max }})</th>
                            <th>Appréciation (Optionnel)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                // Chercher la note existante pour cet étudiant
                                $existingNote = $student->notes->first();
                                $valeurNote = old('notes.'.$student->id, $existingNote ? $existingNote->note : '');
                                $valeurAppreciation = old('appreciations.'.$student->id, $existingNote ? $existingNote->appreciation : '');
                            @endphp
                            <tr>
                                <td>{{ $student->matricule }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($student->photo)
                                            <img src="{{ asset('storage/'.$student->photo) }}" alt="student" class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle mr-2 bg-light d-flex align-items-center justify-content-center text-secondary" style="width: 30px; height: 30px; font-weight: bold;">
                                                {{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}
                                            </div>
                                        @endif
                                        {{ $student->nom }} {{ $student->prenom }}
                                    </div>
                                </td>
                                <td>
                                    <input type="number" 
                                           name="notes[{{ $student->id }}]" 
                                           class="form-control" 
                                           min="0" 
                                           max="{{ $evaluation->note_max }}" 
                                           step="0.01" 
                                           value="{{ $valeurNote }}"
                                           placeholder="Note">
                                </td>
                                <td>
                                    <input type="text" 
                                           name="appreciations[{{ $student->id }}]" 
                                           class="form-control" 
                                           value="{{ $valeurAppreciation }}"
                                           placeholder="Appréciation">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('admin.evaluations.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow mr-3">Retour</a>
                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Enregistrer les notes</button>
            </div>
        </form>
    </div>
</div>
@endsection
