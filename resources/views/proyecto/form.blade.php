@extends('plantillas.Blank')

@section('encabezado')
    Registrar un proyecto
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
    <form action="{{action('ProyectoController@save')}}" method="POST">
    {{csrf_field()}}
        <div class="row">
            <div :class="{'col-md-6':{{$proyecto->idproyecto}}!=0,'col-md-12':{{$proyecto->idproyecto}}==0}">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-sec-gobyuc">Datos generales</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName" class="titulos">Nombre del proyecto</label>
                            <input type="hidden" name="idprograma" value="{{$idprograma}}">
                            <input type="hidden" name="idproyecto" value="{{$proyecto->idproyecto}}">
                            <input type="text" name="nombreProyecto" v-model="input_nombreProyecto" id="input_nombreProyecto" class="form-control letras">
                        </div>
                        <div class="form-group">
                            <label class="titulos">Este proyecto ya fue autorizado?</label>
                            <input class="letras" v-model="estados.autorizado" type="radio"  value="true"><span class="letras">Si</span> 
                            <input v-model="estados.autorizado" type="radio"  value="false" ><span class="letras"> No</span>
                        </div>
                        <div class="form-group">
                            <div class="input-group" v-if="estados.autorizado=='true'">
                                <input  type="text" class="form-control letras" v-model="input_clave" name="clave" id="input_clave" placeholder="Cual es la clave de control asignada?">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="titulos">UGI</label>
                            <div class="input-group">
                                <input  type="text" class="form-control letras" v-model="input_ugi" name="ugi" id="input_clave" placeholder="Captura el UGI">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="titulos">UBP</label>

                            <div class="input-group">
                                <input  type="text" class="form-control letras" name="ubp" v-model="input_ubp" id="input_clave" placeholder="Captura el UBP">
                                
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="inputDescription"  class="titulos">Descripcion</label>
                            <textarea id="input_descripcion" v-model="input_descripcion" name="descripcion" class="form-control letras" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus"  class="titulos">Status</label>
                            <select id="input_status" name="status" v-model="input_status" class="custom-select form-control letras">
                                <option selected="" name="status" disabled="">Selecciona el estado del proyecto</option>
                                <option v-for="stat in status" class="letras" :value="stat.idstatus">@{{stat.nombre}}</option>
                            </select>
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
                                <label class="titulos">localidad</label>
                                <select id="input_localidad" name="localidad" class="form-control custom-select letras select2" style="width: 100%;">
                                    <option v-for="localidad in localidades"  class="letras" :value="localidad.localidad">@{{localidad.localidad}} </option>
                                </select>
                            </div>
                        </div>
                        
                       

                        
                        <div class="form-group">
                            <div class="form-group">
                                <label class="titulos">Tipo de proyecto</label>
                                <select name="tipop" class="form-control custom-select letras" style="width: 100%;"  v-model="input_tipop" id="input_tipop">
                                    <option class="letras" selected="selected" disabled="">Selecciona el tipo de proyecto</option>
                                    <option  class="letras" v-for="tipo in tiposp" :value="tipo.idtipop">@{{tipo.nombre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="titulos">Tipo de infraestructura</label>
                                <select name="tipoinfra" class="form-control custom-select letras" style="width: 100%;"  v-model="input_infraestructura" id="input_infraestructura">
                                    <option class="letras" value="Construccion"> Construccion</option>
                                    <option class="letras" value="Mantenimiento"> Mantenimiento</option>
                                    <option class="letras" value="Conservacion"> Conservacion</option>
                                    <option class="letras" value="Rehabilitacion"> Rehabilitacion</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="titulos">Empleos generados</label> 
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+</span>
                                </div> 
                                <input type="text" min="1" name="empleosg" id="input_empleosg" v-model="input_empleosg" class="form-control letras"> 
                                <div class="input-group-append">
                                <span class="input-group-text">Empleos</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Beneficiarios</label> 
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+</span>
                                </div> 
                                <input type="text" min="1" name="beneficiarios" id="input_beneficiarios" v-model="input_beneficiarios" class="form-control letras"> 
                                <div class="input-group-append">
                                <span class="input-group-text">Beneficiarios</span>
                                </div>
                            </div>
                        </div>
                       

                    </div>
            <!-- /.card-body -->
            <input v-if="{{$proyecto->idproyecto}}==0" type="submit" @click="validar_form($event)" value="Registrar proyecto" class="boton btn btn-primary-gobyuc float-right">

                </div>
        <!-- /.card -->

            </div>
            <div class="col-md-6" v-if="{{$proyecto->idproyecto}}!=0">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-sec-gobyuc">Inversion</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label  class="titulos">Total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input v-model.number="presupuesto.propio" id="input_presupuestoTotal" type="text" name="presupuestoTotal[]" class="letras form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <label  class="titulos">Indirecto</label>
                            <div class="input-group">
                                
                                <input v-model.number="presupuesto.indirecto" id="" type="text" name="indirecto[]" class="letras form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                        <br>
                        <!--
                        <div class="form-group">
                            <label class="titulos">Tiene presupuesto indirecto?</label>
                            <input class="letras" v-model="estados.indirecto" type="radio"  value="true"><span class="letras">Si</span> 
                            <input v-model="estados.indirecto" type="radio"  value="false" ><span class="letras"> No</span>
                        </div>
                        <div class="input-group" v-if="estados.indirecto=='true'">
                            <input  type="text" class="form-control letras" name="porcentajeIndirecto" step="0.01" min="1" max="100" id="input_porcentajeIndirecto" v-model.number="presupuesto.porcentaje" placeholder="Cual es el porcentaje?">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="titulos">Directo</label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control letras" disabled="" name="presuspuestoDirecto" :value="(presupuesto.total/1.19)*1.16">
                            <div class="input-group-append">
                                <span class="input-group-text"></span>
                            </div>
                        </div>
                        <div class="form-group" v-if="estados.indirecto=='true'">
                            <label class="titulos">Indirecto</label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control letras" disabled="" name="presupuestoIndirecto" :value="((presupuesto.total-((presupuesto.total/1.19)*(1.16)))/1.19)*(presupuesto.porcentaje)">
                            <div class="input-group-append">
                                <span class="input-group-text"></span>
                            </div>
                            </div>
                        
                        </div>
                        -->
                        <div v-show="estados.asociar" class="form-group">
                            <label class="titulos">Esta asociado a otros programas?</label>
                            <input name="otrop" class="letras" v-model="estados.otrop" type="radio"  value="true"><span class="letras">Si</span> 
                            <input name="otrop" v-model="estados.otrop" type="radio"  value="false" ><span class="letras"> No</span>
                        </div>
                        <div v-if="estados.load==1" class="loader-container">
                            <div class="loader"></div>
                            <div class="loader2"></div>
                        </div>
                        <div v-show="estados.otrop=='true' && estados.asociar">
                            <form action="#" method="get">
                
                                {{csrf_field()}}
                                <input type="hidden" name="idprograma" value="{{$idprograma}}">
                                <input type="hidden" name="idproyecto" value="{{$proyecto->idproyecto}}">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="titulos">A cuales?</label>
                                        <select name="programasaso[]" v-model="programasaso" class="form-control custom-select letras select3" style="width: 100%;" multiple="multiple">
                                            <option class="letras" selected="selected" disabled="">Selecciona con cual se ascocia...</option>
                                            <option  @click="paso('programaaso')"  class="letras" v-for="programa in programas" :value="programa.idprograma">@{{programa.nombre}}</option>
                                        </select>
                                    </div>
                                </div>
                                <input v-if="estados.asociar" type="submit" @click="saveAso($event)" value="Asociar" class="boton btn btn-success float-right">
                            </form>
                        </div>
                        <div v-for="presupuesto in estados.naso" class="form-group">
                            <div v-if="presupuesto.id!=idprograma">
                                <label  class="titulos">Total de  @{{presupuesto.idprograma}}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input v-model.number="presupuesto.total" id="" type="text" name="presupuestoTotal[]" class="letras form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>


                                </div>
                                <br>
                                <label  class="titulos">Indirecto</label>
                                <div class="input-group">
                                    
                                    <input v-model.number="presupuesto.porcentajeindirecto" id="" type="text" name="indirecto[]" class="letras form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
        </div>
        <div v-if="estados.formError" class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Aun no!</h5>
            <span v-for="error in errors">@{{error}} <br></span>
        </div>
        <div class="row">
            <div class="col-12">
                <a :href="'{{URL::to('/listado/proyecto')}}?idprograma='+idprograma" class="btn btn-cancel-gobyuc">Volver</a>
                <input type="submit" @click="validar_form($event)" value="Registrar proyecto" class="boton btn btn-primary-gobyuc float-right">
            </div>
        </div>
            
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
            asos:[],
            tiposp:<?php echo json_encode($tiposp);?>,
            status:<?php echo json_encode($status);?>,
            estadosm:<?php echo json_encode($estados);?>,
            programas:<?php echo json_encode($programas);?>,
            localidades:[],
            municipios:<?php echo json_encode($municipios);?>,
            idprograma:'{{$idprograma}}',
            input_porcentajeIndirecto:'',
            input_nombreProyecto:'{{$proyecto->nombre}}',
            input_descripcion:'{{$proyecto->descripcion}}',
            input_clave:'{{$proyecto->clave}}',
            input_status:'{{$proyecto->idstatus}}',
            input_estado:'Yucatán',
            input_municipio:'{{$proyecto->municipio}}',
            input_localidad:'{{$proyecto->localidad}}',
            input_ugi:'{{$proyecto->n_ugi}}',
            input_ubp:'{{$proyecto->n_ubp}}',
            input_infraestructura:'{{$proyecto->tipo_infra}}',
            bandera_pagina:0,
            mensaje:'`',
            input_ejecutora:'',
            input_empleosg:'{{$proyecto->empleos_g}}',
            input_beneficiarios:'{{$proyecto->beneficiarios}}',
            input_tipop:'{{$proyecto->idtipop}}',
            programasaso:[],
            estados:{
                load:0,
                indirecto:'{{$banderaindirecto}}',
                autorizado:'{{$banderaclave}}',
                formError:false,
                otrop:'{{$banderaaso}}',
                naso:<?php echo json_encode($presupuesto);?>,
                asociar:true
            },
            clase:{
                inactivo:true
                ,conarchivo:false
                ,leave:false
                ,invalido:false
            },
            presupuesto:{
                indirecto:'{{$presupuestoPropio->porcentajeindirecto}}',
                propio:'{{$presupuestoPropio->total}}'
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
                //input_nombreProyecto
                if (this.input_nombreProyecto==="") {
                    this.errors.push('Porfavor especifica el nombre del proyecto');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_nombreProyecto')
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
                    const da = document.getElementById('input_nombreProyecto')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_nombreProyecto


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

                //input_status
                if (this.input_status==="") {
                    this.errors.push('Cual es el status del proyecto?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_status')
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
                    const da = document.getElementById('input_status')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_status

                 //input_tipop
                 if (this.input_tipop==="") {
                    this.errors.push('Que tipo de proyecto es?');
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

                //input_infraestructura
                if (this.input_infraestructura==="") {
                    this.errors.push('Que tipo de proyecto es?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_infraestructura')
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
                    const da = document.getElementById('input_infraestructura')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                
                //input_infraestructura

                //input_estado
                if (this.input_estado==="") {
                    this.errors.push('En que estado se desarolla el proyecto?');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_estado')
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
                    const da = document.getElementById('input_estado')
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
                     
                

                if (this.estados.autorizado=='true') {
                    //input_clave
                    if (this.input_clave==="") {
                        this.errors.push('Ya tienes la clave de autorizacion?');

                        this.bandera_pagina=1;
                        var bandera = 0;
                        const da = document.getElementById('input_clave')
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
                        const da = document.getElementById('input_clave')
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
               
                
                //inputempleosg
                if (this.input_empleosg<=0 || isNaN(this.input_empleosg) || this.input_empleosg=='') {
                        this.errors.push('Porfavor captura el total estimado de empleos a generar.');
                        this.bandera_pagina=1;
                        var bandera = 0;
                        const da = document.getElementById('input_empleosg')
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
                        const da = document.getElementById('input_empleosg')
                        for (let i = 0; i <= da.classList.length; i++) {
                            if (da.classList[i]=='is-invalid'){
                                bandera =1;
                            }
                        }
                        if (bandera==1) {
                            da.classList.toggle('is-invalid')
                        } 
                    } 
                
                //inputempleosg 

                //inputbeneficiarios
                if (this.input_beneficiarios<=0 || isNaN(this.input_beneficiarios) || this.input_beneficiarios=='') {
                        this.errors.push('Porfavor captura el total estimado de empleos a generar.');
                        this.bandera_pagina=1;
                        var bandera = 0;
                        const da = document.getElementById('input_beneficiarios')
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
                        const da = document.getElementById('input_beneficiarios')
                        for (let i = 0; i <= da.classList.length; i++) {
                            if (da.classList[i]=='is-invalid'){
                                bandera =1;
                            }
                        }
                        if (bandera==1) {
                            da.classList.toggle('is-invalid')
                        } 
                    } 
                
                //inputbeneficiarios

                //inputbeneficiarios
                if (this.input_municipio=='') {
                        this.errors.push('Porfavor captura el municipio.');
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
                
                //inputbeneficiarios

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
            },
            saveAso: function (e) {
                e.preventDefault();
                this.estados.load=1;

                let post = {
                    idproyecto: '{{$proyecto->idproyecto}}',
                    programasaso: $(".select3").select2('val')
                };
                axios.post("{{action('ProyectoController@savePXP')}}",post).then(response => {
                    this.estados.naso=response.data;
                    this.estados.asociar=false;
                    this.estados.load=0;

                }).catch(e => {
                    console.log(e);
                });
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
