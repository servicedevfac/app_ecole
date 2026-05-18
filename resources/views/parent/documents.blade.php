@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Mes Documents</h3>
        <ul>
            <li>
                <a href="{{ route('parent.dashboard') }}">Accueil</a>
            </li>
            <li>Documents: {{ $selectedStudent->nom }} {{ $selectedStudent->prenom }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-20">
                <div class="item-title">
                    <h3>Documents partagés</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Nom du document</th>
                            <th>Type</th>
                            <th>Date d'ajout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <i class="fas fa-file-pdf text-red mr-2"></i>
                                    {{ $document->title }}
                                </td>
                                <td>{{ $document->type ?? 'PDF' }}</td>
                                <td>{{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('parent.documents.download', $document->id) }}" class="btn-fill-s btn-gradient-yellow">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Aucun document disponible</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
