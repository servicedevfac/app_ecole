@extends('layouts.app')
@section('title', 'Créer un Utilisateur')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Nouvel Utilisateur</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.user.index') }}">Utilisateurs</a></li>
            <li>Créer</li>
        </ul>
    </div>

    <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden;">
        <div class="card-header bg-white pt-4 pb-0 px-4 border-0">
            <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 4px;">
                <i class="fas fa-user-plus mr-2" style="color: #667eea;"></i> Créer un nouvel utilisateur
            </h4>
            <p style="color: #a0aec0; font-size: 14px; margin: 0;">Remplissez les informations ci-dessous pour créer un compte utilisateur.</p>
        </div>
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger" style="border-radius: 12px; border: none; background: #fff5f5; border-left: 4px solid #fc8181; padding: 15px 20px;">
                    <strong><i class="fas fa-exclamation-circle mr-2"></i>Erreurs de validation :</strong>
                    <ul class="mb-0 mt-2 pl-3">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 14px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.user.store') }}" method="POST" class="new-added-form">
                @csrf

                <!-- Section : Identité -->
                <div class="mb-4 pb-3" style="border-bottom: 1px solid #edf2f7;">
                    <h6 style="text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; font-weight: 700; color: #718096; margin-bottom: 20px;">
                        <i class="fas fa-id-card mr-2"></i> Identité
                    </h6>
                    <div class="row gutters-20">
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label style="font-weight: 600; color: #4a5568; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control" placeholder="Ex: Jean Dupont" required
                                style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label style="font-weight: 600; color: #4a5568; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Adresse Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control" placeholder="utilisateur@ecole.com" required
                                style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 15px;">
                        </div>
                    </div>
                </div>

                <!-- Section : Sécurité -->
                <div class="mb-4 pb-3" style="border-bottom: 1px solid #edf2f7;">
                    <h6 style="text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; font-weight: 700; color: #718096; margin-bottom: 20px;">
                        <i class="fas fa-lock mr-2"></i> Sécurité
                    </h6>
                    <div class="row gutters-20">
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label style="font-weight: 600; color: #4a5568; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Mot de passe <span class="text-danger">*</span></label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password"
                                    class="form-control" placeholder="Min. 8 caractères" required
                                    style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 45px 12px 15px;">
                                <button type="button" onclick="togglePassword('password', 'eye1')" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:#a0aec0; cursor:pointer;">
                                    <i class="fas fa-eye" id="eye1"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label style="font-weight: 600; color: #4a5568; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <div style="position: relative;">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Répéter le mot de passe" required
                                    style="border-radius: 10px; border: 1px solid #edf2f7; padding: 12px 45px 12px 15px;">
                                <button type="button" onclick="togglePassword('password_confirmation', 'eye2')" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:#a0aec0; cursor:pointer;">
                                    <i class="fas fa-eye" id="eye2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section : Rôle & École -->
                <div class="mb-4">
                    <h6 style="text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; font-weight: 700; color: #718096; margin-bottom: 20px;">
                        <i class="fas fa-shield-alt mr-2"></i> Rôle & Affectation
                    </h6>
                    <div class="row gutters-20">
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label style="font-weight: 600; color: #4a5568; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Rôle <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" class="form-control" required onchange="toggleEcoleField()"
                                style="border-radius: 10px; border: 1px solid #edf2f7; padding: 10px 15px;">
                                <option value="">— Choisir un rôle —</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" data-name="{{ $role->name }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        @if($role->name == 'admin')
                                            Administrateur
                                        @elseif($role->name == 'enseignant')
                                            Enseignant
                                        @elseif($role->name == 'parent')
                                            Parent
                                        @elseif($role->name == 'student')
                                            Élève
                                        @else
                                            {{ $role->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-12 form-group" id="ecole_field">
                            <label style="font-weight: 600; color: #4a5568; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Établissement <span class="text-danger" id="ecole_required_star">*</span>
                            </label>
                            <select name="ecole_id" id="ecole_id" class="form-control select2"
                                style="border-radius: 10px; border: 1px solid #edf2f7; padding: 10px 15px;">
                                <option value="">— Choisir un établissement —</option>
                                @foreach($ecoles as $ecole)
                                    <option value="{{ $ecole->id }}" {{ old('ecole_id') == $ecole->id ? 'selected' : '' }}>
                                        {{ $ecole->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                <i class="fas fa-info-circle mr-1"></i> Obligatoire pour tous les rôles sauf Super Admin.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-end pt-3" style="gap: 12px; border-top: 1px solid #edf2f7;">
                    <a href="{{ route('admin.user.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow" style="border-radius: 12px; font-weight: 600;">
                        <i class="fas fa-arrow-left mr-1"></i> Annuler
                    </a>
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="border-radius: 12px; font-weight: 700; box-shadow: 0 5px 15px rgba(255,174,0,0.3);">
                        <i class="fas fa-user-check mr-1"></i> Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15) !important;
        }
    </style>

    @push('scripts')
    <script>
        function toggleEcoleField() {
            const roleSelect = document.getElementById('role_id');
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const roleName = selectedOption.getAttribute('data-name');
            const ecoleField = document.getElementById('ecole_field');
            const ecoleSelect = document.getElementById('ecole_id');
            const star = document.getElementById('ecole_required_star');

            if (roleName === 'Super Admin') {
                ecoleField.style.opacity = '0.4';
                ecoleField.style.pointerEvents = 'none';
                ecoleSelect.required = false;
                ecoleSelect.value = '';
                if (star) star.style.display = 'none';
            } else {
                ecoleField.style.opacity = '1';
                ecoleField.style.pointerEvents = 'auto';
                ecoleSelect.required = true;
                if (star) star.style.display = 'inline';
            }
        }

        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleEcoleField();

            // Initialize Select2 if available
            if (typeof $.fn.select2 !== 'undefined') {
                $('#ecole_id').select2({ placeholder: '— Choisir un établissement —', allowClear: true });
            }
        });
    </script>
    @endpush

@endsection
