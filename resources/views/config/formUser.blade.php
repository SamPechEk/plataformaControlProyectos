@extends('plantillas.Blank')

@section('encabezado')
    Registrar usuario
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
                <a href="{{URL::to('/config/formOptions')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Elementos</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{URL::to('/form/contratista')}}" class="nav-link">
                    <i class="fas fa-arrow-right nav-icon"></i>
                    <p>Un contratista</p>
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
    
    <div >
        <div class="container-fluid">
            <div class="row mb-1">
            <div class="col-sm-6">
                <br>
            </div>
            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title text-sec-gobyuc">@{{mensaje}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" enctype="multipart/form-data" role="form" action="{{action('ConfigController@formRegisterUser')}}" method="POST" >
            {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group">
                        <label class="titulos">Elige su rol</label>
                        <select  id="input_selected" v-model="input_selected" name="selected" class="form-control titulos" > 
                            <option class="titulos" selected="" disabled="">Selecciona una opcion</option>
                            <option v-for="rol in roles" class="letras"  :value="rol.idrol" >@{{rol.nombre}}</option>
                        </select>
                    </div>
                    <div v-if="input_selected!='Selecciona una opcion'"  class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="usuario" v-model="input_nombre" id="input_nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label class="titulos">Autogenerar clave de acceso</label>
                        <input class="letras" v-model="estados.autokey" name="autokey" type="radio" selected=""  value="true"><span class="letras">Si</span> 
                        <input v-model="estados.autokey" type="radio"  name="autokey" value="false" ><span class="letras"> No</span>
                    </div>
                    <div class="input-group mb-3" v-if="(estados.autokey == false) || (estados.autokey == 'false')">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" v-model="input_password" id="input_password" class="form-control" placeholder="clave de acceso">

                    </div>
                    <div v-if="estados.hasError" class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Aun no!</h5>
                        <span v-for="error in errors">@{{error}} <br></span>
                    </div>
                </div>
                
                    <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary-gobyuc boton" @click="validarForm">Registrar usuario</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection

@section('codigosopcional')
    <script>
        new Vue({
        el:'#app',
        data:{
            bandera_pagina:0,
            roles:<?php echo json_encode($rol);?>,
            mensaje:'{{$mensaje}}',
            input_nombre:'',
            input_selected:'Selecciona una opcion',
            input_password:'',
            estados:{
                autokey:true,
                namePrograma:'',
                finalizado:false,
                hasError:false
            },
            nombre_archivo:'',
            errors:[]
        }
        ,methods:{
            validarForm:function(event) {
                this.errors=[];
                this.bandera_pagina=0;

                //input_selected
                if (this.input_selected=="Selecciona una opcion") {
                    this.errors.push('Porfavor selecciona el rol');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_selected')
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
                    const da = document.getElementById('input_selected')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_selected

                //input_nombre
                if (this.input_selected!="Selecciona una opcion") {
                    if (this.input_nombre=="") {
                        this.errors.push('Porfavor introduce el nombre');
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
                }
                
                //input_nombre

                //input_password
                if ((this.estados.autokey==false) || (this.estados.autokey=='false')) {
                    if (this.input_password=="") {
                        this.errors.push('Porfavor proporciona el password');
                        this.bandera_pagina=1;
                        var bandera = 0;
                        const da = document.getElementById('input_password')
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
                        const da = document.getElementById('input_password')
                        for (let i = 0; i <= da.classList.length; i++) {
                            if (da.classList[i]=='is-invalid'){
                                bandera =1;
                            }
                        }
                        if (bandera==1) {
                            da.classList.toggle('is-invalid')
                        } 
                    } 
                }
                
                //input_password


                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('Estas seguro de registrar este usuario?')) {
                        event.preventDefault();
                    }
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
