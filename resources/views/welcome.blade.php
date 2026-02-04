<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SGS - Système de Gestion Scolaire</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS via CDN (Sans Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sgs-blue': '#042954',
                        'sgs-yellow': '#ffae01',
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased font-sans bg-gray-50 text-[#1b1b18]">

    <!-- Navbar -->
    <nav class="bg-white shadow px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <!-- Placeholder for Logo if image exists, else text -->
            {{-- <img src="{{ asset('img/logo1.png') }}" class="h-10" alt="SGS Logo"> --}}
            <span class="text-2xl font-bold text-sgs-blue tracking-tight">SGS</span>
        </div>
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-sgs-blue">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-sgs-blue px-4 py-2 hover:bg-gray-100 rounded-lg transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-sgs-yellow text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition shadow-sm">Inscription</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-sgs-blue text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-6 py-20 lg:py-32 relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="md:w-1/2 space-y-6 text-center md:text-left">
                <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight">
                    La gestion scolaire <br>
                    <span class="text-sgs-yellow">réinventée.</span>
                </h1>
                <p class="text-lg text-gray-200 leading-relaxed max-w-lg mx-auto md:mx-0">
                    SGS simplifie la vie de votre établissement. Gestion des élèves, suivi des notes, emplois du temps et communication parents-professeurs en un seul endroit.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-sgs-yellow text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-yellow-500 transition shadow-lg transform hover:-translate-y-0.5">
                            Accéder au Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-sgs-yellow text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-yellow-500 transition shadow-lg transform hover:-translate-y-0.5">
                            Commencer maintenant
                        </a>
                        <a href="#features" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-white/10 transition">
                            En savoir plus
                        </a>
                    @endauth
                </div>
            </div>
            <div class="md:w-1/2 relative">
                 <!-- Decorative Abstract UI mockup -->
                <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 p-6 rounded-2xl shadow-2xl rotate-3 hover:rotate-0 transition duration-500">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="h-8 bg-gray-200/20 rounded w-3/4 animate-pulse"></div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="h-24 bg-blue-500/20 rounded animate-pulse delay-75"></div>
                            <div class="h-24 bg-yellow-500/20 rounded animate-pulse delay-100"></div>
                            <div class="h-24 bg-red-500/20 rounded animate-pulse delay-150"></div>
                        </div>
                        <div class="h-32 bg-gray-200/20 rounded w-full"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wave Separator -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-0">
             <svg class="relative block w-[calc(100%+1.3px)] h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-sgs-blue mb-4">Fonctionnalités Clés</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Une suite complète d'outils pour gérer votre établissement éducatif avec efficacité et simplicité.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition border-t-4 border-sgs-yellow group">
                    <div class="w-14 h-14 bg-yellow-50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                       <svg class="w-8 h-8 text-sgs-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Evaluations Centralisées</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Créez, gérez et suivez les notes de chaque élève. Générez des bulletins automatiquement et analysez les performances par classe.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition border-t-4 border-blue-500 group">
                    <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Gestion des Élèves</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dossiers complets, suivi des absences, historique disciplinaire et communication facilitée avec les parents.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition border-t-4 border-purple-500 group">
                    <div class="w-14 h-14 bg-purple-50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Planification & Emploi du Temps</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Optimisez l'usage des salles et l'agenda des professeurs. Évitez les conflits et publiez les plannings en temps réel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <span class="text-2xl font-bold text-white tracking-tight">SGS</span>
                <p class="mt-4 text-gray-400 max-w-xs">
                    Votre partenaire de confiance pour une numérisation réussie de l'éducation.
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-gray-200">Liens Rapides</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-sgs-yellow transition">Accueil</a></li>
                    <li><a href="#" class="hover:text-sgs-yellow transition">Fonctionnalités</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-sgs-yellow transition">Connexion</a></li>
                </ul>
            </div>
            <div>
                 <h4 class="font-bold mb-4 text-gray-200">Contact</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>support@sgs-school.com</li>
                    <li>+221 33 800 00 00</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} SGS - Système de Gestion Scolaire. Tous droits réservés.
        </div>
    </footer>

</body>
</html>
