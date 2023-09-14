<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('encabezado','')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('estilosadd','')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/blank/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/blank/adminlte.css')}}"> 
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- DataTables -->
    <!-- Select2 -->
    <!-- Notificaciones Toastr -->
    <!-- SweetAlert2 -->
    <!-- iCheck for checkboxes and radio inputs -->
    <!-- Ekko Lightbox -->
     <!--<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css"> -->
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{asset('public/blank/estilos-gobyuc.css')}}"> 
  </head>

  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
              <i class="far fa-user"></i> {{auth()->user()->nombre}}          </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="{{route('logout')}}" class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Salir
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- =============================================== -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Logo -->
        <a href="{{URL::to('/')}}" class="brand-link">
          <span class="brand-text font-weight-semibold">INCCOPY</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <nav class="mt-2">
            @yield('opciones','')
            
          </nav>
        </div>
      </aside>

      <!-- =============================================== -->

      <div id="divContent" class="content-wrapper">
        
        <section class="content">
          <!-- card-dark -->
          <div class="container body" id="app">@yield('contenido','')</div>

        </section>
      </div>
      <!-- =============================================== -->
     

      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Versión</b> 1.0.0        </div>
        <strong><span class="text-dark">&copy; 2021 Departamento de Informática. </span><a href="http://www.inccopy.yucatan.gob.mx/" target="_blank" class="text-sec-gobyuc">INCCOPY - Gobierno del Estado de Yucatán</a></strong>
      </footer>

    </div>
    <!-- ./wrapper -->
    <script src="{{asset('public/vue.js')}}"></script>

    <!-- jQuery -->
    <script src="{{asset('public/blank/jquery.min.js')}}"></script>
    @yield('codigosopcional','')

    <!-- Bootstrap 4 -->
    <script src="{{asset('public/blank/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('public/blank/adminlte.min.js')}}"></script></body>

    <!-- DataTables -->

    <!-- Select2 -->

    

    {{--  <script defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDF6gVlaRZ7c2lDm8VG2RLyADOqVhl7260">
    </script>  --}}
    <!-- AIzaSyBxhRsZEfeMcpo1OLbDPUBcs9YqKq--Wko -->
    <!-- AIzaSyDF6gVlaRZ7c2lDm8VG2RLyADOqVhl7260 -->

    <!-- AdminLTE for demo purposes -->
    
    
  </body>
</html>