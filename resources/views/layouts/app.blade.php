<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ url('js/external/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/external/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/external/bootstrap.min.js') }}"></script>
    <script src='fullcalendar/main.js' defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='fullcalendar/main.css' rel='stylesheet' />

    <!-- Styles -->

    <link href="{{ asset('css/external/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/external/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/external/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/external/bootstrap-fix.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div>
            {{-- Komunikaty błędów --}}
            @if (session('success'))
            <br>
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
            @endif
            @if (session('warning'))
            <br>
            <div class="alert alert-warning mt-4">
                {{ session('warning') }}
            </div>
            @endif
            @if (session('error'))
            <br>
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
            @endif
        </div>
        {{-- Początek manubar --}}
        <div class="page-wrapper chiller-theme">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                <i class="fas fa-bars"></i>
            </a>
            <nav id="sidebar" class="sidebar-wrapper">
              <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="#">Planer procesów</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                {{-- Sekcja użytkownika (opis) --}}
                @guest
                    @if (Route::has('login'))
                    @endif
                    @else
                    <div class="sidebar-header">
                        <div class="user-info">
                        <span class="user-name">
                            Użytkownik: {{ Auth::user()->email }}
                        </span>
                        <span class="user-role">Rola: {{ $role = DB::table('users')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('users.id', Auth::user()->id)
                            ->value('roles.name') }}
                        </span>
                        <span class="user-status">Firma: {{ $role = DB::table('users')
                            ->join('companies', 'users.company', '=', 'companies.id')
                            ->where('users.id', Auth::user()->id)
                            ->value('companies.name') }}
                        </span>
                        </div>
                    </div>
                @endguest


                {{-- Nagłówek sidebara --}}
                <div class="sidebar-menu">
                    <ul>
                        {{-- Widoczne tylko dla niezalogowanych --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="header-menu">
                                    <span>Logowanie</span>
                                </li>
                                <li>
                                    <a href="{{ route('login') }}">
                                    <i class="fas fa-lock-open"></i>
                                    <span>Zaloguj</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Poniżej widoczne tylko dla zalogowanych --}}
                            @else
                                {{-- Widoczne tylko dla Super Administratora (rola companies) --}}
                                @can('companies')
                                    <li class="header-menu">
                                        <span>Administracja aplikacji</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('companies') }}">
                                            <i class="fas fa-building"></i>
                                            <span>Firmy</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- Widoczne tylko dla Super Administratora (rola users) --}}
                                @can('users')
                                    <li>
                                        <a href="{{ url('users') }}">
                                            <i class="fas fa-user-friends"></i>
                                            <span>Użytkownicy</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- Widoczne tylko dla Administratora w firmie (rola company)--}}
                                @can('company')
                                    <li class="header-menu">
                                    <span>Administracja firmy</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('company/editCompany') }}">
                                            <i class="fas fa-building"></i>
                                            <span>Firma</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- Widoczne tylko dla Administratora w firmie (rola company_users)--}}
                                @can('company_users')
                                    <li>
                                        <a href="{{ url('companyUsers/admin') }}">
                                            <i class="fas fa-user-friends"></i>
                                            <span>Użytkownicy</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- Widoczność sekcji - widoczne dla minimum kierownika w firmie (rola category)--}}
                                @can('category')
                                    <li class="header-menu">
                                        <span>Tworzenie szablonów</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('categories') }}">
                                            <i class="fas fa-clipboard-list"></i>
                                            <span>Kategorie</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- Widoczne dla minimum kierownika w firmie (rola manage_global_checklists)--}}
                                @can('manage_global_checklists')
                                    <li>
                                        <a href="{{ url('globalChecklists') }}">
                                            <i class="fas fa-list-alt"></i>
                                            <span>Szablony</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- Widoczne dla minimum wdrożeniowca w firmie (rola global_checklists)--}}
                                @can('global_checklists')
                                    <li class="header-menu">
                                        <span>Przydzielanie list</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('companyUsers') }}">
                                            <i class="fas fa-users-cog"></i>
                                            <span>Użytkownicy</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('companyChecklists') }}">
                                            <i class="fas fa-eye"></i>
                                            <span>Listy</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- Widoczne dla minimum użytkownika w firmie (rola user_checklist)--}}
                                @can('user_checklist')
                                    <li class="header-menu">
                                        <span>Realizacja list</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('mychecklists') }}">
                                            <i class="far fa-calendar-check"></i>
                                            <span>Moje listy</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('calendar') }}">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Kalendarz</span>
                                        </a>
                                    </li>
                                @endcan
                        @endguest
                    </ul>
                </div>
                <!-- sidebar-menu  -->
              </div>
              <!-- sidebar-content  -->
              @guest
                        @if (Route::has('login'))

                        @endif
                        @else
                        <div class="sidebar-footer">
                            <a href="{{ url('changePassword') }}" title="Zmień hasło">
                              <i class="fa fa-cog"></i>
                            </a>
                              <a href="{{ route('logout') }}" title="Wyloguj"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                          </div>
                    @endguest
            </nav>
            <!-- sidebar-wrapper  -->
            <main class="page-content">
                <div class="container-fluid">
                    <div class="col-sm-12 col-md-11 offset-md-1">
                        @yield('content')

                        <footer class="text-center">
                        <div class="mb-2">
                            <small>
                            © <script>document.write(new Date().getFullYear());</script> made by - Hubert Wanga
                            </small>
                        </div>
                        </footer>
                    </div>
                </div>
            </main>
          </div>
        {{-- Koniec menubar --}}
    </div>
</body>

@yield('js-scripts')
<script>
$(".sidebar-dropdown > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if (
        $(this)
            .parent()
            .hasClass("active")
    ) {
        console.log("Jeśli rodzic ma active");
        $(".sidebar-dropdown").removeClass("active");
        $(this)
            .parent()
            .removeClass("active");
    } else {
        console.log("Jeśli rodzic nie ma active");
        $(".sidebar-dropdown").removeClass("active");
        $(this)
            .next(".sidebar-submenu")
            .slideDown(200);
        $(this)
            .parent()
            .addClass("active");
    }
});

$("#close-sidebar").click(function () {
    $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function () {
    $(".page-wrapper").addClass("toggled");
});
</script>
</html>
