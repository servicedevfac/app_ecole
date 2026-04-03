<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement #{{ $payment->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
        }

        .receipt-wrapper {
            width: 210mm;
            height: auto; /* Changé de 297mm à auto pour éviter les sauts de page forcés */
            min-height: 297mm;
            padding: 5mm; /* Réduit pour plus de sécurité */
            box-sizing: border-box;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .receipt-container {
            width: 100%;
            height: auto;
            min-height: 35mm; /* Format Micro */
            border: 1px solid #ccc;
            padding: 4px 8px;
            box-sizing: border-box;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            position: relative;
            background: #fff;
            margin-bottom: 2px;
            line-height: 1.1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #3366cc;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }

        .logo {
            font-size: 12px;
            font-weight: bold;
            color: #3366cc;
        }

        .receipt-title {
            text-align: center;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: bold;
            margin: 2px 0;
            color: #3366cc;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
            font-size: 9px;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            font-weight: bold;
        }

        .payment-details {
            margin: 10px 0;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
        }

        .amount-big {
            font-size: 12px;
            text-align: center;
            padding: 3px;
            border: 1px dashed #3366cc;
            margin: 3px 0;
            background: #fff;
            font-weight: bold;
        }

        .footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 80px;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            margin-top: 30px;
        }

        .watermark {
            display: none; /* Supprimé pour gagner en clarté sur petit format */
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            .no-print {
                display: none;
            }

            .print-only {
                display: block !important;
            }

            body {
                padding: 0;
                margin: 0;
                background: none;
            }

            .receipt-wrapper {
                width: 210mm;
                height: auto !important;
                padding: 5mm;
                margin: 0;
                border: none;
            }

            .receipt-container {
                border: 1px solid #ccc !important;
                height: auto !important;
                min-height: 35mm !important;
                page-break-inside: avoid;
                margin-bottom: 2px;
                padding: 4px 8px !important;
            }

            .footer {
                margin-top: auto;
                display: flex;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; cursor: pointer; background: #3366cc; color: white; border: none; border-radius: 4px;">Imprimer
            le reçu</button>
        <button onclick="window.close()"
            style="padding: 10px 20px; cursor: pointer; background: #666; color: white; border: none; border-radius: 4px; margin-left: 10px;">Fermer</button>
    </div>

    <div class="receipt-wrapper">
        @php
            $ecole = $payment->facture->inscription->ecole;
        @endphp

        @foreach(['ÉCOLE', 'ÉLÈVE'] as $type)
        <div class="receipt-container" style="border: 2px solid #3366cc; margin-bottom: 20px; padding: 15px; border-radius: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #3366cc; margin-bottom: 10px; padding-bottom: 8px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    @if($ecole && $ecole->logo)
                        <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo" style="max-width: 60px; max-height: 60px;">
                    @else
                        <div style="font-size: 24px; font-weight: bold; color: #3366cc;">SGS</div>
                    @endif
                    <div>
                        <div style="font-weight: bold; font-size: 16px; color: #3366cc; text-transform: uppercase;">{{ $ecole->nom ?? 'SGS - ÉCOLE' }}</div>
                        <div style="font-size: 11px; color: #666;">
                            {{ $ecole->adresse }} @if($ecole->telephone) | Tél: {{ $ecole->telephone }} @endif
                        </div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 14px; font-weight: bold; color: #3366cc;">REÇU DE PAIEMENT</div>
                    <div style="font-size: 12px; font-weight: bold;">N° #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div style="font-size: 11px; color: #555;">Date: {{ \Carbon\Carbon::parse($payment->date_paiement)->format('d/m/Y') }}</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                <div style="font-size: 12px; line-height: 1.5;">
                    <div><span style="color: #666; font-weight: bold; min-width: 80px; display: inline-block;">Élève :</span> <strong>{{ $payment->facture->inscription->student->nom }} {{ $payment->facture->inscription->student->prenom }}</strong></div>
                    <div><span style="color: #666; font-weight: bold; min-width: 80px; display: inline-block;">Matricule :</span> {{ $payment->facture->inscription->student->matricule }}</div>
                    <div><span style="color: #666; font-weight: bold; min-width: 80px; display: inline-block;">Classe :</span> {{ $payment->facture->inscription->classe->nom }}</div>
                </div>
                <div style="font-size: 12px; line-height: 1.5;">
                    <div><span style="color: #666; font-weight: bold; min-width: 100px; display: inline-block;">Mode :</span> {{ ucfirst($payment->mode_paiement) }}</div>
                    @if($payment->reference)
                        <div><span style="color: #666; font-weight: bold; min-width: 100px; display: inline-block;">Réf :</span> {{ $payment->reference }}</div>
                    @endif
                    <div><span style="color: #666; font-weight: bold; min-width: 100px; display: inline-block;">Motif :</span> Paiement Scolarité</div>
                </div>
            </div>

            <div style="background: #f0f7ff; padding: 15px; border-radius: 6px; border: 1px solid #3366cc; text-align: center; margin-bottom: 15px;">
                <div style="font-size: 22px; font-weight: bold; color: #3366cc; margin-bottom: 5px;">{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</div>
                <div style="font-size: 12px; font-style: italic; color: #444;">Arrêté le présent reçu à la somme de : <strong>{{ $amountInWords }} francs CFA</strong>.</div>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 11px; color: #333; margin-bottom: 15px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                <div>Total Facture: <strong>{{ number_format($payment->facture->montant_total, 0, ',', ' ') }} FCFA</strong></div>
                <div>Déjà Payé: <strong>{{ number_format($payment->facture->payments->where('date_paiement', '<=', $payment->date_paiement)->sum('montant'), 0, ',', ' ') }} FCFA</strong></div>
                <div style="color: #d9534f;">Reste à payer: <strong>{{ number_format($payment->facture->reste, 0, ',', ' ') }} FCFA</strong></div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                <div style="text-align: center;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 40px;">Le Parent</div>
                    <div style="font-size: 10px; color: #aaa;">(Signature)</div>
                </div>
             
                <div style="text-align: center;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 40px;">La Caisse</div>
                    <div style="font-size: 10px; color: #aaa;">(Cachet & Signature)</div>
                </div>
            </div>
        </div>
        @endforeach

        <div style="text-align: center; font-size: 9px; color: #999; margin-top: 10px;">
            Document généré par SGS - {{ date('d/m/Y H:i:s') }}
        </div>
    </div>
    </div>

</body>

</html>