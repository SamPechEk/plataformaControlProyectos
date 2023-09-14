@extends('plantillas.Blank')

@section('encabezado')
Documentos del proyecto
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
<br>
    <div v-if="!Array.isArray(proyecto)" class="row">
        <div class="col-12 " :class="{'col-sm-12':proyecto.doc_pdf!='','col-sm-8':proyecto.doc_pdf==''}" >
            <div class="info-box darkb">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Nombre del proyecto:</span>  </span>
                    <span class="info-box-number text-center text-muted mb-0"><span class="titulos">@{{proyecto.nombre}}</span> </span>
                </div>  
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Descripcion:</span>  </span>
                    <span class="info-box-number text-center text-muted mb-0"><span class="titulos">@{{proyecto.descripcion}}</span> </span>
                </div> 
                <div class="info-box-content">
                    <a v-if="idrol!=3 && !estados.view" href="#" v-if="!estados.view" class="btn btn-primary-gobyuc" @click="paso('asignar')">Asignar documentos</a>
                    <form v-if="estados.view" method="POST" action="{{action('ProyectoController@saveAsig')}}">
                    {{csrf_field()}}
                        <div  class="form-group">
                            <div v-for="doc in documentos" class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="hidden" name="idproyecto" :value="proyecto.idproyecto">
                                <input type="checkbox" :name="doc.idtipod" :checked="doc.asig" class="custom-control-input" :id="doc.acronimo">
                                <label class="custom-control-label letras" :for="doc.acronimo">@{{doc.acronimo}}</label>
                            </div>
                        </div>
                    <button class="btn btn-sm btn-primary-gobyuc boton">Asignar</button>
                    <button class="btn btn-sm btn-cancel-gobyuc boton" @click="paso('cancelar')">Cancelar</button>
                  </form>
                </div> 
            </div>
        </div>
 <!-- /.card-body -->
    </div>
    <a :href="'{{URL::to('/listado/proyecto')}}?idprograma='+proyecto.idprograma">Volver</a>
    <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title letras text-sec-gobyuc">Documentos del proyecto: @{{proyecto.nombre}}</h3>
          <a v-if="'{{$zip}}'=='true'" class="btn btn-primary-gobyuc btn-sm" :href="'{{URL::to('/zip')}}?idproyecto='+proyecto.idproyecto" >
                <i class="fas fa-cloud-download-alt">
                </i>
                
            </a>
          <br>
          <form v-if="modifiProyect" role="form" enctype="multipart/form-data" role="form" action="{{action('ProgramaController@cargarAfter')}}" method="POST" >
                {{csrf_field()}}
                <input type="hidden" name="idproyecto" :value="proyecto.idproyecto">
                <input type="hidden" name="idtipod" :value="idtipod">
                    
                <div  class="form-group" id="input_ubp" style="">
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

                    Arastra el archivo o haz click <label class="form-label" id="carga_file" for="documento"><strong> Aqui</strong></label>
                    </div>
                    <div v-show="nombre_archivo!=''">
                        <span class="letras">@{{nombre_archivo}}</span><a class="boton btn-warning letras" @click="remove" href="#">Quitar</a>
                    </div>
                </div>
                    <button type="submit" @click="validar($event)" class="btn btn-primary-gobyuc boton" >Guardar</button> 
                    <button  class="btn btn-cancel-gobyuc boton" @click="cambiarA($event,0)">Cancelar</button>
            </form>

         
        </div>
        <div class="card-body p-0">
          <table class="table table table-sm m-0 table-hover ">
              <thead>
                  <tr class="table-head-gobyuc">
                     
                      <th  class="letras">
                          Nombre del documento
                      </th>
                      
                      <th class="letras right">
                          Estado
                      </th>
                      <th class="right letras"> 
                        Acciones
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="asig in docsasig">
                      <td>
                          <a>
                          @{{asig.acronimo}}
                          </a>
                          <br>
                          <small class="titulos">
                             @{{asig.nombre_completo}}
                          </small>
                      </td>
                      
                      <td >
                          <span class="badge" :class="{' badge-danger':asig.estado=='Pendiente',' badge-success':asig.estado=='Cargado'}" >@{{asig.estado}}</span>
                      </td>
                      <td>
                          <a v-if="asig.estado=='Cargado'" class="btn btn-cancel-gobyuc btn-sm" :href="'{{URL::to('/ver')}}/'+asig.nombredoc" target="_blank">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
                          <a v-if="asig.estado=='Cargado'" class="btn btn-cancel-gobyuc btn-sm" :href="'{{URL::to('/download')}}/'+asig.nombredoc" >
                              <i class="fas fa-cloud-download-alt">
                              </i>
                              
                          </a>
                          <a v-if="idrol!=3" class="btn btn-primary-gobyuc btn-sm" href="#" @click="cambiarA($event,asig.idtipod)">
                            <i class="fas fa-file-upload"></i>
                              
                          </a>
                          <a v-if="asig.forma_cap=='Auto' && asig.acronimo=='Sol de Vo. Bo' && idrol!=3" class="btn btn-primary-gobyuc btn-sm" :href="'{{URL::to('/form_documento1')}}?idproyecto='+proyecto.idproyecto">
                            <i class="fas fa-file-word"></i>
                              
                          </a>
                          <a v-if="asig.forma_cap=='Auto' && asig.acronimo=='Oficio de rec.' && idrol!=3" class="btn btn-primary-gobyuc btn-sm" :href="'{{URL::to('/form_documento2')}}?idproyecto='+proyecto.idproyecto">
                            <i class="fas fa-file-word"></i>
                              
                          </a>
                      </td>
                      
                  </tr>
                 
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
@endsection

@section('codigosopcional')
    <script>
        new Vue({
        el:'#app',
        data:{
            idrol:{{auth()->user()->idrol}},
            formProyectos:'{{action('ProyectoController@form')}}',
            idtipod:0,
            bandera_pagina:0,
            proyecto:<?php echo json_encode($proyecto);?>,
            documentos:<?php echo json_encode($documentos);?>,
            docsasig:<?php echo json_encode($doc_asig);?>,
            mensaje:'{{$mensaje}}',
            estados:{
                view:false
            },
            nombre_archivo:'',
            modifiProyect:false,
            clase:{
                inactivo:true
                ,conarchivo:false
                ,leave:false
                ,invalido:false
            }
        }
        ,methods:{
            paso:function(paso){
                if (paso=='asignar') {
                    this.estados.view=true;
                }
                if (paso=='cancelar') {
                    this.estados.view=false;
                    event.preventDefault();
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
            },
            cambiarA:function($event,idtipod){    
                this.idtipod = idtipod;
                if (this.idtipod == 0) {
                    event.preventDefault();
                }
                if (this.modifiProyect && idtipod==0) {
                    this.modifiProyect=false;
                }else{
                    this.modifiProyect=true;
                }
                    
            },
            validar:function($event){
                //input_doc
                this.bandera_pagina=0;
                if (this.nombre_archivo==="") {
                    
                    this.bandera_pagina=1;
                    
                } 

                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('Esta seguro de cargar este archivo?')) {
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


