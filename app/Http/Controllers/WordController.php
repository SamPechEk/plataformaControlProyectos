<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
require_once "vendor/autoload.php";
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Model\Proyecto;
use App\Model\Presupuesto;
use App\Model\Contactos;



class WordController extends Controller{
    //GENERA LOS DOCUMENTOS A PARTIR DE PLANTILLAS
    public function fecha(){

        $meses = array('Enero','Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $carbon = new Carbon();
        $fecha = $carbon->now();
        $mes = $meses[($fecha->format('n'))-1];

        $final = $fecha->format('d').' de '.$mes.' de '.$fecha->format('Y');
        
        return $final;
		

	}
    
    public function plantilla1(Request $r){
        $d = $r->all();
        
        $nombre_doc = 'Plantilla1.docx';
        $num_ofi = $d['input_noficio'];

        $final = $this->fecha();
        $nameProyect=$d['nombre'];
        $centroCosto = $d['costo'];
        

        $document= new TemplateProcessor(storage_path('app/plantillas/'.$nombre_doc));

        $ccp = array();
        if (isset($d['ccp'])) {
            foreach ($d['ccp'] as $key) {
                $contacto = Contactos::find($key);
                $ccp[] = array('name'=>$contacto->nombre,'cargo'=>$contacto->cargo);
            }
            $document->cloneBlock('ccp',0,true,false,$ccp);
        }
        

        $document->setValue('numero_oficio', $num_ofi);
        $document->setValue('fecha', $final);
        $document->setValue('name_obra', $nameProyect);
        $document->setValue('centro_costo', $centroCosto);


        
        $nuevo_doc = $d['nombre'].'.docx';
        $document->saveAs($nuevo_doc);
        return response()->download($nuevo_doc)->deleteFileAfterSend(true);
		

	}
    
    public function form(Request $r){
        if (isset($r->all()['idproyecto'])) {
            $proyecto = Proyecto::find($r->all()['idproyecto']);
            $presupuesto = Presupuesto::where('idproyecto',$proyecto->idproyecto)->get();
            $presu = 0;
            foreach ($presupuesto as $key) {
                $presu+=$key->total;
            }
            $proyecto->idpresupuesto = $presu;
        }else {
            $proyecto = new Proyecto();
            $presupuesto = 0;
            $proyecto->idpresupuesto = $presupuesto;
        }

       $datos['proyecto'] = $proyecto;
       $datos['contactos'] = Contactos::all();

       return view('phpword.plantilla2')->with($datos);
	}
    public function form2(Request $r){
        if (isset($r->all()['idproyecto'])) {
            $proyecto = Proyecto::find($r->all()['idproyecto']);
        }else {
            $proyecto = new Proyecto();
            
        }
        $datos['proyecto'] = $proyecto;
        $datos['contactos'] = Contactos::all();
        return view('phpword.plantilla1')->with($datos);
    }

    public function plantilla2(Request $r){
        $d = $r->all();
        $nombre_doc = 'Plantilla2.docx';
        $num_ofi = $d['input_noficio'];

        $final = $this->fecha();
        $nameProyect=$d['nombre'];
        $centroCosto = $d['costo'];
        $ugi = $d['ugi'];
        $ubp = $d['ubp'];
        $presupuesto = number_format($d['presupuesto']);
        $ciclo = date('Y');


        $ccp = array();

       
      
       

        

        $document= new TemplateProcessor(storage_path('app/plantillas/'.$nombre_doc));
        if (isset($d['ccp'])) {
            foreach ($d['ccp'] as $key) {
                $contacto = Contactos::find($key);
                $ccp[] = array('name'=>$contacto->nombre,'cargo'=>$contacto->cargo);
            }
            $document->cloneBlock('ccp',0,true,false,$ccp);
        }

        $document->setValue('numero_oficio', $num_ofi);
        $document->setValue('fecha', $final);
        $document->setValue('name_obra', $nameProyect);
        $document->setValue('centro_costo', $centroCosto);
        $document->setValue('ugi', $ugi);
        $document->setValue('ubp', $ubp);
        $document->setValue('inversion', $presupuesto);
        $document->setValue('ciclo', $ciclo);


        
        $nuevo_doc = $d['nombre'].'.docx';
        $document->saveAs($nuevo_doc);
        return response()->download($nuevo_doc)->deleteFileAfterSend(true);
		

	}
 
}