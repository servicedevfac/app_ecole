@extends('layouts.app')
@section('title', 'Page Introuvable - Erreur 404')
@section('content')
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3 style="font-weight: 800; color: #2d3748;">Erreur 404</h3>
        <ul>
            <li><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li>Page Introuvable</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->

    <div class="row gutters-20">
        <div class="col-12">
            <div class="card height-auto" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); min-height: 60vh; display: flex; align-items: center; justify-content: center;">
                <div class="card-body w-100 text-center py-5">
                    <div class="error-icon mb-4">
                        <div style="display: inline-flex; align-items: center; justify-content: center; width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #11cdef, #1171ef); box-shadow: 0 10px 20px rgba(17, 205, 239, 0.3);">
                            <i class="fas fa-search text-white" style="font-size: 50px;"></i>
                        </div>
                    </div>
                    <h1 style="font-size: 80px; font-weight: 900; color: #2d3748; line-height: 1; margin-bottom: 20px;">404</h1>
                    <h2 style="font-weight: 700; color: #4a5568; margin-bottom: 15px;">Page Introuvable</h2>
                    <p style="font-size: 16px; color: #718096; max-width: 500px; margin: 0 auto 30px;">
                        Désolé, la page que vous recherchez n'existe pas, a été déplacée ou est temporairement indisponible.
                    </p>
                    <button onclick="window.history.back();" class="btn-fill-lg bg-blue-dark text-white mr-3" style="font-weight: 600; padding: 12px 30px; border-radius: 8px; border: none;">
                        <i class="fas fa-arrow-left mr-2"></i> Retour
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="font-weight: 600; padding: 12px 30px; border-radius: 8px; display: inline-block;">
                        <i class="fas fa-home mr-2"></i> Tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


//app_ecole/resources/views/admin/404.blade.php
