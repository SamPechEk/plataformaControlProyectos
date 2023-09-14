<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Model\Libro;
use Carbon\Carbon;
use App\Model\Proyecto;
use App\Model\Tdocumentos as Doc;
use App\Model\DocumentoXP as DxP;
use App\Model\Documentos as Documento;
use App\Model\Contactos as Contac;
use App\Model\Localidad;
use App\Model\Municipio;
use App\Model\Estado;
use App\Model\TiposP;
use App\Model\Solicitud;
use App\Model\Revisar;

use Illuminate\Support\Facades\File;



use PhpOffice\PhpWord\TemplateProcessor;



class DemoController extends Controller{

	public function test(Request $r){
        $d = $r->all();
        $nombre_doc = 'test.docx';
         
        $document= new TemplateProcessor(storage_path('app/plantillas/'.$nombre_doc));

        $values = array();
        $ccp = Contac::all();
        foreach ($ccp as $key) {
           $values[] = array(
               'name'=>$key->nombre, 'cargo'=>$key->cargo
           );
        }

        $document->cloneBlock('ccp',0,true,false,$values);


        
        $nuevo_doc = 'test'.'.docx';
        $document->saveAs($nuevo_doc);
        return response()->download($nuevo_doc)->deleteFileAfterSend(true);
		

	}

    public function form_soli(Request $r){
        $datos=$r->all();
        $datos['tiposp']=TiposP::all();
        $datos['solicitud']=new Solicitud();
        $datos['solicitud']->idsolicitud = '';
        $datos['estados']=Estado::all();
        $datos['municipios']=Municipio::all();
        if (isset($datos['idsolicitud'])) {
            $solicitud = Solicitud::find($datos['idsolicitud']);
            $datos['solicitud'] = $solicitud;
            if ($solicitud->descripcion=='') {
                $solicitud->descripcion=$solicitud->nombre;
            }          
        }
        return view('solicitud.form')->with($datos);
    }
    public function save_soli(Request $r){
        $data = $r->all();
        if ($data['idsolicitud']!='0') {
            $s=Solicitud::find($data['idsolicitud']);
        }else{
            $s = new Solicitud();
        }
       
        $s->nombre = $data['nombre'];
        $s->descripcion = $data['descripcion'];
        $s->n_oficio = $data['noficio'];
        $s->solicitante = $data['solicitante'];
        $s->tipo=$data['tipop'];
        if (isset($data['localidad'])) {
            $s->localidad = $data['localidad'];
        }
        $s->municipio = $data['municipio'];
        $s->inversion = $data['inversion'];
        $s->registro = date('Y-m-d');
        if($r->hasfile('documento')){
			$archivo=$r->file('documento');
            $nombre=$data['noficio'].'.'.$archivo->getClientOriginalExtension();
            $nombre_archivo=$archivo->storeAs('solicitudes', $nombre);
		}
		else{
			$nombre_archivo= $s->doc;
		}
        if ($s->doc=='') {
            $s->doc=$nombre_archivo;
        }
        $s->save();
        return $this->listado_soli();
    }
    public function listado_soli(){
        $data['registros'] = Solicitud::all();
        return view('solicitud.listado')->with($data);
    }
    public function welcome(){
        $datos=[];
       if (auth()->user()->idrol==1) {
           $datos['revisar']=count(Revisar::all());
       }else{
        $datos['revisar']=0;
       }
       return view('welcome')->with($datos);
    }
    public function descargar_soli($nombre_doc){ 
		
		$path = storage_path('app/solicitudes/'.$nombre_doc);

		if(!file::exists($path)){
			abort(404);
		}
		
		return response()->download($path);

	}

    //no tocaaaar
    public function localidad(Request $r){
        $municipio = $r->all()['municipio'];
        $idmunicipio = Municipio::where('municipio',$municipio)->get()[0]->id_municipio;
        $x = Localidad::where('id_municipio',$idmunicipio)->get();
        return response()->json($x);

    }
    //no tocaaAAAAAAAAAAr

 
 
}