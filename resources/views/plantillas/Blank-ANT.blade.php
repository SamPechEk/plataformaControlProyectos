<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>@yield('encabezado','')</title>

  <!-- Font Awesome Icons -->
  @yield('estilosadd','')
  <link rel="icon" href="{{asset('public/img/inccopy.png')}}" type="image/png">
  <link rel="stylesheet" href="{{asset('public/blank/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/blank/adminlte.min.css')}}"> 
  <link rel="stylesheet" href="{{asset('public/darkmode/styles.css')}}"> 


  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .body {
      background-image: url("{{asset('public/img/foto.jpg')}}");
    }
  </style>
</head>
<body class="hold-transition layout-top-nav" id="body">
<div class="wrapper" class="body">

  <!-- Navbar -->
  <nav class="dark main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{URL::to('/')}}" class="navbar-brand">
        <img src="{{asset('public/img/inccopy 2.jpg')}}" alt="AdminLTE Logo" class="brand-image elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light letras" ></span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        @yield('opciones','')
        
        <!-- SEARCH FORM -->
        <form class="form-inline ml-0 ml-md-3" action="{{action('BuscadorController@buscar')}}" method="POST" id="search">
          <div class="input-group input-group-sm">
          {{csrf_field()}}

            <input  type="text" name="var" id="input_var" v-model="input_var" placeholder="Proyecto, programa, etc.." value="" class="form-control">
            <div class="input-group-append">
              <button class="btn btn-navbar boton" @click="validarSearch" type="submit">
                <i class="fas fa-search letras"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      

      <!-- Right navbar links -->
      <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
       
          <button class="interruptor" id="interruptor">
            <span class="span"><img src="{{asset('public/darkmode/sol.png')}}" class="span"></span>
            <span class="span"><img src="{{asset('public/darkmode/luna.png')}}" class="span"></span>
          </button>
        
        @if(!is_null(auth()->user()))
       
          <form method="POST" action="{{route('logout')}}">
            {{csrf_field()}}
            <button class="btn btn-danger boton">Cerrar sesión </button>
          </form>
        @endif
          
        
      </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper dark body" id="contenidoo">
    <div class="container body" id="app">@yield('contenido','')</div>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
 
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class=" dark main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>INCCOPY &copy; Datos <a href="https://adminlte.io">Otro dato enlace</a>.</strong> Leyenda
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{asset('public/vue.js')}}"></script>
<script>
        new Vue({
        el:'#search',
        data:{
            input_var:'',
            bandera_pagina:0
        }
        ,methods:{
            validarSearch:function(event) {
              this.bandera_pagina=0;

              //input_var
              if (this.input_var==="") {
                  this.bandera_pagina=1;
                  var bandera = 0;
                  const da = document.getElementById('input_var')
                  for (let i = 0; i <= da.classList.length; i++) {
                      if (da.classList[i]=='is-invalid'){
                          bandera =1;
                      }
                  }
                  if (bandera!=1) {
                      da.classList.toggle('is-invalid')
                  }     
              }else{
                  var bandera = 0;
                  const da = document.getElementById('input_var')
                  for (let i = 0; i <= da.classList.length; i++) {
                      if (da.classList[i]=='is-invalid'){
                          bandera =1;
                      }
                  }
                  if (bandera==1) {
                      da.classList.toggle('is-invalid')
                  } 
              } 
              //input_var


              if (this.bandera_pagina==1) {
                  event.preventDefault();
              }      
            }
        },
        components:{
            
        }
        });
    </script>
<script src="{{asset('public/blank/jquery.min.js')}}"></script>
  <!-- sin sesiion activa--><!-- sin sesiion activa--><!-- sin sesiion activa--><!-- sin sesiion activa-->
@yield('codigosopcional','')
<script src="{{asset('public/darkmode/ambiente.js')}}"></script>
<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="{{asset('public/blank/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/blank/adminlte.min.js')}}"></script></body>
</html>
