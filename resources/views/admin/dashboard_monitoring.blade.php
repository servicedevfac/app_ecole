 @extends('layouts.app')
@section('title', 'Tableau de Bord Monitoring')
@section('content')

    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3 style="font-weight: 800; color: #2d3748;">Oversight Plateforme (Monitoring)</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Monitoring Global</li>
        </ul>
    </div>

    <!-- Global Key Metrics -->
    <div class="row gutters-20">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20" style="border-top: 4px solid #667eea; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-school text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; color: #777; letter-spacing: 1px;">Établissements</h6>
                            <h2 class="font-weight-bold mb-0" style="font-size: 32px; color: #2d3748;">{{ $totalSchools }}</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> {{ $newSchoolsCount }} ce mois</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="dashboard-summery-one mg-b-20" style="border-top: 4px solid #4facfe; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="item-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-user-graduate text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; color: #777; letter-spacing: 1px;">Total Éleves</h6>
                            <h2 class="font-weight-bold mb-0" style="font-size: 32px; color: #2d3748;">{{ number_format($totalStudentsCount) }}</h2>
                            <small class="text-muted">Global plateforme</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12 col-12">
            <div class="dashboard-summery-one mg-b-20" style="border-top: 4px solid #43e97b; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); background: #fff;">
                <div class="row align-items-center">
                    <div class="col-4">
                        <div class="item-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7); width: 70px; height: 70px; border-radius: 12px;">
                            <i class="fas fa-file-invoice-dollar text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col-8 text-right">
                        <div class="item-content">
                            <h6 class="text-uppercase mb-0" style="font-size: 11px; color: #777; letter-spacing: 1px;">Revenu Plateforme</h6>
                            <h2 class="font-weight-bold mb-0" style="font-size: 32px; color: #2d3748;">{{ number_format($platformRevenue, 0, ',', ' ') }} <small style="font-size: 14px;">FCFA</small></h2>
                            <small class="text-muted"><a href="{{ route('admin.ecole_payments.index') }}" style="color: #43e97b;">Voir le détail des règlements</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters-20">
        <!-- Top Performing Schools -->
        <div class="col-xl-7 col-12">
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-25">
                        <div class="item-title">
                            <h3 style="font-weight: 700; color: #2d3748;">Top 5 Établissements (Par Effectif)</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr style="background: #f7fafc;">
                                    <th style="border: none; padding: 15px;">École</th>
                                    <th style="border: none; padding: 15px;">Plan</th>
                                    <th style="border: none; padding: 15px;">Effectif</th>
                                    <th style="border: none; padding: 15px;">Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSchools as $school)
                                    <tr>
                                        <td style="padding: 15px;">
                                            <div class="d-flex align-items-center">
                                                @if($school->logo)
                                                    <img src="{{ asset('storage/' . $school->logo) }}" alt="" style="width: 35px; height: 35px; border-radius: 8px; margin-right: 12px; object-fit: cover;">
                                                @else
                                                    <div style="width: 35px; height: 35px; border-radius: 8px; background: #edf2f7; margin-right: 12px; display: flex; align-items: center; justify-content: center; color: #a0aec0;">
                                                        <i class="fas fa-school"></i>
                                                    </div>
                                                @endif
                                                <span style="font-weight: 700; color: #2d3748;">{{ $school->nom }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #ebf8ff; color: #2b6cb0; border-radius: 6px; padding: 5px 10px;">{{ $school->plan ?? 'Standard' }}</span>
                                        </td>
                                        <td><strong>{{ $school->etudiants_count }}</strong> <small>élèves</small></td>
                                        <td>
                                            @php
                                                $percent = $school->limite_etudiants ? ($school->etudiants_count / $school->limite_etudiants) * 100 : 0;
                                            @endphp
                                            <div class="progress" style="height: 6px; border-radius: 10px; background: #edf2f7;">
                                                <div class="progress-bar" style="width: {{ $percent }}%; background: #667eea; border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health / Recent Payments -->
        <div class="col-xl-5 col-12">
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05);">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-25">
                        <div class="item-title">
                            <h3 style="font-weight: 700; color: #2d3748;">Flux Financier (Derniers Encaissements)</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @foreach($recentPayments as $payment)
                                    <tr>
                                        <td style="border:none;">
                                            <div style="font-size: 14px; font-weight: 700;">+ {{ number_format($payment->montant, 0, ',', ' ') }} FCFA</div>
                                            <div style="font-size: 11px; color: #a0aec0;">{{ $payment->ecole->nom }}</div>
                                        </td>
                                        <td class="text-right" style="border:none;">
                                            <div style="font-size: 12px; color: #718096;">{{ $payment->created_at->diffForHumans() }}</div>
                                            <span class="badge" style="background: #f0fff4; color: #2f855a; font-size: 10px;">ENCAISSÉ</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.ecole.index') }}" class="btn-fill-sm btn-gradient-yellow btn-hover-bluedark">Ouvrir la gestion des écoles</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
