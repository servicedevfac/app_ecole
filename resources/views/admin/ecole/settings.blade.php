@extends('layouts.app')
@section('title', 'Paramètres de l\'Établissement')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Paramètres de l'Établissement</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Paramètres</li>
        </ul>
    </div>

    <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden;">
        <div class="card-header bg-white pt-4 pb-0 px-4 border-0">
            <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 0;">Mise à jour du profil de l'école</h4>
            <p style="color: #a0aec0; font-size: 14px;">Identifiant: <code style="padding: 2px 8px; background: #edf2f7; border-radius: 4px; color: #4a5568;">{{ $ecole->slug }}</code></p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.ecole.update_settings', $ecole->slug) }}" method="POST" enctype="multipart/form-data" class="new-added-form">
                @csrf
                @method('PUT')
                <div class="row gutters-20">
                    <!-- School Name (Read Only) -->
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Nom de l'école (Fixe)</label>
                        <input type="text" value="{{ $ecole->nom }}" class="form-control" disabled style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px; background-color: #f7fafc;">
                        <small class="text-muted">Contactez le Super Admin pour modifier le nom.</small>
                    </div>

                    <!-- Email -->
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Email de contact <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $ecole->email) }}" class="form-control" placeholder="contact@ecole.com" required style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>

                    <!-- Phone -->
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="telephone" value="{{ old('telephone', $ecole->telephone) }}" class="form-control" placeholder="Ex: +221 33 000 00 00" required style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                    </div>

                    <!-- Address -->
                    <div class="col-12 form-group">
                        <label style="font-weight: 600; color: #4a5568;">Adresse physique <span class="text-danger">*</span></label>
                        <textarea name="adresse" class="form-control" rows="3" placeholder="Adresse complète de l'établissement" required style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">{{ old('adresse', $ecole->adresse) }}</textarea>
                    </div>

                    <!-- Logo Upload -->
                    <div class="col-12 form-group mg-t-10">
                        <label style="font-weight: 600; color: #4a5568;">Logo de l'établissement</label>
                        <div class="d-flex align-items-center flex-wrap" style="gap: 30px;">
                            <div id="logo-preview-container" style="width: 150px; height: 150px; border: 2px dashed #cbd5e0; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: #f7fafc; overflow: hidden; box-shadow: inset 0 3px 6px rgba(0,0,0,0.03);">
                                @if($ecole->logo)
                                    <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo actuel" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-camera text-muted" style="font-size: 32px;"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h5 style="font-weight: 700; color: #2d3748; margin-bottom: 10px;">Changer l'image du logo</h5>
                                <p style="color: #718096; font-size: 14px; margin-bottom: 20px;">Utilisez une image carrée (PNG ou JPG) pour un meilleur rendu sur les bulletins et reçus.</p>
                                <input type="file" name="logo" id="logo-input" class="form-control-file d-none" accept="image/*">
                                <button type="button" onclick="document.getElementById('logo-input').click()" class="btn-fill-lg bg-light-accent text-dark-blue btn-hover-bluedark" style="border-radius: 12px; font-weight: 600;">
                                    <i class="fas fa-upload mg-r-8"></i> Choisir une image
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mg-t-30 d-flex justify-content-end" style="gap: 15px; border-top: 1px solid #edf2f7; padding-top: 25px;">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 12px; font-weight: 700; box-shadow: 0 5px 15px rgba(255, 174, 0, 0.3);">
                            Enregistrer les paramètres <i class="fas fa-check mg-l-8"></i>
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
