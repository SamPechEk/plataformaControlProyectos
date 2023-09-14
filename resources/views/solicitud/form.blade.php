@extends('plantillas.Blank')

@section('encabezado')
    Registrar un solicitud
@endsection

@section('estilosadd')
<link rel="stylesheet" href="{{asset('public/selectFile/styles.css')}}"> 
<link rel="stylesheet" href="{{asset('public/select2/select2.min.css')}}"> 
<link rel="stylesheet" href="{{asset('public/select2/select2-bootstrap4.min.css')}}"> 
<link rel="stylesheet" href="{{asset('public/selectRange/daterangepicker.css')}}"> 
<style>
.loader-container{
  position: relative;
  width: 60px;
  height: 60px;
  margin: 10px;
}
 
.loader-container .loader{
  position: absolute;
  top: 50%;
  left: 50%;
  width: 100%;
  height: 100%;
  border: solid 4px transparent;
  border-top-color: #0dac77;
  border-left-color: #0dac77;
  border-radius: 50%;
  animation: loader 1.4s linear infinite;
}
 
.loader-container .loader2{
  position: absolute;
  top: 50%;
  left: 50%;
  width: 70%;
  height: 70%;
  border: solid 4px transparent;
  border-top-color: #283fc3;
  border-left-color: #283fc3;
  border-radius: 50%;
  animation: loader2 1.2s linear infinite;
}
 
@keyframes loader{
  0%{
    transform: translate(-50%, -50%) rotate(0deg);
  }
  100%{
    transform: translate(-50%, -50%) rotate(360deg);
  }
}
 
@keyframes loader2{
  0%{
    transform: translate(-50%, -50%) rotate(0deg);
  }
  100%{
    transform: translate(-50%, -50%) rotate(-360deg);
  }
}
</style>
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
    <br>
    <form role="form" enctype="multipart/form-data" action="{{action('DemoController@save_soli')}}" method="POST">
    {{csrf_field()}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-sec-gobyuc">Solicitud</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName" class="titulos">Nombre</label>
                            <input type="hidden" name="idsolicitud" value="{{$solicitud->idsolicitud}}">
                            <input type="text" name="nombre" v-model="input_nombre" id="input_nombre" class="form-control letras">
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="titulos">Numero de oficio</label>
                            <input type="text" name="noficio" v-model="input_noficio" id="input_noficio" class="form-control letras">
                        </div>
                        <div   class="form-group" id="input_doc">
                        <label class="form-label titulos" for="">Oficio.</label>
                        <input type="file"
                                name="documento"
                                ref="campo"
                                id="documento" 
                                @change="cambiar"
                                class="form-control"
                                accept="application/pdf, .doc, .docx, .odf">
                        <div id="dropzone"
                            @dragover="sobre($event)"
                            @dragleave="fuera($event)"
                            @drop="drop($event)"
                            class="dark titulos"
                            :class="clase"
                        >

                        Coloca el archivo o hacer click <label class="form-label" id="carga_file" for="documento"><strong> Aqui</strong></label>
                        </div>
                        <div v-show="nombre_archivo!=''">
                            <span class="letras">@{{nombre_archivo}}</span><a class="boton" @click="remove" href="#">Quitar</a>
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="inputDescription"  class="titulos">Descripcion de la solicitud</label>
                            <textarea id="input_descripcion" v-model="input_descripcion" name="descripcion" class="form-control letras" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="titulos">Solicitante</label>
                            <input type="text" name="solicitante" v-model="input_solicitante" id="input_solicitante" class="form-control letras">
                        </div>
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label class="titulos">Estado</label>
                                <select disabled="" id="input_estado" v-model="input_estado" name="estado" class="form-control custom-select letras" style="width: 100%;">
                                <option class="letras" v-for="estad in estadosm">@{{estad.estado}}</option>
                                </select>
                                <input type="hidden" name="estado" value="Yucatán"> 
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label class="titulos">Municipio</label>
                                <select @change="filtralLocalidad()" id="input_municipio" name="municipio" v-model="input_municipio" class="form-control custom-select letras" style="width: 100%;">
                                    <option v-for="municipio in municipios" class="letras":value="municipio.municipio">@{{municipio.municipio}} </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div  v-if="estados.load==2" class="loader-container">
                                <div class="loader"></div>
                                <div class="loader2"></div>
                            </div>
                            <div class="form-group">
                                <label class="titulos">Localidad</label>
                                <select id="input_localidad" name="localidad" class="form-control custom-select letras select2" style="width: 100%;">
                                    <option v-for="localidad in localidades"  class="letras" :value="localidad.localidad">@{{localidad.localidad}} </option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label class="titulos">Tipo</label>
                                <select name="tipop" class="form-control custom-select letras" style="width: 100%;"  v-model="input_tipo" id="input_tipop">
                                    <option  class="letras" v-for="tipo in tiposp" :value="tipo.nombre">@{{tipo.nombre}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="titulos">Inversion estimada</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input v-model.number="input_inversion" id="input_inversion" type="number" min="1000" name="inversion" class="letras form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div v-if="estados.formError" class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Aun no!</h5>
                        <span v-for="error in errors">@{{error}} <br></span>
                    </div>
                    <!-- /.card-body -->
                    <input type="submit" @click="validar_form($event)" value="Registrar solicitud" class="boton btn btn-primary-gobyuc float-right">

                </div>
             <!-- /.card -->

            </div>
            
        </div>   
            

    </form>
    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
@endsection

@section('codigosopcional')
<script src="{{asset('public/select2/select2.full.min.js')}}"></script>
<script src="{{asset('public/axios.min.js')}}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
        $('.select3').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })

    })
</script>
    <script>
        new Vue({
        el:'#app',
        data:{
            tiposp:<?php echo json_encode($tiposp);?>,
            estadosm:<?php echo json_encode($estados);?>,
            localidades:[],
            municipios:<?php echo json_encode($municipios);?>,
            input_noficio:'{{$solicitud->n_oficio}}',
            input_tipo:'{{$solicitud->tipo}}',
            input_nombre:'{{$solicitud->nombre}}',
            input_descripcion:'{{$solicitud->descripcion}}',
            input_solicitante:'{{$solicitud->solicitante}}',
            input_estado:'Yucatán',
            input_municipio:'{{$solicitud->municipio}}',
            input_localidad:'{{$solicitud->localidad}}',
            input_inversion:'{{$solicitud->inversion}}',

            bandera_pagina:0,
            mensaje:'`',
            input_tipop:'{{$solicitud->idtipop}}',
            estados:{
                load:0,
                formError:false,
                asociar:true
            },
            clase:{
                inactivo:true
                ,conarchivo:false
                ,leave:false
                ,invalido:false
            }
            ,nombre_archivo:'',
            errors:[],
            otro:''
        }
        ,methods:{
            validar_form:function(event){
                this.bandera_pagina=0;
                this.errors=[];
                this.estados.formError=false;
                //input_nombresolicitud
                if (this.input_nombre==="") {
                    this.errors.push('Porfavor especifica el nombre de la solicitud');
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
                
                //input_nombresolicitud


                //input_descripcion
                if (this.input_descripcion==="") {
                    this.errors.push('Parece que falta la descripcion.');

                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_descripcion')
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
                    const da = document.getElementById('input_descripcion')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_descripcion


                 //input_tipop
                 if (this.input_tipo==="") {
                    this.errors.push('Que tipo de solicitud es?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_tipop')
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
                    const da = document.getElementById('input_tipop')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_tipop

                //input_inversion
                if (this.input_inversion<=0) {
                    this.errors.push('Cual es la inversion estimada?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_inversion')
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
                    const da = document.getElementById('input_inversion')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_inversion

                 //input_solicitante
                 if (this.input_solicitante<=0) {
                    this.errors.push('Quien es el solicitante?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_solicitante')
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
                    const da = document.getElementById('input_solicitante')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_solicitante

                 //input_municipio
                 if (this.input_municipio<=0) {
                    this.errors.push('Especifica el municipio.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_municipio')
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
                    const da = document.getElementById('input_municipio')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_municipio

                 //input_noficio
                 if (this.input_noficio=="") {
                    this.errors.push('Especifica el numero de oficio.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_noficio')
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
                    const da = document.getElementById('input_noficio')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_noficio

                 //input_nombrearchivo
                 if ({{$solicitud->idsolicitud}}=="") {
                    if (this.nombre_archivo=="") {
                    this.errors.push('Porfavor carga el documento.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                      
                    }else{
                        var bandera = 0;
                        const da = document.getElementById('input_nombrearchivo')
                        
                    } 
                }
                 
                
                //input_nombrearchivo
                


                if (this.bandera_pagina==1) {
                    this.estados.formError=true;
                    event.preventDefault();
                }else{
                    if (!confirm('ENVIAR?')) {
                        event.preventDefault();
                    }
                }   

            },
            filtralLocalidad: function () {
                this.localidades=[];
                this.estados.load=2;
                axios.get("{{action('DemoController@localidad')}}?municipio="+this.input_municipio).then(response => {
                    this.localidades=response.data;
                    this.estados.load=0;

                }).catch(e => {
                    console.log(e);
                });
            }
            ,
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
