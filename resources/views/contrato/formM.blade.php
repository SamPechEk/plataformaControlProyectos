@extends('plantillas.Blank')

@section('encabezado')
    Registrar un contrato
@endsection

@section('estilosadd')
<link rel="stylesheet" href="{{asset('public/selectFile/styles.css')}}"> 
<link rel="stylesheet" href="{{asset('public/select2/select2.min.css')}}"> 
<link rel="stylesheet" href="{{asset('public/select2/select2-bootstrap4.min.css')}}"> 
<link rel="stylesheet" href="{{asset('public/selectRange/daterangepicker.css')}}"> 

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
    <a v-if="idproyecto!=''" :href="'{{URL::to('/listado/contratos')}}?idproyecto='+idproyecto">Volver</a>
    <a v-if="idproyecto==''" :href="'{{URL::to('/listado/contratos')}}?idproyecto='+'{{$contrato->idproyecto}}'">Volver</a>
    <br>
    <form role="form" enctype="multipart/form-data" action="{{action('ContratoController@save')}}" method="POST">
    {{csrf_field()}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-sec-gobyuc">Datos de l contrato para el proyecto: {{$nombre_p}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName" class="titulos">No. DE CONTRATO</label>
                            <input type="hidden" name="idproyecto" value="{{$idproyecto}}">
                            <input type="hidden" name="idcontrato" value="{{$idcontrato}}">

                            <input type="text" name="numeroc" v-model="input_numeroc" id="input_numeroc" class="form-control letras">
                        </div>

                        <div  class="form-group" id="r1" style="">
                            <label class="form-label titulos" for="">R1</label>
                            <input type="file"
                                    name="documento"
                                    ref="campo"
                                    id="documento" 
                                    @change="cambiar"
                                    class="form-control"
                                    accept="application/pdf, .doc, .docx, .odf, .xlsx, .xls">
                            <div id="dropzone"
                                @dragover="sobre($event)"
                                @dragleave="fuera($event)"
                                @drop="drop($event)"
                                class="dark titulos"
                                :class="clase"
                            >

                            Arastra el archivo o haz click <label class="form-label" id="carga_file" for="documento"><strong> Aqui</strong></label>
                            </div>
                            <div v-show="nombre_archivo!=''">
                                <span class="letras">@{{nombre_archivo}}</span><a class="boton btn-warning letras" @click="remove" href="#">Quitar</a>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="titulos">Inicio</label>
                            <vuejs-datepicker 
                            input-class="form-control"
    
                            id="input_inicio"
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            v-model="input_inicio"
                            NAME="inicio"

                            ></vuejs-datepicker>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Fin</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                            
                            id="input_fin"
                            format="yyyy-MM-dd"
                            clear-button
                            :language="lenguaje"
                            clear-button
                            v-model="input_fin"
                            NAME="fin"
                            ></vuejs-datepicker>
               
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="titulos">Techo financiero</label>

                            <input class="letras" type="text" name="p_total" :value="'$'+((p_total/116)*100).toFixed(2)" disabled="">
                            <input type="hidden" name="p_total" :value="p_total" disabled="">
                            <label for="inputName" class="titulos">IVA 16%</label>
                            <input class="letras" type="text"  :value="'$'+((((p_total/116)*100).toFixed(2))*.16).toFixed(2)" disabled="">
                            <label for="inputName" class="titulos">Total:</label>
                            <input class="letras" type="text"  :value="'$'+p_total" disabled=""><br>

                            <label for="inputName" class="titulos">Importe a contratar:</label>
                            <input  type="number" name="a_contratar" v-model.number="a_contratar" id="a_contratar" max="{{$disponible}}" class="form-control letras">
                            <label for="inputName" class="titulos">IVA 16%</label>
                            <input type="text" disabled="" :value="'$'+(a_contratar*.16).toFixed(2)" class="form-control letras">
                            <label for="inputName" class="titulos">Total:</label>
                            <input type="text" disabled="" :value="'$'+((a_contratar*.16)+a_contratar).toFixed(2)" class="form-control letras">
                            


                        </div>

                        <div class="form-group">
                            <label for="inputName" class="titulos"> Contratista</label>

                            <select class="form-control custom-select letras" v-model="input_contratista" id="input_contratista" name="idcontratista">
                                <option class="form-control custom-select letras" disabled="" selected="selected">Selecciona el contratista</option>
                                <option class="letras" v-for="contratista in contratistas" :value="contratista.idcontratista">@{{contratista.nombre}}</option>
                            </select>


                        </div>

                        <div v-if="estados.formError" class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Aun no!</h5>
                            <span v-for="error in errors">@{{error}} <br></span>
                        </div>
                    </div>
                   

                    <div class="col-12">
                    <a href="{{URL::to('/listado/contratos')}}?idproyecto={{$idproyecto}}" class="btn btn-cancel-gobyuc">Volver</a>
                    <input type="submit" @click="validar_form($event)" value="Generar contrato" class="boton btn btn-primary-gobyuc float-right">
                </div>
                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
               
            </div>
            
            
                
                
        </div>

    </form>
    <br>
    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
@endsection

@section('codigosopcional')
<script src="{{asset('public/select2/select2.full.min.js')}}"></script>
<script src="{{asset('public/datapicker/vuejs-datepicker.min.js')}}"></script>
<script src="{{asset('public/datapicker/es.js')}}"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
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
            idprograma:'',
            idproyecto:'{{$idproyecto}}',
            a_contratar:{{$contrato->monto_contratado}},
            anticipo:0,
            contratistas:<?php echo json_encode($contratistas);?>,
            p_total:{{$presupuesto}},
            input_contratista:'{{$contrato->idcontratista}}',
            input_numeroc:'{{$contrato->n_contrato}}',
            input_inicio:'{{$contrato->inicio}}',
            input_fin:'{{$contrato->fin}}',
            input_monto:'{{$contrato->monto_contratado}}',
            bandera_pagina:0,
            mensaje:'`',
            input_ejecutora:'',
            nombre_archivo:'',
            estados:{
                indirecto:'',
                autorizado:'',
                formError:false
            },
            clase:{
                inactivo:true
                ,conarchivo:false
                ,leave:false
                ,invalido:false
            },
            lenguaje:vdp_translation_es.js
        }
        ,methods:{
            validar_form:function(event){
                this.bandera_pagina=0;
                this.errors=[];
                this.estados.formError=false;
                //input_numeroc
                if (this.input_numeroc==="") {
                    this.errors.push('Porfavor especifica el numero de contrato');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_numeroc')
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
                    const da = document.getElementById('input_numeroc')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_numeroc


                //input_descripcion
                if (this.input_contratista==="") {
                    this.errors.push('Parece que falta el contratista.');

                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_contratista')
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
                    const da = document.getElementById('input_contratista')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_contratista

                //input_status
                if (this.a_contratar==="" || this.a_contratar===0) {
                    this.errors.push('Cual es el monto contratado?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('a_contratar')
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
                    const da = document.getElementById('a_contratar')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //a_contratar

                 //input_tipop
                 if (this.input_inicio==="") {
                    this.errors.push('Cual es la fecha de inicio?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_inicio')
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
                    const da = document.getElementById('input_inicio')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_inicio

                //input_estado
                if (this.input_fin==="") {
                    this.errors.push('Cuando finaliza este contrato?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_fin')
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
                    const da = document.getElementById('input_fin')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_estado
                
                //inputempleosg 

                if (this.bandera_pagina==1) {
                    this.estados.formError=true;
                    event.preventDefault();
                }else{
                    if (!confirm('ENVIAR?')) {
                        event.preventDefault();
                    }
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
                permitidos=/(.doc|.pdf|.docx|.odf|.xls|.xlsx| )$/i;
                ultimo=this.$refs.campo.files.length-1;
                if (!permitidos.exec(path)) {
                    this.clase.leave=true;
                    this.clase.conarchivo=false;
                    this.clase.inactivo=false;
                    this.clase.invalido=true;
                    this.estados.hasError=true;
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
