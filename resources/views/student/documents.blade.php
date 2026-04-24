@extends('layouts.app')

@section('title', 'Mes Documents')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Mes Documents Administratifs</h3>
        <ul>
            <li>
                <a href="{{ route('student.dashboard') }}">Accueil</a>
            </li>
            <li>Mes Documents</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Liste de mes documents</h3>
                    <p class="text-muted">Retrouvez ici vos documents officiels (bulletins, certificats, etc.) mis à disposition par l'administration.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Type / Catégorie</th>
                            <th>Date d'ajout</th>
                            <th>Format</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        @if(in_array(strtolower($doc->file_type), ['jpg', 'jpeg', 'png']))
                                            <i class="fas fa-file-image text-warning fa-2x"></i>
                                        @elseif(strtolower($doc->file_type) == 'pdf')
                                            <i class="fas fa-file-pdf text-danger fa-2x"></i>
                                        @else
                                            <i class="fas fa-file-alt text-primary fa-2x"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-dark">{{ $doc->titre }}</div>
                                        <small class="text-muted">{{ number_format($doc->file_size / 1024, 2) }} KB</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-light border">{{ $doc->type ?? 'Non spécifié' }}</span>
                            </td>
                            <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-info">{{ strtoupper($doc->file_type) }}</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('student.documents.download', $doc->id) }}" 
                                   class="btn-fill-smd radius-4 text-light bg-blue-dark btn-hover-yellow">
                                    <i class="fas fa-download mr-1"></i> Télécharger
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-folder-open text-muted fa-3x" style="opacity: 0.3;"></i>
                                </div>
                                <h4 class="text-muted">Aucun document n'a encore été mis en ligne pour vous.</h4>
                                <p class="text-muted">Veuillez contacter l'administration pour plus d'informations.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
