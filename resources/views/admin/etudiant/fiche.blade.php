<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DOSSIER SCOLAIRE - {{ $etudiant->nom }} {{ $etudiant->prenom }}</title>
    <style>
        @page { margin: 20px; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; color: #333; line-height: 1.2; }
        .header { border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; margin-bottom: 15px; }
        .school-info { width: 70%; float: left; }
        .school-name { font-size: 16px; font-weight: bold; color: #1e3a8a; text-transform: uppercase; }
        .fiche-title { background: #1e3a8a; color: white; padding: 5px; text-align: center; font-size: 14px; font-weight: bold; margin: 10px 0; clear: both; }
        
        .photo-box { width: 100px; height: 120px; border: 1px solid #ccc; float: right; text-align: center; margin-left: 20px; }
        .photo-box img { max-width: 100%; max-height: 100%; }
        
        .section { margin-bottom: 15px; clear: both; }
        .section-header { background: #f1f5f9; border-left: 4px solid #1e3a8a; padding: 4px 10px; font-weight: bold; font-size: 11px; margin-bottom: 8px; text-transform: uppercase; }
        
        .row { width: 100%; display: table; table-layout: fixed; border-spacing: 10px 0; }
        .col { display: table-cell; vertical-align: top; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        table.data-table td { padding: 4px 2px; border-bottom: 1px solid #f1f5f9; }
        .label { font-weight: bold; color: #64748b; width: 120px; }
        .value { color: #1e293b; font-weight: 500; }
        
        .medical-alert { background: #fef2f2; border: 1px solid #fee2e2; padding: 5px; color: #b91c1c; }
        .financial-summary { background: #f0fdf4; border: 1px solid #dcfce7; padding: 8px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; border-top: 1px solid #eee; padding-top: 5px; }
        .signature-block { margin-top: 30px; }
        .check-box { width: 10px; height: 10px; border: 1px solid #000; display: inline-block; margin-right: 5px; vertical-align: middle; }
    </style>
</head>
<body>
    @php
        $logoBase64 = '';
        if ($ecole && $ecole->logo && Storage::disk('public')->exists($ecole->logo)) {
            $logoPath = storage_path('app/public/' . $ecole->logo);
            $logoBase64 = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
        }
        $photoBase64 = '';
        if ($etudiant->photo && Storage::disk('public')->exists($etudiant->photo)) {
            $photoPath = storage_path('app/public/' . $etudiant->photo);
            $photoBase64 = 'data:image/' . pathinfo($photoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($photoPath));
        }
    @endphp

    <div class="header">
        <div class="school-info">
            <div class="school-name">{{ $ecole->nom ?? 'Établissement Scolaire' }}</div>
            <div style="font-size: 9px; margin-top: 4px;">
                {{ $ecole->adresse ?? 'Adresse non renseignée' }}<br>
                Tél: {{ $ecole->telephone ?? '-' }} | Email: {{ $ecole->email ?? '-' }}<br>
                Année Scolaire: <strong>{{ $inscription->anneeScolaire->annee ?? now()->year }}</strong>
            </div>
        </div>
        <div style="float: right; text-align: right; width: 25%;">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" style="max-height: 60px;">
            @endif
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="fiche-title">DOSSIER INDIVIDUEL DE L'ÉLÈVE</div>

    <!-- Section: Identification -->
    <div class="section">
        <div class="photo-box">
            @if($photoBase64)
                <img src="{{ $photoBase64 }}">
            @else
                <div style="padding-top: 45px; color: #ccc;">PHOTO</div>
            @endif
        </div>
        <div class="section-header">1. ÉTAT CIVIL ET IDENTIFICATION</div>
        <table class="data-table" style="width: calc(100% - 130px);">
            <tr>
                <td class="label">Matricule :</td>
                <td class="value" style="font-size: 12px; color: #1e3a8a;"><strong>{{ $etudiant->matricule }}</strong></td>
                <td class="label">Sexe :</td>
                <td class="value">{{ $etudiant->sexe == 'M' ? 'Masculin' : 'Féminin' }}</td>
            </tr>
            <tr>
                <td class="label">Nom :</td>
                <td class="value"><strong>{{ strtoupper($etudiant->nom) }}</strong></td>
                <td class="label">Nationalité :</td>
                <td class="value">{{ $etudiant->nationalite ?? 'Ivoirienne' }}</td>
            </tr>
            <tr>
                <td class="label">Prénom(s) :</td>
                <td class="value"><strong>{{ $etudiant->prenom }}</strong></td>
                <td class="label">CNI / Extrait :</td>
                <td class="value">{{ $etudiant->cni_extrait_numero ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Né(e) le :</td>
                <td class="value">{{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</td>
                <td class="label">À :</td>
                <td class="value">{{ $etudiant->lieu_naissance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Adresse :</td>
                <td class="value" colspan="3">{{ $etudiant->address ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Section: Scolarité -->
    <div class="section">
        <div class="section-header">2. INFORMATIONS SCOLAIRES</div>
        <div class="row">
            <div class="col">
                <table class="data-table">
                    <tr><td class="label">Classe actuelle :</td><td class="value">{{ $inscription->classe->nom ?? '-' }}</td></tr>
                    <tr><td class="label">Niveau :</td><td class="value">{{ $inscription->niveau->nom ?? '-' }}</td></tr>
                    <tr><td class="label">Filière / Série :</td><td class="value">{{ $etudiant->filiere_serie ?? 'Général' }}</td></tr>
                </table>
            </div>
            <div class="col">
                <table class="data-table">
                    <tr><td class="label">Statut :</td><td class="value">{{ str_replace('_', ' ', ucfirst($etudiant->statut_inscription)) ?? 'Nouvel élève' }}</td></tr>
                    <tr><td class="label">Affecté État :</td><td class="value">{{ $etudiant->est_affecte ? 'Oui' : 'Non' }}</td></tr>
                    <tr><td class="label">Prov. de :</td><td class="value">{{ $etudiant->etablissement_precedent ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Section: Famille -->
    <div class="section">
        <div class="section-header">3. CONTACTS DES PARENTS / TUTEURS</div>
        @foreach($etudiant->parents as $p)
        <table class="data-table" style="margin-bottom: 8px; border: 1px solid #f1f5f9; padding: 5px;">
            <tr>
                <td class="label">{{ ucfirst($p->pivot->relation ?? 'Parent') }} :</td>
                <td class="value"><strong>{{ strtoupper($p->nom) }} {{ $p->prenom }}</strong></td>
                <td class="label">Profession :</td>
                <td class="value">{{ $p->profession ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Téléphone :</td>
                <td class="value">{{ $p->telephone }}</td>
                <td class="label">Email :</td>
                <td class="value">{{ $p->email ?? '-' }}</td>
            </tr>
        </table>
        @endforeach
    </div>

    <!-- Section: Médical -->
    <div class="section">
        <div class="section-header">4. INFORMATIONS MÉDICALES ET URGENCE</div>
        <div class="row">
            <div class="col" style="width: 30%;">
                <div style="border: 2px solid #b91c1c; text-align: center; padding: 10px; border-radius: 5px;">
                    <span style="font-size: 8px; display: block; color: #b91c1c;">GROUPE SANGUIN</span>
                    <strong style="font-size: 18px; color: #b91c1c;">{{ $etudiant->groupe_sanguin ?? '??' }}</strong>
                </div>
            </div>
            <div class="col" style="width: 70%;">
                <table class="data-table">
                    <tr><td class="label">Contact Urgence :</td><td class="value">{{ $etudiant->contact_urgence ?? '-' }}</td></tr>
                    <tr><td class="label">Allergies :</td><td class="value">{{ $etudiant->allergies ?? 'Aucune signalée' }}</td></tr>
                    <tr><td class="label">Pathologies :</td><td class="value">{{ $etudiant->maladies ?? 'Aucune signalée' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Section: Checklist Documents -->
    <div class="section">
        <div class="section-header">6. PIÈCES FOURNIES AU DOSSIER</div>
        <div class="row">
            @php
                $docs_needed = ['Extrait de naissance', 'Certificat de scolarité', 'Photos d\'identité', 'Bulletins antérieurs', 'Certificat médical'];
                $provided_titles = $documents->pluck('titre')->toArray();
            @endphp
            @foreach(array_chunk($docs_needed, 3) as $chunk)
                <div class="col">
                    @foreach($chunk as $doc)
                        <div style="margin-bottom: 5px;">
                            <div class="check-box">@if(in_array($doc, $provided_titles)) X @endif</div>
                            {{ $doc }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!-- Observations -->
    <div class="section" style="border: 1px solid #eee; padding: 10px;">
        <span class="label" style="display: block; margin-bottom: 5px;">OBSERVATIONS :</span>
        <div style="min-height: 40px; font-style: italic; color: #444;">
            {{ $etudiant->observations ?? 'Aucune observation particulière.' }}
        </div>
    </div>

    <div class="row signature-block">
        <div class="col" style="text-align: center;">
            <div style="margin-bottom: 40px;">Visa du Parent / Tuteur</div>
            <div style="border-top: 1px dashed #333; width: 150px; margin: 0 auto;"></div>
        </div>
        <div class="col" style="text-align: center;">
            <div style="margin-bottom: 40px;">Fait à ..................., le {{ date('d/m/Y') }}<br>Le Chef d'Établissement</div>
            <div style="border-top: 1px dashed #333; width: 150px; margin: 0 auto;"></div>
        </div>
    </div>

    <div class="footer">
        {{ $ecole->nom ?? 'SGS' }} - Logiciel de Gestion Scolaire - Imprimé le {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
