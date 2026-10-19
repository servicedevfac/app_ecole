@extends('layouts.app')
@section('title', 'Modifier l\'Établissement')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Modifier l'Établissement</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.ecole.index') }}">Écoles</a></li>
            <li>Modifier: {{ $ecole->nom }}</li>
        </ul>
    </div>

    <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden;">
        <div class="card-header bg-white pt-4 pb-0 px-4 border-0">
            <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 0;">Mise à jour des informations</h4>
            <p style="color: #a0aec0; font-size: 14px;">Identifiant de l'école: <code style="padding: 2px 8px; background: #edf2f7; border-radius: 4px; color: #4a5568;">{{ $ecole->slug }}</code></p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.ecole.update', $ecole->slug) }}" method="POST" enctype="multipart/form-data" class="new-added-form">
                @csrf
                @method('PUT')
                <div class="row gutters-20">
                    <!-- School Name -->
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Nom de l'école <span class="text-danger">*</span></label>
                        <input type="text" name="nom" value="{{ old('nom', $ecole->nom) }}" class="form-control" placeholder="Ex: École Primaire Sainte Marie" required style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>

                    <!-- Email -->
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Email de contact</label>
                        <input type="email" name="email" value="{{ old('email', $ecole->email) }}" class="form-control" placeholder="contact@ecole.com" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>

                    <!-- Phone -->
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $ecole->telephone) }}" class="form-control" placeholder="+221 ..." style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>

                    <!-- Students Limit -->
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Limite d'élèves</label>
                        <input type="number" name="limite_etudiants" value="{{ old('limite_etudiants', $ecole->limite_etudiants) }}" class="form-control" placeholder="Ex: 1000" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>

                    <!-- Status -->
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Statut du compte</label>
                        <select name="is_active" class="form-control" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 10px 15px;">
                            <option value="1" {{ old('is_active', $ecole->is_active) == '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ old('is_active', $ecole->is_active) == '0' ? 'selected' : '' }}>Suspendu</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Adresse complète</label>
                        <textarea name="adresse" class="form-control" rows="3" placeholder="Adresse physique de l'établissement" style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">{{ old('adresse', $ecole->adresse) }}</textarea>
                    </div>

                    <!-- Logo Upload -->
                    <div class="col-12 form-group mg-t-10">
                        <label style="font-weight: 600; color: #4a5568;">Logo de l'établissement</label>
                        <div class="d-flex align-items-center" style="gap: 30px;">
                            <div id="logo-preview-container" style="width: 120px; height: 120px; border: 2px dashed #cbd5e0; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: #f7fafc; overflow: hidden; box-shadow: inset 0 3px 6px rgba(0,0,0,0.03);">
                                @if($ecole->logo)
                                    <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo actuel" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-camera text-muted" style="font-size: 28px;"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Changer le logo</p>
                                <input type="file" name="logo" id="logo-input" class="form-control-file d-none">
                                <button type="button" onclick="document.getElementById('logo-input').click()" class="btn-fill-lg bg-light-accent text-dark-blue btn-hover-bluedark" style="border-radius: 10px; border: 1px solid #cbd5e0; font-weight: 600; padding: 10px 20px;">
                                    <i class="fas fa-image mg-r-8"></i> Sélectionner une nouvelle image
                                </button>
                                <p style="font-size: 11px; color: #a0aec0; margin-top: 10px;"><i class="fas fa-info-circle mg-r-5"></i> L'ancienne image sera remplacée après enregistrement.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mg-t-30 d-flex justify-content-end" style="gap: 15px; border-top: 1px solid #edf2f7; padding-top: 25px;">
                        <a href="{{ route('admin.ecole.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow" style="border-radius: 12px; font-weight: 600;">Annuler les changements</a>
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 12px; font-weight: 700; box-shadow: 0 5px 15px rgba(255, 174, 0, 0.3);">
                            Enregistrer les modifications <i class="fas fa-sync-alt mg-l-8"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('logo-input').onchange = function(evt) {
                const [file] = this.files;
                if (file) {
                    const preview = document.getElementById('logo-preview-container');
                    preview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    preview.appendChild(img);
                }
            }
        </script>
    @endpush

    <style>
        .form-control:focus {
            border-color: #ffae01 !important;
            box-shadow: 0 0 0 3px rgba(255, 174, 1, 0.1) !important;
        }
        label { margin-bottom: 8px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;}
    </style>

@endsection
