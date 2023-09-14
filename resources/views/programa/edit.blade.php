@extends('plantillas.Blank')

@section('encabezado')
    Registrar un programa
@endsection

@section('estilosadd')
<link rel="stylesheet" href="{{asset('public/selectFile/styles.css')}}"> 

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
            <form role="form" enctype="multipart/form-data" role="form" action="{{action('ProgramaController@save')}}" method="POST" >
                {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group">
                        <label class="titulos">Identificador del programa</label>
                        <input   name="nombrePrograma" v-model="input_nombrePrograma" type="text" class="form-control letras"  placeholder="Cual es el nombre del programa.">
                        <input type="hidden" name="idprograma" value="{{$programa->idprograma}}">
                    </div>

                    <div  class="form-group">
                        <label class="titulos">Ejecutora del gasto</label>
                        <select  id="input_ejecutora" v-model="input_ejecutora" name="idejecutora" class="form-control titulos" > 
                            <option class="titulos" selected="" disabled="">Selecciona una opcion</option>
                            <option class="letras" v-for="elemento in ejecutoras"  :value="elemento.idejecutora" >@{{elemento.nombre}}</option>  
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" true-value='true' false-value='false' v-model="estados.finalizado" id="finalizado">
                        <label for="finalizado" class="letras">He capturado los datos correctamente.</label>
                    </div>
                   
                    <div v-if="estados.hasError" class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Aun no!</h5>
                        <span v-for="error in errors">@{{error}} <br></span>
                    </div>
                </div>
                
                    <!-- /.card-body -->
                <div v-if="estados.finalizado=='true'" class="card-footer">
                    <button type="submit" class="btn btn-primary-gobyuc boton" @click="validarForm">Verificar y guardar</button>
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
            ejecutoras:<?php echo json_encode($ejecutora);?>,
            mensaje:'{{$mensaje}}',
            input_nombrePrograma:'{{$programa->nombre}}',
            input_totalProyectos:'',
            input_ejecutora:'{{$programa->idejecutora}}',
            estados:{
                namePrograma:'',
                checkDoc:'',
                finalizado:'',
                acept:false,
                hasError:false,
                propio:'true'
            },
            clase:{
                inactivo:true
                ,conarchivo:false
                ,leave:false
                ,invalido:false
            }
            ,nombre_archivo:'',
            errors:[]
        }
        ,methods:{
            validarForm:function(event) {
                this.errors=[];
                this.bandera_pagina=0;

                //input_nombrePrograma
                if (this.input_nombrePrograma==="") {
                    this.errors.push('Parece que borraste por error el nombre del proyecto.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_nombrePrograma')
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
                    const da = document.getElementById('input_nombrePrograma')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_nombrePrograma

                //input_doc
                if (this.estados.checkDoc=='true') {
                    if (this.nombre_archivo==="") {
                        this.errors.push('Seleccionaste que deseas subir el archivo pero no lo has cargado.');
                        this.bandera_pagina=1;
                        var bandera = 0;
                        const da = document.getElementById('input_doc')
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
                        const da = document.getElementById('input_doc')
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
                //input_doc

                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('estas seguro de registrar este proyecto?')) {
                        event.preventDefault();
                    }
                }   
                        
            },
            paso:function(paso){
                if (paso=='quit') {
                    this.mensaje='Eliminaste el documento, carga uno nuevo o solo continua con el registro.';
                }
                if (paso=='sindoc') {
                    this.mensaje='Ahora captura la cantidad de proyectos a registrar, recuerda que puedes cargar el documento del programa en cualquier momento.';
                }
                if (paso=='condoc') {
                    this.mensaje='Perfecto, ahora elige el documento, recuerda que este puede ser .pdf o .doc.';
                }
               
                if (paso=='rProyect') {
                    this.mensaje='Perfecto, ahora puedes guardar los datos.';
                    this.estados.acept=true;
                }
                if (paso=='Dn') {
                    this.mensaje='Por favor verifica que el numero de proyectos a registrar sea correcto.';
                }
                if (paso=='ejecutora') {
                    this.mensaje='Ahora seleciona una opcion...';
                }
                if (paso=='cargar') {
                    this.mensaje='Indica si deseas cargar el documento ahora..';
                }
                
                
                    
            },
            remove:function(){
                this.mensaje='Eliminaste el documento, carga uno nuevo o solo continua con el registro marcando la opcion de no cargar documento.';
                this.$refs.campo.value='';
                this.nombre_archivo='';
                this.clase.leave=false;
                this.clase.inactivo=true;
            },
            cambiar:function(){
                inputFile=document.getElementById('documento');
                path=inputFile.value;
                permitidos=/(.doc|.pdf|.docx|.odf| )$/i;
                ultimo=this.$refs.campo.files.length-1;
                if (!permitidos.exec(path)) {
                    this.clase.leave=true;
                    this.clase.conarchivo=false;
                    this.clase.inactivo=false;
                    this.clase.invalido=true;
                    this.estados.hasError=true;
                    this.errors.push('El archivo que elegiste tiene un formato invalido, porfavor vuelve a intentar y asegurate que sea .doc o .pdf.');
                    this.mensaje='El archivo que elegiste tiene un formato invalido, porfavor vuelve a intentar y asegurate que sea .doc o .pdf.';
                    inputFile.value='';
                }else{
                    this.estados.hasError=false;
                    this.mensaje='Ahora captura la cantidad de proyectos a registrar.';
                    this.nombre_archivo=this.$refs.campo.files[ultimo].name;
                    this.clase.leave=true;
                    this.clase.invalido=false;
                }
                
                
            
            }
            ,sobre:function(event){
                event.preventDefault();
                this.clase.leave=true;
                this.clase.conarchivo=false;
                this.clase.inactivo=false;
                this.clase.invalido=false;
            
            }
            ,fuera:function(event){
                event.preventDefault();
                this.clase.leave=false;
                this.clase.conarchivo=false;
                this.clase.inactivo=true;
                this.clase.invalido=false;
            
            }
            ,drop:function(event){
                this.$refs.campo.files=event.dataTransfer.files;
                this.clase.leave=false;
                this.clase.conarchivo=true;
                this.clase.inactivo=false;
                this.clase.invalido=false;
                event.preventDefault();
                this.cambiar();
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
