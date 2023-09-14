@extends('plantillas.Blank')

@section('encabezado')
Detalles del proyecto
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
                    <span class="info-box-text text-center text-muted"><span class="letras">Presupuesto:</span>   </span>
                    <span class="info-box-number text-center text-muted mb-0 letras"><span class="titulos">$ @{{proyecto.idpresupuesto}}</span>  </span>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Disponible:</span> </span>
                    <span class="info-box-text text-center text-muted mb-0"><span class="titulos">$ @{{proyecto.disponible}}</span></span>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Municipio:</span>   </span>
                    <span class="info-box-number text-center text-muted mb-0 letras"><span class="titulos">@{{proyecto.municipio}}</span>  </span>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Localidad:</span>   </span>
                    <span class="info-box-number text-center text-muted mb-0 letras"><span class="titulos">@{{proyecto.localidad}}</span>  </span>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Tipo de proyecto:</span>  </span>
                    <span class="info-box-text text-center text-muted mb-0"><span class="titulos">@{{proyecto.idtipop}}</span> </span>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><span class="letras">Empleos generados:</span> </span>
                    <span class="info-box-text text-center text-muted mb-0"><span class="titulos">@{{proyecto.empleos_g}}</span></span>
                </div>
                <a :href="'{{URL::to('/listado/proyecto')}}?idprograma='+proyecto.idprograma" class="">Volver</a>

            </div>
            
        </div>
    
    
        <!-- /.card-body -->
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title letras text-sec-gobyuc" >Contratos del proyecto: @{{proyecto.nombre}}</h3>

          <div v-if="typeof(proyecto.idproyecto)!='undefined'" class="card-tools">
            <a v-if="idrol!=3" :href="'{{action('ContratoController@form')}}?idproyecto='+proyecto.idproyecto+'&captura=manual'"><i class="fas fa-plus"></i>Generar contrato</a>
            <a v-if="idrol!=3" :href="'{{action('ContratoController@form')}}?idproyecto='+proyecto.idproyecto+'&captura=auto'"><i class="fas fa-plus"></i>Generar R-1</a>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table table-sm m-0 table-hover ">
              <thead>
                  <tr class="table-head-gobyuc">
                      <th class="letras">
                          ID
                      </th>
                      <th  class="letras">
                          Numero de contrato
                      </th>
                      
                      <th class="letras">
                          Monto
                      </th>
                      <th class="letras ">Contratista</th>
                      <th class="letras ">Inicio</th>
                      <th class="letras ">Fin</th>
                      <th class="letras">Plazo</th>

                      <th class="right letras"> 
                      Acciones
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="contrato in contratos">
                      <td class="titulos">
                          @{{contrato.idcontrato}}
                      </td>
                      <td>
                          <a>
                          @{{contrato.n_contrato}}
                          </a>
                          <br>
                          <small class="titulos">
                              Registrado el:  @{{contrato.registro}}
                          </small>
                      </td>
                      <td class="project-state">
                          <span class="letras" >$@{{contrato.monto_contratado}}</span>
                      </td>
                      <td class="project-state">
                          <span class="letras" > @{{contrato.idcontratista}}</span>
                      </td>
                      <td class="project-state">
                          <span class="letras" > @{{contrato.inicio}}</span>
                      </td>
                      <td class="project-state">
                          <span class="letras" > @{{contrato.fin}}</span>
                      </td>
                      <td class="project-state">
                          <span class="letras" > @{{contrato.plazo}} dias naturales.</span>
                      </td>
                    
                      <td class="project-actions text-right">
                          <a  v-if="idrol!=3" class="btn btn-cancel-gobyuc btn-sm" @click="deletee" :href="url+'?idcontrato='+contrato.idcontrato+'&idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-trash">
                              </i>
                              
                          </a>
                          <a v-if="idrol!=3 && contrato.carga=='Auto'" class="btn btn-cancel-gobyuc btn-sm" :href="formContratos+'?idcontrato='+contrato.idcontrato+'&captura=auto'">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <a v-if="idrol!=3 && contrato.carga=='manual'" class="btn btn-cancel-gobyuc btn-sm" :href="formContratos+'?idcontrato='+contrato.idcontrato+'&captura=manual'">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <a class="btn btn-primary-gobyuc btn-sm" :href="'{{URL::to('/ver')}}/'+contrato.r1" target="_blank">
                              <i class="fas fa-eye">
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
            url:'{{action('ContratoController@delete')}}',
            formContratos:'{{action('ContratoController@form')}}',
            bandera_pagina:0,
            proyecto:<?php echo json_encode($proyecto);?>,
            contratos:<?php echo json_encode($contratos);?>,
            mensaje:'{{$mensaje}}',
            estados:{
                subirDoc:false,
                subirDoc1:false
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


