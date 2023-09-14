@extends('plantillas.Blank')

@section('encabezado')
Listado de programas registrados
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
        <div class="container">
            
            <div class="card card-primary card-outline">
              <div class="card-header border-transparent">
                <h3 class="text-sec-gobyuc card-title letras">@{{mensaje}}</h3>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-sm table-hover m-0">
                    <thead>
                    <tr class="table-head-gobyuc">
                        <th></th>
                      <th class="letras">ID</th>
                      <th class="letras">Nombre</th>
                      <th class="letras">Ejecutora</th>
                      <th class="letras">Documento</th>
                      <th class="letras">Monto total</th>
                      <th class="letras">Proyectos</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="programa in programas">
                    <td class="letras">@{{programa.orden}}</td>
                        <td><a :href="linkProyectos+'?idprograma='+programa.idprograma" class='titulos'>@{{programa.idprograma}}</a></td>
                        <td class="titulos">@{{programa.nombre}}</td>
                        <td class="titulos">@{{programa.idejecutora}}</td>
                        <td>
                            <span v-if="programa.doc_pdf==''" class="badge badge-danger">Pendiente</span>
                            <span v-else="" class="badge badge-success"><a class="letras" :href="'{{URL::to('/ver')}}/'+programa.doc_pdf" target="_blank">Ver</a></span>
                        </td>
                        <td class="titulos">$ @{{programa.total}}</td>
                        <td class="titulos">@{{programa.tl_proyectos}}</td>
                        <td  v-if="idrol!=3"> 
                            <a class="btn btn-cancel-gobyuc btn-sm" @click="deletee" :href="url+'?idprograma='+programa.idprograma">
                              <i class="fas fa-trash">
                              </i>
                          </a>

                          <a class="btn btn-primary-gobyuc btn-sm" :href="formPrograma+'?idprograma='+programa.idprograma">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                        </td>
                    </tr>
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div  v-if="idrol!=3" class="card-footer clearfix">
                <a href="{{action('ProgramaController@form')}}" class="btn btn-sm btn-primary-gobyuc float-left">Registrar nuevo</a>
              </div>
              <!-- /.card-footer -->
            </div>
        </div>
@endsection

@section('codigosopcional')
    <script>
        new Vue({
        el:'#app',
        data:{
            idrol:{{auth()->user()->idrol}},
            url:'{{action('ProgramaController@delete')}}',
            formPrograma:'{{action('ProgramaController@edit')}}',
            bandera_pagina:0,
            programas:<?php echo json_encode($programa);?>,
            mensaje:'{{$mensaje}}',
            nombre_archivo:'',
            errors:[],
            linkProyectos:'{{action('ProgramaController@listadoProyecto')}}'
        }
        ,methods:{
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
            },
            deletee:function(){
                if (!confirm('Esta seguro de eliminar este proyecto y  todos sus datos?')) {
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