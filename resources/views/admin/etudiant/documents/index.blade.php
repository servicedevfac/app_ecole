@extends('layouts.app')
@section('title', 'Documents de l\'élève')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Documents - {{ $student->nom }} {{ $student->prenom }}</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li><a href="{{ route('admin.etudiant.index') }}">Élèves</a></li>
            <li><a href="{{ route('admin.etudiant.show', $student->id) }}">Profil</a></li>
            <li>Documents</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-4-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Ajouter un document</h3>
                        </div>
                    </div>
                    <form class="new-added-form" action="{{ route('admin.etudiant.documents.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Titre du document *</label>
                                <input type="text" name="titre" placeholder="Ex: Acte de naissance" class="form-control"
                                    required>
                            </div>
                            <div class="col-12 form-group">
                                <label>Type / Catégorie</label>
                                <input type="text" name="type" placeholder="Ex: Officiel" class="form-control">
                            </div>
                            <div class="col-12 form-group">
                                <label>Fichier (PDF, Image, Doc) *</label>
                                <input type="file" name="document" class="form-control" required>
                                <small class="text-muted">Max 5MB</small>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit"
                                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Uploader</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Liste des documents</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Type</th>
                                    <th>Format</th>
                                    <th>Taille</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td>{{ $doc->titre }}</td>
                                        <td>{{ $doc->type ?? '-' }}</td>
                                        <td><span class="badge badge-pill badge-info">{{ strtoupper($doc->file_type) }}</span>
                                        </td>
                                        <td>{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.etudiant.documents.download', $doc->id) }}">
                                                        <i class="fas fa-download text-primary"></i> Télécharger
                                                    </a>
                                                    <form action="{{ route('admin.etudiant.documents.destroy', $doc->id) }}"
                                                        method="POST" onsubmit="return confirm('Supprimer ce document ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-times text-danger"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucun document pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection