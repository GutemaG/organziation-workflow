<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OGS</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

  </head>
  <body class="hold-transition sidebar-mini">
      <div class="wrapper" id="app">
        <!-- Navbar -->
        @include('layouts.includes/master-nav-bar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
         @include('layouts.includes.side-bar')
        <!-- ./Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Main content -->
          <router-view></router-view>
          <vue-progress-bar></vue-progress-bar>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
          <!-- To the right -->
          <div class="float-right d-none d-sm-inline">
            Anything you want
          </div>
          <!-- Default to the left -->
          <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
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
