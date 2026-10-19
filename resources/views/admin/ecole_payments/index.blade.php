@extends('layouts.app')
@section('title', 'Paiements Plateforme (B2B)')
@section('content')

    <div class="breadcrumbs-area">
        <h3 style="font-weight: 800; color: #2d3748;">Paiements Plateforme (B2B)</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Tous les règlements écoles</li>
        </ul>
    </div>

    <!-- Summary Cards -->
    <div class="row gutters-20">
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20" style="border-radius: 15px; border-top: 4px solid #48bb78;">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: rgba(72, 187, 120, 0.1); color: #48bb78;">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <div class="item-title" style="font-size: 11px; text-transform: uppercase;">Revenu Total B2B</div>
                            <div class="item-number" style="font-size: 24px; font-weight: 800;">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
        <div class="card-body">
            <div class="heading-layout1 mg-b-25">
                <div class="item-title">
                    <h3 style="font-weight: 700; color: #2d3748;">Historique Global des Règlements</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr style="background: #f7fafc;">
                            <th>Date</th>
                            <th>École</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Référence</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->date_paiement->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.ecole.show', $payment->ecole->slug) }}" style="font-weight: 700; color: #667eea;">
                                        {{ $payment->ecole->nom }}
                                    </a>
                                </td>
                                <td style="font-weight: 800; color: #2d3748;">{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</td>
                                <td><span class="badge" style="background: #ebf8ff; color: #2b6cb0;">{{ $payment->mode_paiement }}</span></td>
                                <td style="font-family: monospace; font-size: 12px; color: #718096;">{{ $payment->reference ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.ecole_payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce record ?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger" style="border:none; background:none; cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Auccun paiement enregistré sur la plateforme.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

@endsection
