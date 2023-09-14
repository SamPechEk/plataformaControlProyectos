@extends('plantillas.Blank')

@section('encabezado')
Detalles del programa
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
    <li class="nav-item has-treeview" v-if="idrol==1 &&{{$revisar}}!=0" class="nav-item dropdown">
        <a href="{{action('ProyectoController@revisar')}}" class="nav-link">
            <i class="nav-icon fas fa-exclamation-circle"></i>
            <p>{{$revisar}} por revisar<i class="right fas fa-angle-right"></i></p> </a>
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
    
    <div v-if="!Array.isArray(programa)" class="row">
        <div class="col-12 " :class="{'col-sm-12':programa.doc_pdf!='','col-sm-8':programa.doc_pdf=='' && idrol!=3}" >
            <div class="info-box  darkb">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">ID del programa:</span>   </span>
                    <span class="info-box-number text-center text-muted mb-0 letras"><span class="titulos">@{{programa.idprograma}}</span>  </span>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Nombre del programa:</span>  </span>
                    <span class="info-box-text text-center text-muted mb-0"><span class="titulos">@{{programa.nombre}}</span> </span>
                </div>
                <div class="info-box-content" v-if="programa.doc_pdf!=''">
                    <span class="info-box-text text-center text-muted"><span class="letras">Entidad ejecutora:</span> </span>
                    <span class="info-box-text text-center text-muted mb-0"><span class="titulos">@{{programa.idejecutora}}</span></span>
                </div>
                <div class="info-box-content" v-if="programa.doc_pdf!=''">
                    <span class="info-box-text text-center text-muted"><span class="letras">Documento:</span> </span>
                    <span class="info-box-text text-center text-muted mb-0">
                        <a :href="'{{URL::to('/ver')}}/'+programa.doc_pdf" class="btn btn-primary-gobyuc btn-sm" target="_blank"><i class="fas fa-eye"></i></a>
                        <a :href="'{{URL::to('/download')}}/'+programa.doc_pdf" class="btn btn-primary-gobyuc btn-sm "><i class="fas fa-cloud-download-alt"></i></a>
                        <a href="#" class="btn btn-cancel-gobyuc btn-sm " @click="paso('editar_pdf')"><i class="fas fa-pencil-alt"></i></a>
                    </span>
                </div>


                
            </div>
            
        </div>

        
        
        <div class="col-12 col-sm-4" v-if="programa.doc_pdf=='' && idrol!=3">
            <div v-if="estados.subirDoc" class="info-box alert alert-dismissible dark">
                <button type="button" @click="paso('closeForm')" class="close letras" data-dismiss="alert" aria-hidden="true" >×</button>
                <form role="form" enctype="multipart/form-data" role="form" action="{{action('ProgramaController@cargarAfter')}}" method="POST" >
                {{csrf_field()}}
                <input type="hidden" name="idprograma" :value="programa.idprograma">
                    <div  class="form-group" id="input_doc" style="">
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

                        Arastra el archivo o haz <label class="form-label" id="carga_file" for="documento"><strong> Aqui</strong></label>
                        </div>
                        <div v-show="nombre_archivo!=''">
                            <span class="letras">@{{nombre_archivo}}</span><a class="boton btn-warning letras" @click="remove" href="#">Quitar</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary-gobyuc boton" @click="validar">Guardar</button>
                </form>
                   
            </div>
            <div v-if="!estados.subirDoc && idrol!=3" class="info-box bg-danger boton">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-warning" ><span style="color:white;" class="letras"><i class="icon fas fa-ban a"></i>Aun falta cargar el documento</span></span>
                   
                    <span class="info-box-text text-center text-warning"> Fecha limite: @{{programa.fechaL}}</span>
                    <span class="info-box-number text-center text-muted mb-0">
                        <span >
                            <a @click="paso('subirDoc')" href="#" class="text-success"><i class="fas fa-arrow-up"></i> Cargar ahora</a>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div v-if="estados.msg" class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title letras text-sec-gobyuc">Comentarios</h3>

        <div class="card-tools">
            <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">@{{comentario.length}}</span>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
            </button>
            </button>
            <button type="button" class="btn btn-tool" @click="paso('noMsg')"><i class="fas fa-times"></i>
            </button>
        </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages">
            <!-- Message to the right -->
            <div v-for="c in comentario" class="direct-chat-msg right">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right letras text-sec-gobyuc">@{{c.nombre}}</span>
                    <span class="direct-chat-timestamp float-left letras">@{{c.registro}}</span>
                </div>
                <!-- /.direct-chat-infos -->
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text dark">
                   @{{c.comentario}}
                   <span data-toggle="tooltip" class="badge letras" :class="{'bg-danger': c.status=='Activo' , 'bg-success':c.status!='Activo'}">@{{c.status}}</span>
                   <form action="{{action('ProgramaController@changeComent')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="idprograma" :value="c.idprograma">
                        <input type="hidden" name="idcomentario" :value="c.idcomentariop">
                        <button class="btn btn-sm btn-primary-gobyuc boton" type="submit" v-if="(idusuario == c.idusuario) && (c.status=='Activo')" @click="confirm()">Finalizar</button>
                   </form>
                </div>
            <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->

        </div>
        <!--/.direct-chat-messages-->

        <!-- Contacts are loaded here -->
        
        <!-- /.direct-chat-pane -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        <form v-if="idrol!=3" action="{{action('ProgramaController@saveComent')}}" method="POST">
        {{csrf_field()}}
            <div class="input-group">
            <input type="text" id="input_comentario" v-model="input_comentario" name="comentario" placeholder="Escribe tu comentario ..." class="form-control">
            <input type="hidden" name="idprograma" :value="programa.idprograma">
            <span class="input-group-append">
                <button  type="submit" class="btn btn-primary-gobyuc" @click="validarC">Dejar comentario</button>
            </span>
            </div>
        </form>
        </div>
        <!-- /.card-footer-->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title letras text-sec-gobyuc">Proyectos del programa: @{{programa.nombre}}</h3>

          <div v-if="typeof(programa.idprograma)!='undefined'" class="card-tools">
            <a href="#" @click="paso('verMsg')"><i class="fas fa-comments">@{{comentario.length}}</i></a> 
            <a v-if="idrol!=3" :href="formProyectos+'?idprograma='+programa.idprograma"><i class="fas fa-plus"></i>Agregar</a>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table  table-hover projects">
              <thead>
                  <tr class="table-head-gobyuc">
                    <th></th>
                      <th class="letras">
                          ID
                      </th>
                      <th  class="letras">
                          Nombre del proyecto:
                      </th>
                      <th  class="letras">
                         Presupuesto:
                      </th>
                      <th class="letras">
                          Progreso del proyecto:
                      </th>
                      <th class="letras text-center">
                          Estado:
                      </th>
                      <th class="right letras"> 
                      Acciones
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="proyecto in proyectos">
                    <td class="letras"> @{{proyecto.orden}}</td>
                      <td class="titulos">
                          @{{proyecto.idproyecto}}
                      </td>
                      <td>
                          <a>
                          @{{proyecto.nombre}}
                          </a>
                          <br>
                          <small class="titulos">
                              Registrado el:  @{{proyecto.registro}}
                          </small>
                      </td>
                      <td >
                       
                        <br>
                        <small class='titulos' v-for="presu in proyecto.presupuesto">@{{presu.idprograma}} $@{{presu.total}} <br></small> 
                        <small class='titulos'>Este proyecto tiene definido un presupuesto total de <strong>$@{{proyecto.idpresupuesto}}</strong></small> 
                      </td>
                      <td v-if="idmodifiProyect!=proyecto.idproyecto" class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-volumenow="1" aria-volumemin="0" aria-volumemax="100" :style="'width:'+proyecto.avance+'%'">
                              </div>
                          </div>
                          <small class="titulos">
                             @{{proyecto.avance}}% Completado  
                          </small>
                      </td>
                     
                      <td class="project-state">
                          <span class="badge badge-success" :class="{'badge-info' : proyecto.idstatus!='Pendiente','badge-danger' : proyecto.idstatus=='Pendiente'}">@{{proyecto.idstatus}}</span>
                      </td>
                      <td class="project-actions text-right">
                          <a v-if="proyecto.idpresupuesto!=0" class="btn btn-primary-gobyuc btn-sm" :href="url+'?idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
                          <a v-if="idrol!=3" class="btn btn-cancel-gobyuc btn-sm" :href="formProyectos+'?idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <a class="btn btn-primary-gobyuc btn-sm" :href="documents+'?idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-copy">
                              </i>
                              
                          </a>
                          <a v-if="idrol!=3" class="btn btn-cancel-gobyuc btn-sm" @click="deletee" :href="url2+'?idproyecto='+proyecto.idproyecto+'&idprograma='+proyecto.idprograma">
                              <i class="fas fa-trash">
                              </i>
                              
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
            idusuario:'{{auth()->user()->idusuario}}',
            url:'{{action('ProyectoController@listadoContratos')}}',
            url2:'{{action('ProyectoController@delete')}}',
            documents:'{{action('ProyectoController@documents')}}',
            formProyectos:'{{action('ProyectoController@form')}}',
            input_comentario:'',
            bandera_pagina:0,
            programa:<?php echo json_encode($programa);?>,
            comentario:<?php echo json_encode($comentarios);?>,
            proyectos:<?php echo json_encode($proyectos);?>,
            mensaje:'{{$mensaje}}',
            input_avance:0,
            estados:{
                subirDoc:false,
                msg:false,
                doc:''
            },
            nombre_archivo:'',
            modifiProyect:false,
            idmodifiProyect:0,
            clase:{
                inactivo:true
                ,conarchivo:false
                ,leave:false
                ,invalido:false
                ,edit:false
            }
        }
        ,methods:{
            paso:function(paso){
                if (paso=='subirDoc') {
                    this.estados.subirDoc=true;
                }
                if (paso=='closeForm') {
                    this.estados.subirDoc=false;
                    if (this.estados.edit) {
                        this.programa.doc_pdf=this.estados.doc;
                    }
                }
                if (paso=='verMsg') {
                    this.estados.msg=true;
                }
                if (paso=='noMsg') {
                    this.estados.msg=false;
                }

                if (paso=='editar_pdf') {
                    this.estados.doc= this.programa.doc_pdf;
                    this.programa.doc_pdf="";
                    this.estados.subirDoc=true;
                    this.estados.edit=true;

                }

            },
            deletee:function(){
                if (!confirm('Esta seguro de eliminar este proyecto y  todos sus datos?')) {
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
           cambiarA:function($event,input,avance){
                if (this.modifiProyect==false) {
                    this.modifiProyect=true;
                    this.idmodifiProyect=input;
                    this.input_avance=avance;
                }
                this.modifiProyect=false;
                
            },
            validar:function(){
                //input_doc
                this.bandera_pagina=0;
                if (this.nombre_archivo==="") {
                    
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

                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('¿Estas seguro de cargar este archivo?')) {
                        event.preventDefault();
                    }
                } 
                
            },
            validarC:function(){
                this.bandera_pagina=0;
                //input_doc
                if (this.input_comentario==="") {
                    
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_comentario')
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
                    const da = document.getElementById('input_comentario')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                            bandera =1;
                        }
                    }
                    if (bandera==1) {
                        da.classList.toggle('is-invalid')
                    } 
                } 

                if (this.bandera_pagina==1) {
                    this.estados.hasError=true;
                    event.preventDefault();
                }else{
                    this.estados.hasError=false;
                    if (!confirm('¿Esta seguro de cargar este comentario?')) {
                        event.preventDefault();
                    }
                } 
                
            },
            confirm:function(){
                //input_doc
                if (!confirm('¿Estas seguro de haber resuelto este comentario?')) {
                    event.preventDefault();
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


