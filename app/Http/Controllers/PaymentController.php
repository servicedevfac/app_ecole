<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Facture;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facture_id' => 'required|exists:factures,id',
            'montant' => 'required|numeric|min:0.01',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:espèces,virement,chèque,orange_money,moov_money,autre',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        return \DB::transaction(function () use ($validated) {
            $facture = Facture::findOrFail($validated['facture_id']);

            // Vérifier que le paiement ne dépasse pas le reste (optionnel selon la politique de l'école)
            /* 
            if ($validated['montant'] > $facture->reste) {
                return back()->withErrors(['montant' => 'Le montant du paiement dépasse le reste à payer.'])->withInput();
            }
            */

            $payment = Payment::create($validated);

            // Mettre à jour la facture
            $facture->updateStatus();

            return back()->with('success', 'Paiement enregistré avec succès. Nouveau solde : ' . number_format($facture->reste, 2) . ' FCFA');
        });
    }

    public function destroy(Payment $payment)
    {
        return \DB::transaction(function () use ($payment) {
            $facture = $payment->facture;
            $payment->delete();
            $facture->updateStatus();

            return back()->with('success', 'Paiement supprimé. Solde mis à jour.');
        });
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['facture.inscription.student', 'facture.inscription.classe', 'facture.payments', 'facture.inscription.ecole']);

        $amountInWords = $this->numberToWords($payment->montant);

        return view('admin.payments.receipt', compact('payment', 'amountInWords'));
    }

    private function numberToWords($number)
    {
        $hyphen = '-';
        $conjunction = ' ';
        $separator = ' ';
        $negative = 'moins ';
        $decimal = ' et ';
        $dictionary = array(
            0 => 'zéro',
            1 => 'un',
            2 => 'deux',
            3 => 'trois',
            4 => 'quatre',
            5 => 'cinq',
            6 => 'six',
            7 => 'sept',
            8 => 'huit',
            9 => 'neuf',
            10 => 'dix',
            11 => 'onze',
            12 => 'douze',
            13 => 'treize',
            14 => 'quatorze',
            15 => 'quinze',
            16 => 'seize',
            17 => 'dix-sept',
            18 => 'dix-huit',
            19 => 'dix-neuf',
            20 => 'vingt',
            30 => 'trente',
            40 => 'quarante',
            50 => 'cinquante',
            60 => 'soixante',
            70 => 'soixante-dix',
            80 => 'quatre-vingts',
            90 => 'quatre-vingt-dix',
            100 => 'cent',
            1000 => 'mille',
            1000000 => 'million',
            1000000000 => 'milliard'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . $this->numberToWords(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = (int) ($number / 100);
                $remainder = $number % 100;
                $string = ($hundreds > 1 ? $dictionary[$hundreds] . ' ' : '') . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->numberToWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;

                $unitName = $dictionary[$baseUnit];
                if ($baseUnit == 1000 && $numBaseUnits == 1) {
                    $string = $unitName;
                } else {
                    $string = $this->numberToWords($numBaseUnits) . ' ' . $unitName;
                    if ($numBaseUnits > 1 && $baseUnit >= 1000000) {
                        $string .= 's';
                    }
                }

                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->numberToWords($remainder);
                }
                break;
        }

        // Special French rules (70, 80, 90) - rudimentary fix
        $string = str_replace('soixante-dix-un', 'soixante et onze', $string);
        $string = str_replace('soixante-un', 'soixante et un', $string);
        $string = str_replace('quatre-vingts-', 'quatre-vingt-', $string);

        return ucfirst($string);
    }
}
