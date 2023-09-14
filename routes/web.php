<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 
   //tests
  

  







   
   //tests
Route::group(['middleware' => 'auth'],function(){
   //RUTA INICIAL
   Route::get('/welcome','DemoController@welcome');
  
   Route::group(['middleware' => 'candado2:CREATE'],function(){

      Route::get('/form_solicitud','DemoController@form_soli');
      Route::get('/listado_solicitud','DemoController@listado_soli');
      Route::post('/save_solicitud','DemoController@save_soli');
      Route::get('ver_soli/solicitudes/{doc}','DemoController@descargar_soli');
      Route::match(array('GET','POST'),'/reporte_soli','ExxelController@reporte_soli');


      //documentos
      Route::get('/form_documento1','WordController@form');
      Route::get('/form_documento2','WordController@form2');
      Route::post('/generate','WordController@plantilla2');
      Route::post('/generate2','WordController@plantilla1');
      
      Route::post('/r1','ExxelController@r1');
      Route::post('/fafef','ExxelController@fafef');
      Route::match(array('GET','POST'),'/reporte','ExxelController@reporte');

      Route::get('/localidad','DemoController@localidad');
      Route::post('/saveAso','ProyectoController@savePXP');
      Route::get('/form/contratista',function(){
         return view('config.registerC');
      });
      Route::post('/registrar/contratista','ConfigController@registerC');

      Route::post('/saveComent','ProgramaController@saveComent');
      Route::post('/changeComent','ProgramaController@changeComent');
      Route::post('/guardar/selectDocuments','ProyectoController@saveAsig');



      //documentosa
      Route::match(array('GET','POST'),'/registrar/programa','ProgramaController@form');
      Route::post('/guardar/programa','ProgramaController@save');
      Route::get('/editPrograma','ProgramaController@edit');
      //PARA CARGAR DOCUMENTOS
      Route::post('/cargar/documento','ProgramaController@cargarAfter');
      //PARA LOS DETALLES DEL PROYECTO
      Route::get('/form/proyecto','ProyectoController@form');
      Route::post('/guardar/proyecto','ProyectoController@save');
      //MODIFICA UNICAMENTE EL AVANCE DE UN PROYECTO
      Route::post('/guardar/avance','ProyectoController@avance');
      Route::get('/delete/proyecto','ProyectoController@delete');
      Route::get('/delete/programa','ProgramaController@delete');
      Route::get('/delete/contrato','ContratoController@delete');



      Route::get('/form/contrato','ContratoController@form');
      Route::post('/guardar/contrato','ContratoController@save');
      Route::post('/guardar/contratoM','ContratoController@saveM');
   });

   Route::group(['middleware' => 'candado2:VIEW'],function(){
      Route::match(array('GET','POST'),'/buscador','BuscadorController@buscar');


      //MUESTRA TODOS LOS PROGRAMAS YA REGISTRADOS
      Route::get('/listado/programa','ProgramaController@listado');
      //MUESTRA LOS PROYECTOS YA REGISTRADOS APLICA FILTRO O NO SEGUN ACCESO
      Route::match(array('GET','POST'),'/listado/proyecto','ProgramaController@listadoProyecto');
      //MUESTRA LOS CONTRATOS YA REGISTRADOS APLICA FILTRO O NO SEGUN ACCESO
      Route::match(array('GET','POST'),'/listado/contratos','ProyectoController@listadoContratos');
      //REDIRECCIONA A LA VISTA DEL DOCUMENTO SELECCIONADO
      Route::get('ver/documentos/{doc_pdf}','ProgramaController@mostrar_doc');
      //RETORNA LA DESCARGA DEL DOCUMENTO
      Route::get('download/documentos/{doc_pdf}','ProgramaController@descargar_doc');
      Route::match(array('GET','POST'),'/listado/documentos','ProyectoController@documents');

      Route::get('/zip','ProgramaController@zip');

   });
   
   Route::group(['middleware' => 'candado2:CONFIG'],function(){
      Route::get('revisar','ProyectoController@revisar');
      Route::get('aprobar','ProyectoController@aprobar');
      //CONFIGURA LAS OPCIONES DEL ENTORNO
      Route::post('/config/options','ConfigController@options');
      //REGISTRA USUARIOS NUEVOS 
      Route::match(array('GET','POST'),'/config/registerUser','ConfigController@formRegisterUser');
      Route::match(array('GET','POST'),'/config/formOptions',function(){
         $datos['mensaje']="Elige la opcion a registrar, estara disponible inmediatamente despues de registrar para ser asignada a los proyectos.";
         return view('config.form')->with($datos);
         //dd('recuerda que esta ruta es solo de pueba actualmente estas trabajando en: /listado/proyecto/programa');
      });
   });

   //CIEERA LA SESION DEL USUARIO
   Route::get('/logout','Auth\LoginController@logout')->name('logout');
}); 
   //INICIO DE SESION OBLIGATORIO
   Route::get('/','Auth\LoginController@formulario')->name('login')->middleware('guest');
   Route::post('/login','Auth\LoginController@login')->middleware('guest'); 



       


	
