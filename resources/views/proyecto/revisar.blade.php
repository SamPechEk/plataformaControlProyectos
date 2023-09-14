@extends('plantillas.Blank')

@section('encabezado')
Revisar proyectos
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
                
    <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title text-sec-gobyuc letras">Proyectos por revisar:</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table table-sm m-0 table-hover ">
              <thead>
                  <tr class="table-head-gobyuc">
                    <th></th>
                      <th class="letras">
                          ID
                      </th>
                      <th  class="letras">
                          Nombre del proyecto:
                      </th>
                      <th class="letras">
                          Tipo de proyecto
                      </th>
                      <th  class="letras"h>
                      Programa
                      </th>
                      <th></th>
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
                              Registrado el:  @{{proyecto.registro}} <br> Modificado el:  @{{proyecto.modificasion}}
                          </small>
                      </td>
                      <td class="titulos">
                          @{{proyecto.idtipop}}
                      </td>
                      <td class="titulos">
                          @{{proyecto.idprograma}}
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-cancel-gobyuc btn-sm" :href="formProyectos+'?idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <a class="btn btn-primary-gobyuc btn-sm" :href="documents+'?idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-copy">
                              </i>
                              
                          </a>
                          <a class="btn btn-primary-gobyuc btn-sm"  @click="confirm"  :href="url+'?idproyecto='+proyecto.idproyecto">
                              <i class="fas fa-check">
                              </i>
                              
                          </a>
                          <a v-if="idrol==1" class="btn btn-cancel-gobyuc btn-sm" @click="deletee" :href="url2+'?idproyecto='+proyecto.idproyecto+'&idprograma='+proyecto.idprograma">
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
            url:'{{action('ProyectoController@aprobar')}}',
            url2:'{{action('ProyectoController@delete')}}',
            documents:'{{action('ProyectoController@documents')}}',
            formProyectos:'{{action('ProyectoController@form')}}',
            bandera_pagina:0,
            proyectos:<?php echo json_encode($proyectos);?>,
        }
        ,methods:{
            deletee:function(){
                if (!confirm('Esta seguro de eliminar este proyecto y  todos sus datos?')) {
                        event.preventDefault();
                    }
            },
            confirm:function(){
                //input_doc
                if (!confirm('¿Estas seguro?')) {
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


