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
    <form action="{{action('ExxelController@r1')}}" method="POST">
    {{csrf_field()}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-sec-gobyuc">Datos de la R-1 para el proyecto: {{$nombre_p}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="titulos">Tipo de recurso</label>
                            <select name="t_r" class="form-control custom-select letras" style="width: 100%;">
                                <option class="letras" selected="selected" disabled="">Selecciona el tipo de recurso</option>
                                <option  class="letras"  value="Estatal">Estatal</option>
                                <option  class="letras"  value="Federal">Federal</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Clase</label>
                            <select name="clas" class="form-control custom-select letras" style="width: 100%;">
                                <option class="letras" selected="selected" disabled="">Selecciona la clase</option>
                                <option  class="letras"  value="Obra">Obra</option>
                                <option  class="letras"  value="Servicio">Servicio</option>
                                <option  class="letras"  value="Adquisicion">Adquisicion</option>
                                <option  class="letras"  value="Civiles">Civiles</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Modalidad de procedimiento</label>
                            <select name="modalidad_p" class="form-control custom-select letras" style="width: 100%;">
                                <option class="letras" selected="selected" disabled="">Selecciona la modalidad de procedimiento</option>
                                <option  class="letras"  value="LP">Licitacion Publica(LP)</option>
                                <option  class="letras"  value="I3P">Invitacion a 3 personas(I3P)</option>
                                <option  class="letras"  value="AD">Adjudicasion directa(AD)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Modalidad de contratacion</label>
                            <select name="modalidad_c" class="form-control custom-select letras" style="width: 100%;">
                                <option class="letras" selected="selected" disabled="">Selecciona la modalidad de contratacion</option>
                                <option  class="letras"  value="P.U">Precios unitarios(P.U)</option>
                                <option  class="letras"  value="P.A">Precio alzado(P.A)</option>
                            </select>
                            <input type="hidden" name="origen_r" value="{{$origen_r}}">
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="titulos">No. DE CONTRATO</label>
                            <input type="hidden" name="idproyecto" value="{{$idproyecto}}">
                            <input type="hidden" name="idcontrato" value="{{$idcontrato}}">

                            <input type="text" name="numeroc" v-model="input_numeroc" id="input_numeroc" class="form-control letras">
                        </div>

                        <div class="form-group">
                            <label class="titulos">Capital contable</label>
                            <input type="number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="titulos">Costo bases</label>
                            <input type="number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="titulos">Publicacion de la convocatoria.</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="convocatoria"

                            ></vuejs-datepicker>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Limite bases</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="l_base"

                            ></vuejs-datepicker>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Visita sitios trabajo</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="v_sitios"

                            ></vuejs-datepicker>
                            <input type="time" name="h_sitiost">
                        </div>

                        <div class="form-group">
                            <label class="titulos">Junta aclaraciones</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="j_aclaraciones"

                            ></vuejs-datepicker>
                            <input type="time" name="h_aclaraciones">
                        </div>

                        <div class="form-group">
                            <label class="titulos">Apertura de proposiciones</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="a_proposiciones"

                            ></vuejs-datepicker>
                            <input type="time" name="h_proposisiones">

                        </div>

                        <div class="form-group">
                            <label class="titulos">Fallo de apertura</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="fallo_apertura"
                            

                            ></vuejs-datepicker>
                            <input type="time" name="h_fallo">
                        </div>

                        <div class="form-group">
                            <label class="titulos">Fecha del contrato</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="f_contrato"

                            ></vuejs-datepicker>
                        </div>

                        <div class="form-group">
                            <label class="titulos">Fecha de M01</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                
                            id=""
                            format="yyyy-MM-dd"
                            :language="lenguaje"
                            clear-button
                            NAME="M01"

                            ></vuejs-datepicker>
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
                            <label class="titulos">Fecha de entrega del contrato</label>
                            <vuejs-datepicker 
                            input-class="form-control"
                            
                            id=""
                            format="yyyy-MM-dd"
                            clear-button
                            :language="lenguaje"
                            NAME="f_entregac"
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
                            <label for="inputName" class="titulos">Anticipo:</label>
                            <input type="text" name="porcentaje_a" v-model.number="anticipo" id="a_contratar" class="form-control letras">
                            <input type="text" disabled="" :value="'$'+(((((a_contratar*.16)+(a_contratar)))/100)*anticipo).toFixed(2)" class="form-control letras">


                        </div>

                        <div class="form-group">
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
                    <input type="submit" @click="validar_form($event)" value="Generar R-1" class="boton btn btn-primary-gobyuc float-right">
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
            estados:{
                indirecto:'',
                autorizado:'',
                formError:false
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
