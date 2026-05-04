<?php
    $layout = auth()->check() ? 'layouts.app' : 'errors.layout';
?>
@extends($layout)

@section('title', 'Accès Refusé - Erreur 403')

@section('content')
    @if(auth()->check())
    <div class="breadcrumbs-area">
        <h3 style="font-weight: 800; color: #2d3748;">Erreur 403</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Accès Refusé</li>
        </ul>
    </div>
    @endif

    <div class="row gutters-20">
        <div class="col-12">
            <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); min-height: 60vh; display: flex; align-items: center; justify-content: center; background: transparent;">
                <div class="card-body w-100 text-center py-5">
                    <div class="error-icon mb-4">
                        <div style="display: inline-flex; align-items: center; justify-content: center; width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #f5365c, #f56036); box-shadow: 0 10px 20px rgba(245, 54, 92, 0.3);">
                            <i class="fas fa-lock text-white" style="font-size: 50px;"></i>
                        </div>
                    </div>
                    <h1 style="font-size: 80px; font-weight: 900; color: #2d3748; line-height: 1; margin-bottom: 20px;">403</h1>
                    <h2 style="font-weight: 700; color: #4a5568; margin-bottom: 15px;">Accès Refusé</h2>
                    <p style="font-size: 16px; color: #718096; max-width: 500px; margin: 0 auto 30px;">
                        Désolé, vous n'avez pas les autorisations nécessaires pour accéder à cette ressource. 
                        Veuillez contacter votre administrateur système si vous pensez qu'il s'agit d'une erreur.
                    </p>
                    
                    @if(auth()->check())
                        <button onclick="window.history.back();" class="btn-fill-lg bg-blue-dark text-white mr-3" style="font-weight: 600; padding: 12px 30px; border-radius: 8px; border: none;">
                            <i class="fas fa-arrow-left mr-2"></i> Retour
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="font-weight: 600; padding: 12px 30px; border-radius: 8px; display: inline-block;">
                            <i class="fas fa-home mr-2"></i> Tableau de bord
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="font-weight: 600; padding: 12px 30px; border-radius: 8px; display: inline-block; text-decoration: none;">
                            <i class="fas fa-home mr-2"></i> Retour à l'accueil
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
