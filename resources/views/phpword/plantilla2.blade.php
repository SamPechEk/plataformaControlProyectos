@extends('plantillas.Blank')

@section('encabezado')
    Plantilla1
@endsection

@section('estilosadd')
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
                <h3 class="card-title text-sec-gobyuc">Vamos a generar el Oficio de solicitud de recursos FAFEF, porfavor captura los datos a continuacion:</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" enctype="multipart/form-data" role="form" action="{{action('WordController@plantilla2')}}" method="POST" >
            {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group">
                        <label class="titulos">Numero de oficio:</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <input type="text" name="input_noficio"  id="input_noficio" class="form-control letras" data-inputmask='"mask": "9999/9999"' data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    
                        
                    <div class="form-group">
                        <label for="input_obra" class="titulos">Nombre de la obra</label>
                        <input type="text" class="form-control letras" name="nombre" v-model="input_obra" id="input_obra" placeholder="Ingresa el nombre de la obra...">
                    </div>

                    <div class="form-group">
                        <label for="input_obra" class="titulos">UGI</label>
                        <input type="text" class="form-control letras" name="ugi" v-model="input_ugi" id="input_ugi" >
                    </div>

                    <div class="form-group">
                        <label for="input_obra" class="titulos">UBP</label>
                        <input type="text" class="form-control letras" name="ubp" v-model="input_ubp" id="input_ubp" >
                    </div>

                    <div class="form-group">
                        <label for="input_obra" class="titulos">Presupuesto</label>
                        <input type="text" class="form-control letras" name="presupuesto" v-model="input_presupuesto" id="input_presupuesto" >
                    </div>
                    
                    <div class="form-group">
                        <label for="input_ccosto" class="titulos">Centro de costo</label>
                        <input type="text" class="form-control letras" name="costo" v-model="input_ccosto" id="input_ccosto" placeholder="Ingresa el centro de costo...">
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label class="titulos">CCP</label>
                            <select id="input_estado" name="ccp[]" class="form-control letras select2bs4" multiple="multiple" style="width: 100%;">
                                <option v-for="contact in contactos" :value="contact.idcontacto">@{{contact.nombre}}-@{{contact.cargo}}</option>
                            </select>
                            <input type="hidden" name="estado" value="Yucatán"> 
                        </div>
                    </div>
                   
                    <div v-if="estados.hasError" class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Aun no!</h5>
                        <span v-for="error in errors">@{{error}} <br></span>
                    </div>
                </div>
                
                    <!-- /.card-body -->
                <div  class="card-footer">
                    <button type="submit" class="btn btn-primary-gobyuc boton" @click="validarForm">Descargar</button>
                    <a :href="'{{URL::to('/listado/documentos')}}?idproyecto='+proyecto.idproyecto" class="btn btn-cancel-gobyuc boton">Volver</a>
                </div>
            </form>
        </div>
    </div>
    
@endsection

@section('codigosopcional')
<script src="{{asset('public/inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{asset('public/select2/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('[data-mask]').inputmask()
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
            proyecto:<?php echo json_encode($proyecto);?>,
            contactos:<?php echo json_encode($contactos);?>,
            bandera_pagina:0,
            mensaje:'',
            input_ccosto:'4000.4156.7.18.1',
            input_obra:'{{$proyecto->nombre}}',
            input_noficio:'',
            input_ubp:'{{$proyecto->n_ubp}}',
            input_ugi:'{{$proyecto->n_ugi}}',
            input_presupuesto:'{{$proyecto->idpresupuesto}}',
            estados:{
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

                //input_obra
                if (this.input_obra==="") {
                    this.errors.push('Porfavor introduce el nombre de la obra.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_obra')
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
                    const da = document.getElementById('input_obra')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_obra

                 

                 //input_ccosto
                 if (this.input_ccosto==="") {
                    this.errors.push('Porfavor introduce el centro de costo.');
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_ccosto')
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
                    const da = document.getElementById('input_ccosto')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 
                //input_ccosto


                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('El documento se generara de forma temporal, si algo sale mal puedes repetir el proceso de nuevo.')) {
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
