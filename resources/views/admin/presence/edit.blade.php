@extends('layouts.app')
@section('title', "Modifier la présence")
@section('content')

    <div class="breadcrumbs-area">
        <h3>Modifier la présence</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.presences.index') }}">Présences</a></li>
            <li>Modification</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Élève : {{ $presence->student->nom }} {{ $presence->student->prenom }}</h3>
                    <p class="text-muted">Séance de {{ $presence->matiere->nom }} le {{ \Carbon\Carbon::parse($presence->date)->format('d/m/Y') }}</p>
                </div>
            </div>

            <form action="{{ route('admin.presences.update', $presence->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Statut *</label>
                    <select name="statut" class="form-control" required>
                        <option value="present" {{ $presence->statut == 'present' ? 'selected' : '' }}>Présent</option>
                        <option value="absent" {{ $presence->statut == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="retard" {{ $presence->statut == 'retard' ? 'selected' : '' }}>En retard</option>
                        <option value="justifié" {{ $presence->statut == 'justifié' ? 'selected' : '' }}>Justifié</option>
                    </select>
                </div>

                <div class="mg-t-20">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.presences.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow ml-2">
                        Retour
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
