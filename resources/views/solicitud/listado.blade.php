@extends('plantillas.Blank')
@section('encabezado')
Solicitudes
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
      <div id="buscador" class="card card-primary card-outline">
        <div  class="col-md-12 col-xs-12 col-sm-12">
          <form action="{{action('ExxelController@reporte_soli')}}" method="POST">
          {{csrf_field()}}
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title letras text-sec-gobyuc">Filtrar</h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label class="titulos">Tipo</label>
                  <select name="filtro_tipo" class="form-control letras" v-model="filtro_tipo"> 
                    <option v-for="tip in tipos" :value="tip">@{{tip}}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="titulos">Localidad</label>
                  <select name="filtro_localidad" class="form-control letras" v-model="filtro_localidad"> 
                    <option v-for="localidad in localidades" :value="localidad">@{{localidad}}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="titulos">Municipio</label>
                  <select name="filtro_municipio" class="form-control letras" v-model="filtro_municipio"> 
                    <option v-for="muni in municipios" :value="muni">@{{muni}}</option>
                  </select>
                </div>
              </div>
            </div>
            <button class="btn btn-primary-gobyuc boton"><i class="fas fa-file-excel"></i>Descargar registros</button>
          </form>
          <br>
          <table class="table table table-sm m-0 table-hover">
            <thead>
            <tr class="table-head-gobyuc">
              <th class="letras">ID solicitud</th>
              <th class="letras">Nombre</th>
              <th class="letras">N. Oficio</th>
              <th class="letras">Descripcion</th>
              <th class="letras">Tipo</th>
              <th class="letras">Localidad</th>
              <th class="letras">Municipio</th>
              <th class="letras">Solicitante</th>
              <th class="letras">Inversion</th>
              <th class="letras">Registro</th>

              <th><a href="{{action('DemoController@form_soli')}}">Registro nuevo</a></th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="elemento in registros_final">
              <td class="titulos"><a :href="'{{action('DemoController@form_soli')}}?idsolicitud='+elemento.idsolicitud">@{{elemento.idsolicitud}}</a></td>
              <td  class="titulos">@{{elemento.nombre}}</td>
              <td  class="titulos"><a :href="'{{URL::to('/ver_soli')}}/'+elemento.doc" target="_blank">
              @{{elemento.n_oficio}}</a></td>
              <td  class="titulos">@{{elemento.descripcion}}</td>
              <td  class="titulos">@{{elemento.tipo}}</td>
              <td  class="titulos">@{{elemento.localidad}}</td>
              <td  class="titulos">@{{elemento.municipio}}</td>
              <td  class="titulos">@{{elemento.solicitante}}</td>
              <td  class="titulos">$@{{elemento.inversion}}</td>
              <td  class="titulos">@{{elemento.registro | formato_fecha}}</td>
              <td class="letras"><a :href="'{{action('ExxelController@reporte_soli')}}?idsolicitud='+elemento.idsolicitud"><i class="fas fa-file-excel"></i></a></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br>
@endsection
@section('codigosopcional')
    <script>  
      new Vue({
        el:'#buscador',
        data:{
          registros:<?php echo json_encode($registros);?>
          ,filtro_tipo:'Todos'
          ,filtro_localidad:'Todos',
           filtro_municipio:'Todos'
          ,tipos:[]
          ,localidades:[]
          ,municipios:[]
          
         

        }
        ,methods:{
          borrar:function(){
            this.registros_final.splice(0,this.registros_final.length);

          }
          ,filtrar_basico:function(){
            this.filtro_tipo='Basico';
            
          }
          ,filtrar:function(){
            this.borrar();
            for(i=0;i<this.registros.length;i++){
              bandera=false;
              if(this.filtro_tipo=='Todos')
                bandera=true;
              else{
                if(this.filtro_tipo==this.registros[i].tipo)
                  bandera=true;
              }
              if(bandera){
                this.registros_final.push(this.registros[i]);
              }
            }
          }
        }
        ,computed:{
          registros_final:function(){
            lista=[];
            
            self=this;
            lista=this.registros.filter(function(item){
              bandera_tipo=false;
              bandera_localidad=false;
              bandera_municipio=false;
              if(self.filtro_tipo=='Todos')
               bandera_tipo=true;
             else{
               if(self.filtro_tipo==item.tipo)
                 bandera_tipo=true;
             }

             if(self.filtro_localidad=='Todos')
               bandera_localidad=true;
             else{
               if(self.filtro_localidad==item.localidad)
                 bandera_localidad=true;
             }

             if(self.filtro_municipio=='Todos')
               bandera_municipio=true;
             else{
               if(self.filtro_municipio==item.municipio)
                 bandera_municipio=true;
             }


             return bandera_tipo&&bandera_localidad&&bandera_municipio;
            })
            return lista;
          }
        }
        ,created(){
          this.tipos.push('Todos');
          this.localidades.push('Todos');
          this.municipios.push('Todos');
          for(i=0;i<this.registros.length;i++){
            if(this.tipos.indexOf(this.registros[i].tipo)==-1){
              this.tipos.push(this.registros[i].tipo)
            }
            if(this.localidades.indexOf(this.registros[i].localidad)==-1){
              this.localidades.push(this.registros[i].localidad)
            }
            if(this.municipios.indexOf(this.registros[i].municipio)==-1){
              this.municipios.push(this.registros[i].municipio)
            }
          }
        },filters:{
          formato_fecha:function(registro){
            datos=registro.split('-');
            anio=datos[0];
            mes=datos[1];
            dia=datos[2];
            switch (mes) {
              case '01':
                mes='enero';
              break;
              case '02':
                mes='febrero';
              break;
              case '03':
                mes='marzo';
              break;
              case '04':
                mes='abril';
              break;
              case '05':
                mes='mayo';
              break;
              case '06':
                mes='junio';
              break;
              case '07':
                mes='julio';
              break;
              case '08':
                mes='agosto';
              break;
              case '09':
                mes='septiembre';
              break;
              case '10':
                mes='octubre';
              break;
              case '11':
                mes='noviembre';
              break;
              case '12':
                mes='diciembre';
              break;
              
            }
            cadena_fecha=dia+" de "+mes+" del "+anio;
            return cadena_fecha;
          }
          
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
