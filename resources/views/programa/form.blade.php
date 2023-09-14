@extends('plantillas.Blank')

@section('encabezado')
    Registrar un programa
@endsection

@section('estilosadd')
<link rel="stylesheet" href="{{asset('public/selectFile/styles.css')}}"> 
<link rel="stylesheet" href="{{asset('public/select2/select2.min.css')}}"> 
<link rel="stylesheet" href="{{asset('public/select2/select2-bootstrap4.min.css')}}"> 

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
            <div class="text-sec-gobyuc card-header">
                <h3 class="card-title">@{{mensaje}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" enctype="multipart/form-data" role="form" action="{{action('ProgramaController@save')}}" method="POST" >
            {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group">
                        <label class="titulos">Identificador del programa</label>
                        <input id="input_nombrePrograma" @change="paso('ejecutora')"  name="nombrePrograma" v-model="input_nombrePrograma" type="text" class="form-control letras"  placeholder="Cual es el nombre del programa.">
                        <br>
                        <div class="form-group">
                            <label class="titulos">Ejercicio Presuspuestal</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                            minimum-view="year"     
                            id=""
                            format="yyyy"
                            :language="lenguaje"
                            clear-button
                            NAME="ciclo"

                            ></vuejs-datepicker>
                        </div>
                    </div>
                    <div  v-if="input_nombrePrograma!=''" class="form-group">
                        <label class="titulos">Es propio?</label>
                        <input class="letras" v-model="estados.propio" type="radio"  value="true" @change="paso('propio')"><span class="letras">Si</span> 
                        <input v-model="estados.propio" type="radio"  value="false" @change="paso('nopropio')"><span class="letras"> No</span>
                    </div>

                    <div v-if="!estados.propio || estados.propio=='false'" class="form-group">
                        <label class="titulos">Ejecutora del gasto</label>
                        <select  @change="paso('cargar')"  id="input_ejecutora" v-model="input_ejecutora" name="idejecutora" class="form-control titulos" > 
                            <option class="titulos" selected="" disabled="">Selecciona una opcion</option>
                            <option class="letras" v-for="elemento in ejecutoras"  :value="elemento.idejecutora" >@{{elemento.nombre}}</option>  
                        </select>
                    </div>

                    <div  v-if="(estados.propio=='true'&&input_nombrePrograma!='') ||(estados.propio=='false'&&input_ejecutora!='')" class="form-group">
                        <label class="titulos">Deseas subir el documento?</label>
                        <input class="letras" v-model="estados.checkDoc" type="radio"  value="true" @change="paso('condoc')"><span class="letras">Si</span> 
                        <input v-model="estados.checkDoc" type="radio"  value="false" @change="paso('sindoc')"><span class="letras"> No</span>
                    </div>
                        
                    <div v-if="estados.checkDoc=='true'"  class="form-group" id="input_doc">
                        <label class="form-label titulos" for="">Documento</label>
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

                        favor de colocar el archivo o hacer click <label class="form-label" id="carga_file" for="documento"><strong> Aqui</strong></label>
                        </div>
                        <div v-show="nombre_archivo!=''">
                            <span class="letras">@{{nombre_archivo}}</span><a class="boton" @click="remove" href="#">Quitar</a>
                        </div>
                    </div>

                    <div  v-if="((input_nombrePrograma!='')&&(estados.checkDoc=='false'))||((input_nombrePrograma!='')&&(estados.checkDoc=='true')&&(nombre_archivo!=''))" class="form-group">
                        <label class="titulos">Numero de proyectos</label>
                        <input id="input_totalProyectos" min="1"  name="totalProyectos"  @change="paso('Dn')" v-model.number="input_totalProyectos" type="number" class="letras form-control"  placeholder="Inserta la cantidad de proyectos a registrar para este programa.">
                    </div>

                    <div v-if="input_totalProyectos!=0"  v-for="i in input_totalProyectos" class="form-group">
                        <label class="titulos">Nombre del proyecto @{{i}}</label>
                        <input id="input_lProyectoS"  name="proyectos[]" type="text"  @change="paso('rProyect')"  class="form-control letras"  placeholder="cual es el nombre del proyecto">
                    </div>

                    

                    <div v-if="estados.acept" class="form-group">
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
    <script src="{{asset('public/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('public/datapicker/vuejs-datepicker.min.js')}}"></script>
    <script src="{{asset('public/datapicker/es.js')}}"></script>
    <script>
    $(function () {
        
        $('.select2').select2()

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
            bandera_pagina:0,
            ejecutoras:<?php echo json_encode($ejecutora);?>,
            financieras:<?php echo json_encode($financiera);?>,
            mensaje:'{{$mensaje}}',
            input_nombrePrograma:'',
            input_totalProyectos:'',
            input_ejecutora:'',
            estados:{
                onlyfont:'true',
                countfont:0,
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
            errors:[],
            lenguaje:vdp_translation_es.js
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
                    if (!confirm('¿estas seguro de registrar este programa?')) {
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
            vuejsDatepicker
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
