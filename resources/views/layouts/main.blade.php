<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ketosin | @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('main-assets/imgs/light-logo.png') }}" type="image/x-icon" id="fav-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/remix-icons/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('main-assets/css/app.css') }}">

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
</head>

<body onload="hideLoader()" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="loader-wrapper">
        <img src="{{ asset('main-assets/imgs/loader.svg') }}" alt="loader">
    </div>

    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div> --}}

        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('header-title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            @yield('list-header')
                            {{-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item">Dashboard v1</li>
                            </ol> --}}
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @include('layouts.footer')

    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.js"></script>
    <script src="{{ asset('main-assets/js/app.js') }}"></script>
</body>

</html>
