<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>OGS</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ mix('/css/normalize.css') }}">
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        }
    </script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        @auth
            <!-- Navbar -->
            @include('layouts.includes/master-nav-bar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('layouts.includes.side-bar')
            <!-- ./Main Sidebar Container -->
        @endauth
        @if(auth()->check())
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-top: 4.2rem;">
            <!-- Main content -->
            {{-- <vue-welcome></vue-welcome> --}}
            <router-view :key="$route.fullPath"></router-view>
            <vue-progress-bar></vue-progress-bar>
            <!-- /.content -->
        </div>
        @else
        <div class="" style="">
            <!-- Main content -->
            <guest-welcome></guest-welcome>
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
            <!-- /.content -->
        </div>
        @endif
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
        @yield('welcome')
        @if (!auth()->check())
            <vue-login></vue-login>
        @endif
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    @auth
        <script>
            window.user = @json(auth()->user())
        </script>
    @endauth
    <!-- jQuery -->
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
