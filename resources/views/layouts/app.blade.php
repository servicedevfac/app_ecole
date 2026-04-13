<!doctype html>
<html class="no-js" lang=""> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SGS</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('img/favicon.png') }}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ url('css/normalize.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ url('css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ url('fonts/flaticon.css') }}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{ url('css/fullcalendar.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ url('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/datepicker.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url('style.css') }}">
    <!-- Modernize js -->
    <script src="{{ url('js/modernizr-3.6.0.min.js') }}"></script>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper" class="wrapper bg-ash">
        <!-- Header Menu Area Start Here -->
        <div class="navbar navbar-expand-md header-menu-one bg-light">
            <div class="nav-bar-header-one">
                <div class="header-logo">
                    <a href="index.html">
                        <img src="img/logo.png" alt="logo">
                    </a>
                </div>
                <div class="toggle-button sidebar-toggle">
                    <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="d-md-none mobile-nav-bar">
                <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
                    data-target="#mobile-navbar" aria-expanded="false">
                    <i class="far fa-arrow-alt-circle-down"></i>
                </button>
                <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="header-main-menu collapse navbar-collapse justify-content-end" id="mobile-navbar">

                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">
                                <h5 class="item-title">{{ Auth::user()->name }}</h5>
                                <span>{{ Auth::user()->role }}</span>
                            </div>
                            <div class="admin-img">
                                <img src="img/figure/admin.jpg" alt="Admin">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">{{ Auth::user()->name }}</h6>
                            </div>
                            <div class="item-content">
                                <ul class="settings-list">
                                    <li><a href="#"><i class="flaticon-user"></i>Mon Profil</a></li>
                                    <li><a href="#"><i class="flaticon-list"></i>Tâches</a></li>
                                    <li><a href="#"><i
                                                class="flaticon-chat-comment-oval-speech-bubble-with-text-lines"></i>Message</a>
                                    </li>
                                    @if(auth()->user()->hasRole('Super Admin'))
                                        <li><a href="{{ route('admin.user.edit', Auth::user()->id) }}"><i
                                                    class="flaticon-gear-loading"></i>Paramètres du compte</a></li>
                                    @endif

                                    <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="flaticon-turn-off"></i>Se déconnecter
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
                <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="index.html"><img src="img/logo1.png" alt="logo"></a>
                    </div>
                </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        @role('Super Admin')
                        @can('utilisateurs.view')
                            <li class="nav-item text-muted px-3 mt-3 mb-1"
                                style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; font-weight: 800;">
                                Architecture Plateforme
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link"><i
                                        class="fas fa-chart-line"></i><span>Monitoring Global</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ecole.index') }}" class="nav-link"><i
                                        class="fas fa-school"></i><span>Gestion Écoles</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ecole_payments.index') }}" class="nav-link"><i
                                        class="fas fa-file-invoice-dollar"></i><span>Paiements Écoles</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.role.index') }}" class="nav-link"><i
                                        class="fas fa-user-shield"></i><span>Rôles & Permissions</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index') }}" class="nav-link"><i
                                        class="fas fa-users-cog"></i><span>Utilisateurs Globaux</span></a>
                            </li>
                        @endcan
                        @endrole

                        @role('enseignant')
                        {{-- MENU ENSEIGNANT --}}
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link"><i
                                    class="flaticon-calendar"></i><span>Tableau de bord</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.emploi_du_temps.index') }}" class="nav-link"><i
                                    class="flaticon-calendar"></i><span>Mon Emploi du temps</span></a>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-shopping-list"></i><span>Mes
                                    Évaluations</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{ route('admin.evaluations.index') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Toutes les évaluations</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.evaluations.create') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Créer une évaluation</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.bulletins.index') }}" class="nav-link"><i
                                    class="flaticon-script"></i><span>Bulletins & Notes</span></a>
                        </li>
                        @endrole

                        @if(!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('enseignant'))
                            {{-- MENU SCOLAIRE (ADMIN ÉCOLE & STAFF) --}}
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link"><i
                                        class="flaticon-calendar"></i><span>Tableau de bord</span></a>
                            </li>
                            @can('etudiants.view')
                                <li class="nav-item sidebar-nav-item">
                                    <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Élèves</span></a>
                                    <ul class="nav sub-group-menu">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.etudiant.index') }}" class="nav-link"><i
                                                    class="fas fa-angle-right"></i>Gestion / Inscriptions</a>
                                        </li>
                                        @can('etudiants.create')
                                            <li class="nav-item">
                                                <a href="{{ route('admin.etudiant.create') }}" class="nav-link"><i
                                                        class="fas fa-angle-right"></i>Ajouter un élève</a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @role('staff|admin')
                            <li class="nav-item sidebar-nav-item">
                                <a href="#" class="nav-link"><i
                                        class="flaticon-multiple-users-silhouette"></i><span>Enseignants</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.enseignant.index') }}" class="nav-link"><i
                                                class="fas fa-angle-right"></i>Tous les enseignants</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.enseignant.create') }}" class="nav-link"><i
                                                class="fas fa-angle-right"></i>Ajouter un enseignant</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.affectation.create') }}" class="nav-link"><i
                                                class="fas fa-angle-right"></i>Affecter à une classe</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item">
                                <a href="#" class="nav-link"><i class="flaticon-technological"></i><span>Parents</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.parent.index') }}" class="nav-link"><i
                                                class="fas fa-angle-right"></i>Tous les parents</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.parent.create') }}" class="nav-link"><i
                                                class="fas fa-angle-right"></i>Ajouter un parent</a>
                                    </li>
                                </ul>
                            </li>
                            @endrole
                            <li class="nav-item">
                                <a href="{{ route('admin.emploi_du_temps.index') }}" class="nav-link"><i
                                        class="flaticon-calendar"></i><span>Emploi du temps</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.evaluations.index') }}" class="nav-link"><i
                                        class="flaticon-shopping-list"></i><span>Évaluations</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.bulletins.index') }}" class="nav-link"><i
                                        class="flaticon-script"></i><span>Bulletins</span></a>
                            </li>
                            @can('paiements.view')
                                <li class="nav-item sidebar-nav-item">
                                    <a href="#" class="nav-link"><i
                                            class="flaticon-technological"></i><span>Comptabilité</span></a>
                                    <ul class="nav sub-group-menu">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.factures.index') }}" class="nav-link"><i
                                                    class="fas fa-angle-right"></i>Factures & Paiements</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('frais_scolaires.index') }}" class="nav-link"><i
                                                    class="fas fa-angle-right"></i>Configuration Frais</a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index') }}" class="nav-link"><i
                                        class="fas fa-users"></i><span>Utilisateurs</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ecole.settings') }}" class="nav-link"><i
                                        class="fas fa-school"></i><span>Paramètres de l'école</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('parametres_scolaires') }}" class="nav-link"><i
                                        class="fas fa-cogs"></i><span>Calendrier & Périodes</span></a>
                            </li>
                        @endif
                        <!-- <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-menu-1"></i><span>UI Elements</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{ url('notification-alart.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Alart</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('button.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Button</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('grid.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Grid</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('modal.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Modal</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('progress-bar.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Progress Bar</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('ui-tab.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Tab</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('ui-widget.html') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Widget</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('map.html') }}" class="nav-link"><i
                                    class="flaticon-planet-earth"></i><span>Map</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('account-settings.html') }}" class="nav-link"><i
                                    class="flaticon-settings"></i><span>Account</span></a>
                        </li> -->
                    </ul>
                </div>

                <!-- Sidebar Area End Here -->
            </div>
            <div class="dashboard-content-one">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>

        <footer class="footer-wrap-layout1">
            <div class="copyright">© Copyrights <a href="#">akkhor</a> 2019. All rights reserved. Designed by <a
                    href="#">PsdBosS</a></div>
        </footer>

        <!-- Footer Area End Here -->
    </div>


    <!-- jquery-->
    <script src="{{ url('js/jquery-3.3.1.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ url('js/plugins.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ url('js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <!-- Counterup Js -->
    <script src="{{ url('js/jquery.counterup.min.js') }}"></script>
    <!-- Moment Js -->
    <script src="{{ url('js/moment.min.js') }}"></script>
    <!-- Waypoints Js -->
    <script src="{{ url('js/jquery.waypoints.min.js') }}"></script>
    <!-- Scroll Up Js -->
    <script src="{{ url('js/jquery.scrollUp.min.js') }}"></script>
    <!-- Full Calender Js -->
    <script src="{{ url('js/fullcalendar.min.js') }}"></script>
    <!-- Chart Js -->
    <script src="{{ url('js/Chart.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ url('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>