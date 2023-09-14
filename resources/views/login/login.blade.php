
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('public/blank/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/blank/adminlte.css')}}"> 
  <link rel="stylesheet" href="{{asset('public/darkmode/styles.css')}}"> 
  <link rel="stylesheet" href="{{asset('public/blank/estilos-gobyuc.css')}}"> 

  <!-- Font Awesome -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    #body {
      /*background-image: url("{{asset('public/img/foto.jpg')}}");*/
    }
    #body:hover{
      -webkit-transform:scale(1.2);transform:scale(1.2);
      overflow:hidden;  
      
    }
    *{
  box-sizing: border-box;
}
 

  </style>
  
</head>
<body class="hold-transition login-page" id="body">

<div class="login-box" style="opacity: 0.9;">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="card border-warning">
    <div class="card-body login-card-body ">
      <img src="{{asset('public/img/inccopy 2.jpg')}}" style="width:90%" alt="AdminLTE Logo" class="d-block mx-auto" style="opacity: .8">
      <br>
     
      <form action="{{action('Auth\LoginController@login')}}" id="app" method="post">
          @if(session()->has('erro'))
          <div class="boton alert alert-danger" role="alert">{{session('erro')}}</div>
          @endif
          {!!$errors->first('error',' <div class="boton alert alert-danger" role="alert">:message</div>')!!}
        {{csrf_field()}}

        <div class="input-group mb-3" id="div_inpute">
          <input id="input_email" v-model="input_email" type="email" name="email" class="form-control" placeholder="Ingresa tu email" value="{{old('email')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3" id="div_inputp">
          <input id="input_password" v-model="input_password" type="password" name="password" class="form-control " placeholder="Ingresa tu password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <button @click="validar($event)" class="btn btn-primary-gobyuc btn-block boton">Acceder</button>
      </form>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('public/vue.js')}}"></script>
<script src="{{asset('public/blank/jquery.min.js')}}"></script>
<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="{{asset('public/blank/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/blank/adminlte.min.js')}}"></script>
<script>
  new Vue({
    el:'#app',
    data:{
      input_email:'',
      input_password:'',
      bandera_pagina:0,
      estado_datos:0,
      message_email:"Porfavor introduce tu correo.",
      message_password:"Porfavor introduce tu password."
    }
    ,methods:{
      validar:function(event) {
              this.estado_datos=1;
              this.bandera_pagina=0;
              if (this.input_email==="") {
                this.bandera_pagina=1;
                var bandera = 0;
                const da = document.getElementById('input_email')
                const de = document.getElementById('div_inpute')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera!=1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
                
              }else{
                var bandera = 0;
                const da = document.getElementById('input_email')
                const de = document.getElementById('div_inpute')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera==1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
              }

              if (this.input_password==="") {
                this.bandera_pagina=1;
                var bandera = 0;
                const da = document.getElementById('input_password')
                const de = document.getElementById('div_inputp')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera!=1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
              }else{
                var bandera = 0;
                const da = document.getElementById('input_password')
                const de = document.getElementById('div_inputp')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera==1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
              }
              
            if (this.bandera_pagina==1) {
                event.preventDefault();
              }
      }
    }
  });
</script>

</body>
</html>