@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Notes de l'élève</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Notes: {{ $selectedStudent->nom }} {{ $selectedStudent->prenom }}</li>
        </ul>
    </div>

    @foreach($notes as $matiere => $matiereNotes)
    <div class="card height-auto mg-b-20">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>{{ $matiere }}</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Évaluation</th>
                            <th>Période</th>
                            <th>Année</th>
                            <th>Note</th>
                            <th>Remarque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matiereNotes as $note)
                            <tr>
                                <td>{{ $note->evaluation->titre }}</td>
                                <td>{{ $note->evaluation->periode->nom ?? '-' }}</td>
                                <td>{{ $note->evaluation->anneeScolaire->annee ?? '-' }}</td>
                                <td class="font-weight-bold {{ $note->note < 10 ? 'text-red' : 'text-success' }}">
                                    {{ $note->note }} / 20
                                </td>
                                <td>
                                    <span class="small text-muted">{{ $note->pivot->commentaire ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

    @if($notes->isEmpty())
        <div class="alert alert-info text-center p-5">
            <i class="fas fa-info-circle fa-3x mb-3"></i>
            <p>Aucune note n'a été enregistrée pour cet enfant pour le moment.</p>
        </div>
    @endif
@endsection
