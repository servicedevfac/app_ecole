@extends('layouts.app')
@section('title', 'Détails Facture #' . $facture->id)
@section('content')

    <div class="breadcrumbs-area">
        <h3>Facture #{{ $facture->id }}</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li><a href="{{ route('admin.factures.index') }}">Factures</a></li>
            <li>Détails</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="item-title mb-4">
                        <h3>Résumé</h3>
                    </div>
                    <div class="info-table table-responsive">
                        <table class="table text-nowrap">
                            <tbody>
                                <tr>
                                    <td>Élève:</td>
                                    <td class="font-medium text-dark-medium">{{ $facture->inscription->student->nom }}
                                        {{ $facture->inscription->student->prenom }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Classe:</td>
                                    <td class="font-medium text-dark-medium">{{ $facture->inscription->classe->nom }}</td>
                                </tr>
                                <tr>
                                    <td>Montant Total:</td>
                                    <td class="font-medium text-dark-medium text-primary">
                                        {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
                                    </td>
                                </tr>
                                <tr>
                                    <td>Déjà Payé:</td>
                                    <td class="font-medium text-dark-medium text-success">
                                        {{ number_format($facture->montant_total - $facture->reste, 0, ',', ' ') }} FCFA
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reste à Payer:</td>
                                    <td class="font-medium text-dark-medium text-danger">
                                        {{ number_format($facture->reste, 0, ',', ' ') }} FCFA
                                    </td>
                                </tr>
                                <tr>
                                    <td>Statut:</td>
                                    <td>
                                        <span
                                            class="badge {{ $facture->statut == 'soldé' ? 'badge-success' : 'badge-danger' }}">
                                            {{ strtoupper($facture->statut) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($facture->reste > 0)
                        <button type="button" class="btn btn-primary btn-lg btn-block mt-4" data-toggle="modal"
                            data-target="#paymentModal">
                            <i class="fas fa-plus"></i> Enregistrer un Paiement
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Historique des Paiements</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display text-nowrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Mode</th>
                                    <th>Référence</th>
                                    <th>Montant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($facture->payments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->date_paiement)->format('d/m/Y') }}</td>
                                        <td>{{ ucfirst($payment->mode_paiement) }}</td>
                                        <td>{{ $payment->reference ?? '-' }}</td>
                                        <td>{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.payments.receipt', $payment->id) }}" target="_blank"
                                                    class="btn btn-sm btn-info mr-2">
                                                    <i class="fas fa-print"></i> Reçu
                                                </a>
                                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST"
                                                    onsubmit="return confirm('Supprimer ce paiement ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucun paiement enregistré</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Paiement --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouveau Paiement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="facture_id" value="{{ $facture->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Montant (FCFA)</label>
                            <input type="number" name="montant" class="form-control" value="{{ $facture->reste }}"
                                max="{{ $facture->reste }}" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Date de Paiement</label>
                            <input type="date" name="date_paiement" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Mode de Paiement</label>
                            <select name="mode_paiement" class="form-control" required>
                                <option value="espèces">Espèces</option>
                                <option value="virement">Virement</option>
                                <option value="chèque">Chèque</option>
                                <option value="orange_money">Orange Money</option>
                                <option value="moov_money">Moov Money</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Référence / N° de transaction</label>
                            <input type="text" name="reference" class="form-control" placeholder="Optionnel">
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection