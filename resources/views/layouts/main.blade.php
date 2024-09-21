<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
</head>

<body>
    <header class="main_header_area position-absolute w-100">
        <div class="header_menu " id="header_menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg py-6">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="navbar-brand m-0">
                                <img src="{{ asset('images/logo/1.png') }}" alt="Logo" class="w-100">
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-6">
                            <div class="collapse navbar-collapse justify-content-between ms-8 "
                                id="bs-example-navbar-collapse-1">
                                <ul class="navbar-nav align-items-center" id="responsive-menu">
                                    <li class="nav-item">
                                        <a class="nav-link px-2 my-4 py-0 text-white" aria-current="page"
                                            href="{{ url('/') }}">vivir en plenitud</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-2 my-4 py-0 text-white"
                                            href="{{ url('/consulta_individual') }}">consulta
                                            individual</a>
                                    </li>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-2 my-4 py-0 text-white"
                                            href="{{ url('/taller_online') }}">taller
                                            online</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-2 my-4 py-0 text-white"
                                            href="{{ url('/publicaciones') }}">publicaciones</a>
                                    </li>

                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-2 my-4 py-0 text-white"
                                            href="{{ url('/contactos') }}">contactame</a>
                                    </li>
                                </ul>
                                <div class="menu-search">
                                    <a class="btn" href="{{ url('/login') }}">area privada<i
                                            class="fa fa-long-arrow-right ms-4"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="slicknav-mobile"></div>
                    </div>
                </nav>
            </div>
            <div id="search1">
                <button type="button" class="close">×</button>
                <form>
                    <input class="form-control form-control-lg rounded text-white" placeholder="Search...">
                </form>
                <button type="button" class="btn"><i class="fa fa-search text-white"
                        aria-hidden="true"></i></button>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="pt-6 text-center text-white position-relative z-1" style="background: #000000;">
        <div class="container">
            <div class="footer-disciption mt-2 mb-4">
                <div class="footer-socials">
                    <ul class="m-0 p-0">
                        <li class="d-inline me-2">
                            <a href="https://www.facebook.com/profile.php?id=61563937152210" target="_blank"
                                class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="d-inline me-2">
                            <a href="https://www.youtube.com" target="_blank"
                                class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                                <i class="fa fa-youtube-play"></i>
                            </a>
                        </li>
                        <li class="d-inline me-2">
                            <a href="https://www.instagram.com" target="_blank"
                                class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                        <li class="d-inline me-2">
                            <a href="https://www.tiktok.com/@sbyetransformacion" target="_blank"
                                class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                                <img src="{{ asset('images/icon/tiktok.png') }}" style="width: 20px;">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-menu pb-2">
                <ul class="p-0 m-0">
                    <li class="d-inline mx-2"><a href="javascript:;"><small>avisos legales</small></a></li>
                    <li class="d-inline mx-2"><a href="javascript:;"><small>privacidad</small></a></li>
                </ul>
            </div>
        </div>
        <div class="copyright pb-6 pt-1">
            <small>&#169;2024 sbye salud s.l.</small>
        </div>
        </div>
    </footer>
    <div id="back-to-top" style="display: block;">
        <a href="#" class="bg-company position-relative align-items-center rounded-circle d-block"></a>
    </div>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/custom-nav.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('scripts')
</body>

</html>
