@extends('plantillas.Blank')
@section('encabezado')
Buscador
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
   
    
    
</ul>
@endsection
@section('contenido')
<br>

    <div class="container card card-outline card-primary">

      <div class="row">
        <div class="col-md-12">
          <form action="{{action('BuscadorController@buscar')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
              <br>
              <input type="text" name="var" value="{{$var}}" placeholder="Escribe el nombre del proyecto, programa, N.Contrato, N.UGI, N.UBP, ejecutora, ..." class="form-control"></input>
            </div>
            <button class="btn btn-primary-gobyuc boton">Buscar</button>
          </form>
        </div>
      </div>

      <div id="buscador" class="card-body">

        <div v-if="registros.length!=0" class="col-md-12 col-xs-12 col-sm-12">
          <form v-if="vista=='normal'" action="{{action('ExxelController@reporte')}}" method="POST">
          {{csrf_field()}}
            <input type="hidden" name="var" value="{{$var}}">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title letras">Busqueda Rapida</h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label class="titulos">Tipo de proyecto</label>
                  <select name="filtro_tipo" class="form-control letras" v-model="filtro_tipo"> 
                    <option v-for="tip in tipos" :value="tip">@{{tip}}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="titulos">Ejecutora</label>
                  <select name="filtro_ejecutora" class="form-control letras" v-model="filtro_ejecutora"> 
                    <option v-for="ejecutora in ejecutoras" :value="ejecutora">@{{ejecutora}}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="titulos">Programa</label>
                  <select name="filtro_programa" class="form-control letras" v-model="filtro_programa"> 
                    <option v-for="progra in programas" :value="progra">@{{progra}}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="titulos">Infraestructura</label>
                  <select name="filtro_infraestructura" class="form-control letras" v-model="filtro_infraestructura"> 
                    <option v-for="infra in infraestructuras" :value="infra">@{{infra}}</option>
                  </select>
                </div>
              </div>
            </div>
            <button class="btn btn-primary-gobyuc boton"><i class="fas fa-file-excel"></i>Generar reporte de la busqueda</button>
          </form>
          <br v-if="vista=='normal'">
          <button @click="cambiar_v('grafica')" class="btn btn-primary-gobyuc boton" v-if="vista=='normal'"><i class="fas fa-chart-line"></i>Ver solo por graficas</button>
          <br>
          <button @click="cambiar_v('normal')"  class="btn btn-primary-gobyuc boton" v-if="vista!='normal'"><i class="fas fa-search"></i>Mostrar registros</button>
          <h1 class="letras text-sec-gobyuc">Resultados de la busqueda</h1>
          <div class="table-responsive">
            <table class="table table-sm table-hover" v-if="vista=='normal'">
              <thead>
                <tr class="table-head-gobyuc">
                  <th class="letras">ID Proyecto</th>
                  <th class="letras">Nombre</th>
                  <th class="letras">Programa</th>
                  <th class="letras">Tipo de proyecto</th>
                  <th class="letras">Infraestructura</th>
                  <th class="letras">Ejecutora</th>
                  <th class="letras">N.Contrato</th>
                  <th class="letras">N.UGI</th>
                  <th class="letras">N.UBP</th>
                  <th class="letras">Avance</th>
                  <th class="letras">Registro</th>
                  <th></th>

                </tr>
              </thead>
              <tbody>
              <tr v-for="elemento in registros_final">
                <td class="titulos">@{{elemento.idproyecto}}</td>
                <td  class="titulos">@{{elemento.nombre}}</td>
                <td  class="titulos">@{{elemento.programa}}</td>
                <td  class="titulos">@{{elemento.tipop}}</td>
                <td  class="titulos">@{{elemento.tipo_infra}}</td>
                <td  class="titulos">@{{elemento.ejecutora}}</td>
                <td  class="titulos">@{{elemento.n_contrato}}</td>
                <td  class="titulos">@{{elemento.n_ugi}}</td>
                <td  class="titulos">@{{elemento.n_ubp}}</td>
                <td  class="titulos">@{{elemento.avance}}%</td>
                <td  class="titulos">@{{elemento.registrop | formato_fecha}}</td>
                <td class="letras"><a :href="'{{action('ExxelController@reporte')}}?idproyecto='+elemento.idproyecto"><i class="fas fa-file-excel"></i></a></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

        <select v-if="vista!='normal'" class="form-control">
          <option @click="definirg('avance')">Por avance</option>
          <option @click="definirg('municipio')">Por municipio</option>
          <option @click="definirg('tipo')">Por tipo de proyecto</option>
          <option @click="definirg('ejecutora')">Por ejecutora</option>
          <option @click="definirg('infra')">Por infraestructura</option>
        </select>
        <canvas v-show="vista!='normal'" id="myChart" style="width:100%;max-width:600px"></canvas>
        <br>
        <a v-show="vista!='normal'" id="download">
          <input type="button" class="btn-primary-gobyuc btn" value="Descargar" @click="descargarimg()">
        </a>

      </div>

    </div>

    <br>
@endsection
@section('codigosopcional')
  <script src="{{asset('public/chart.min.js')}}"></script>

  
    

  
   

    <script>  
      new Vue({
        el:'#buscador',
        data:{
          registros:<?php echo json_encode($registros);?>
          ,filtro_tipo:'Todos'
          ,filtro_ejecutora:'Todos',
           filtro_programa:'Todos',
           filtro_infraestructura:'Todos'
          ,tipos:[]
          ,ejecutoras:[]
          ,programas:[],
          infraestructuras:[],
          vista:'normal'
          
         

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
                if(this.filtro_tipo==this.registros[i].tipop)
                  bandera=true;
              }
              if(bandera){
                this.registros_final.push(this.registros[i]);
              }
            }
          },
          cambiar_v:function(vista){
            if (vista=='normal') {
              this.vista='normal';
            }
            if (vista=='grafica') {
              this.vista='grafica';
             
            }
            
          },
          
          descargarimg:function(){
            console.log('hey');
            var canvas = document.getElementById("myChart");

            var filename = prompt("Guardar como...","Nombre del archivo");
            if (canvas.msToBlob){ //para internet explorer
                var blob = canvas.msToBlob();
                window.navigator.msSaveBlob(blob, filename + ".png" );// la extensión de preferencia pon jpg o png
            } else {
                link = document.getElementById("download");
                //Otros navegadores: Google chrome, Firefox etc...
                link.href = canvas.toDataURL("image/png");// Extensión .png ("image/png") --- Extension .jpg ("image/jpeg")
                link.download = filename;
            }

            
          },
          definirg:function(por){
            var barColors = ["red", "green","blue","orange","brown"];
            if (por=='avance') {
              var xValues = ['-50%','+50%','100%'];
              
              var mas=0;
              var menos=0;
              var listo=0;
              for (let index = 0; index < this.registros_final.length; index++) {
                if (this.registros_final[index].avance<=50) {
                  menos++;
                }
                if (this.registros_final[index].avance>=50) {
                  mas++;
                }
                if (this.registros_final[index].avance==100) {
                  listo++;
                }
              }
              var yValues = [menos,mas,listo];
              yValues.push(this);
             

              new Chart("myChart", {
                type: "bar",
                data: {
                  labels: xValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                  }]
                },
                options: {
                  legend: {display: false},
                  title: {
                    display: true,
                    text: "Numero de proyectos segun su avance"
                  }
                }
              });
            }

            if (por=='municipio') {
              xValues=[];
              yValues=[];
              var muni =[];
              for (let index = 0; index < this.registros_final.length; index++) {
                
                
                var bandera = false;
                for (let i = 0; i < muni.length; i++) {
                  if (muni[i]==this.registros_final[index].municipio) {
                    bandera=true;
                    
                  }
               
                }
                if (!bandera) {
                  muni.push(this.registros_final[index].municipio);
                }
              }
              var total=[];
              for (let i = 0; i < muni.length; i++) {
                total.push(0);
              }
              
              
              for (let index = 0; index < this.registros_final.length; index++) {
                for (let i = 0; i < muni.length; i++) {
                  if (muni[i]==this.registros_final[index].municipio) {
                    total[i]++;
                  }
               
                }
              }

              for (let i = 0; i < muni.length; i++) {
                xValues.push(muni[i]);
                yValues.push(total[i]);
              }
              
              new Chart("myChart", {
                type: "pie",
                data: {
                  labels: xValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: "Proyectos por municipio"
                  }
                }
              });
            }

            if (por=='ejecutora') {
              xValues=this.ejecutoras;
              console.log(xValues);
              yValues=[];
              var total=[];
              for (let i = 0; i < xValues.length; i++) {
                total.push(0);
              }
              for (let index = 0; index < this.registros_final.length; index++) {
                for (let i = 0; i < xValues.length; i++) {
                  if (xValues[i]==this.registros_final[index].ejecutora) {
                    total[i]++;
                  }
               
                }
              }

              yValues=total;
              
              
              new Chart("myChart", {
                type: "pie",
                data: {
                  labels: xValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: "Proyectos por ejecutora"
                  }
                }
              });
            }


            if (por=='tipo') {
              xValues=this.tipos;
              yValues=[];
              var total=[];
              for (let i = 0; i < xValues.length; i++) {
                total.push(0);
              }
              for (let index = 0; index < this.registros_final.length; index++) {
                for (let i = 0; i < xValues.length; i++) {
                  if (xValues[i]==this.registros_final[index].tipop) {
                    total[i]++;
                  }
               
                }
              }

              yValues=total;
              
              
              new Chart("myChart", {
                type: "pie",
                data: {
                  labels: xValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: "Proyectos por tipo"
                  }
                }
              });
            }

            if (por=='infra') {
              xValues=this.infraestructuras;
              yValues=[];
              var total=[];
              for (let i = 0; i < xValues.length; i++) {
                total.push(0);
              }
              for (let index = 0; index < this.registros_final.length; index++) {
                for (let i = 0; i < xValues.length; i++) {
                  if (xValues[i]==this.registros_final[index].tipo_infra) {
                    total[i]++;
                  }
               
                }
              }

              yValues=total;
              
              
              new Chart("myChart", {
                type: "pie",
                data: {
                  labels: xValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: "Proyectos por infraestructura"
                  }
                }
              });
            }
              
          }
        }
        ,computed:{
          registros_final:function(){
            lista=[];
            
            self=this;
            lista=this.registros.filter(function(item){
              bandera_tipo=false;
              bandera_ejecutora=false;
              bandera_programa=false;
              bandera_infra=false;
              if(self.filtro_tipo=='Todos')
               bandera_tipo=true;
             else{
               if(self.filtro_tipo==item.tipop)
                 bandera_tipo=true;
             }

             if(self.filtro_ejecutora=='Todos')
               bandera_ejecutora=true;
             else{
               if(self.filtro_ejecutora==item.ejecutora)
                 bandera_ejecutora=true;
             }

             if(self.filtro_programa=='Todos')
               bandera_programa=true;
             else{
               if(self.filtro_programa==item.programa)
                 bandera_programa=true;
             }
             if(self.filtro_infraestructura=='Todos')
               bandera_infra=true;
             else{
               if(self.filtro_infraestructura==item.tipo_infra)
                 bandera_infra=true;
             }


             return bandera_tipo&&bandera_ejecutora&&bandera_programa&&bandera_infra;
            })
            return lista;
          }
        }
        ,created(){
          this.tipos.push('Todos');
          this.ejecutoras.push('Todos');
          this.programas.push('Todos');
          this.infraestructuras.push('Todos');
          for(i=0;i<this.registros.length;i++){
            if(this.tipos.indexOf(this.registros[i].tipop)==-1){
              this.tipos.push(this.registros[i].tipop)
            }
            if(this.ejecutoras.indexOf(this.registros[i].ejecutora)==-1){
              this.ejecutoras.push(this.registros[i].ejecutora)
            }
            if(this.programas.indexOf(this.registros[i].programa)==-1){
              this.programas.push(this.registros[i].programa)
            }
            if(this.infraestructuras.indexOf(this.registros[i].tipo_infra)==-1){
              this.infraestructuras.push(this.registros[i].tipo_infra)
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
