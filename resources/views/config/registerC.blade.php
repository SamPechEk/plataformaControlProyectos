@extends('plantillas.Blank')

@section('encabezado')
    Registrar elementos
@endsection

@section('estilosadd')

@endsection 

@section('opciones')
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="permisos">

    <li class="nav-item has-treeview" v-if="idrol==1" class="nav-item dropdown">
        <a href="javascript:void(0);" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Registrar<i class="right fas fa-angle-left"></i></p> </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{action('ConfigController@formRegisterUser')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Un usuario</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{URL::to('/config/formOptions')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Elementos</p>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="nav-item has-treeview" class="nav-item dropdown">
        <a href="javascript:void(0);" class="nav-link">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>Planeacion<i class="right fas fa-angle-left"></i></p> </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{action('ProgramaController@listado')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Todos los programas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('ProgramaController@listadoProyecto')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Todos los proyectos</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('ProyectoController@listadoContratos')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Todos los contratos</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('DemoController@listado_soli')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Solicitudes</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item has-treeview" v-if="idrol==1 ||idrol==2" class="nav-item dropdown">
        <a href="javascript:void(0);" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Plantillas<i class="right fas fa-angle-left"></i></p> </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{action('WordController@form')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Oficio de rec.</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('WordController@form2')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Anexo 1</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item has-treeview" class="nav-item dropdown">
        <a href="{{action('BuscadorController@buscar')}}" class="nav-link">
            <i class="nav-icon fas fa-search"></i>
            <p>Buscador<i class="right fas fa-angle-right"></i></p> </a>
    </li>
    
    
</ul>
@endsection

@section('contenido')
 <br>   
<div class="card card-outline card-primary">
    <div class="card-header">
    <h3 class="card-title text-sec-gobyuc">Datos del contratista</h3>
    </div>
        <form role="form" method="POST" action="{{action('ConfigController@registerC')}}">
        {{csrf_field()}}

            <div class="card-body">
                <div class="form-group">
                    <label class="" for="">Nombre del contratista</label>
                    <input type="text" class="form-control" name="nombre"  id="input_nombre" v-model="input_nombre" placeholder="Ingresa el nombre del contratista...">
                </div>
                <div class="form-group">
                    <label for="">Nombre del contacto</label>
                    <input type="text" class="form-control" name="ncontacto" id="input_ncontacto" v-model="input_ncontacto" placeholder="Ingresa el nombre de la persona a contactar...">
                </div>
                <div class="form-group">
                    <label for="">RFC</label>
                    <input type="text" class="form-control" name="rfc" id="input_rfc" v-model="input_rfc" placeholder="Ingresa el RFC...">
                </div>
                <div class="form-group">
                    <label for="">Correo</label>
                    <input type="email" class="form-control" name="correo" id="input_correo" v-model="input_correo" placeholder="Ingresa el correo de contacto...">
                </div>
                <div class="form-group">
                    <label for="">Numero</label>
                    <input type="" class="form-control" name="telefono" id="input_telefono" v-model="input_telefono" placeholder="Ingresa el telefono de contacto...">
                </div>   
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" @click="validarForm($event)" class="btn btn-primary-gobyuc">Registrar</button>
            </div>
        </form>
    </div>
    
@endsection

@section('codigosopcional')
    <script>
        new Vue({
        el:'#app',
        data:{
            bandera_pagina:0,
            mensaje:'',
            input_nombre:'',
            input_selected:'Selecciona una opcion',
            estados:{
                namePrograma:'',
                finalizado:false,
                hasError:false
            },
            input_nombre:'',
            input_ncontacto:'',
            input_correo:'',
            input_rfc:'',
            input_telefono:'',
            nombre_archivo:'',
            errors:[]
        }
        ,methods:{
            validarForm:function(event) {
                this.errors=[];
                this.bandera_pagina=0;

                //input_nombre
                if (this.input_nombre==="") {
                    this.errors.push('Porfavor introduce el nombre.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_nombre')
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
                    const da = document.getElementById('input_nombre')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_nombre

                //input_ncontacto
                if (this.input_ncontacto==="") {
                    this.errors.push('Porfavor introduce el contacto.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_ncontacto')
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
                    const da = document.getElementById('input_ncontacto')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_ncontacto

                //input_correo
                if (this.input_correo==="") {
                    this.errors.push('Porfavor introduce el correo.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_correo')
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
                    const da = document.getElementById('input_correo')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_correo


                //input_numero
                if (this.input_telefono==="") {
                    this.errors.push('Porfavor introduce el telefono.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_telefono')
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
                    const da = document.getElementById('input_telefono')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_telefono

                //input_rfc
                if (this.input_rfc==="") {
                    this.errors.push('Porfavor introduce el rfc.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_rfc')
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
                    const da = document.getElementById('input_rfc')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_rfc


                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('Estas seguro de registrar esta opcion?')) {
                        event.preventDefault();
                    }
                }   
                        
            },
            paso:function(paso){
                this.estados.finalizado=true;
                switch (this.input_selected) {
                    case 'eje_gasto':
                        this.mensaje='Porfavor introduce el nombre de la nueva ejecutora.';
                    break;
                    case 'ffinanciera':
                        this.mensaje='Porfavor introduce el nombre de la nueva fuente financiera.';
                    break;
                    case 'status':
                        this.mensaje='Porfavor introduce el nuevo status.';
                    break;
                    case 'tiposp':
                        this.mensaje='Porfavor introduce el nuevo tipo de proyecto';
                    break;
                    default:
                        break;
                }
                    
            }
        },
        components:{
            
        }
        });
    </script>
    <script>
        new Vue({
        el:'#permisos',
        data:{
            idrol:{{auth()->user()->idrol}}
        }
        ,methods:{
            
        },
        components:{
            
        }
        });
    </script>
@endsection
