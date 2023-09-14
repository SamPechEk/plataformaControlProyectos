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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use App\Model\Proyecto;
use App\Model\Presupuesto;
use App\Model\Programa;
use App\Model\TiposP;

use App\Model\Contactos;
use App\Model\Contratista;
use App\Model\Contrato;
use App\Model\Solicitud;

use App\Model\F_financiera;
use App\Model\Ejecutora;

use App\Model\Fuente_programa as FxP;

use App\Http\Controllers\ProyectoController;





class ExxelController extends Controller{
    //GENERA LOS DOCUMENTOS A PARTIR DE PLANTILLAS
    public function fecha($fecha){

        $meses = array('Enero','Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $carbon = Carbon::parse($fecha);
        $mes = $meses[($carbon->format('n'))-1];

        $final = $carbon->format('d').' de '.$mes.' de '.$carbon->format('Y');
        
        return $final;
		

	}
    
    public function test(){
        
        $nombre_doc = 'exxel.xlsx';
        $spreadsheet = IOFactory::load(storage_path('app/plantillas/'.$nombre_doc));
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A10', '01212-653778-HDKH')
        ->setCellValue('E10', 'Mantenimiento y conservacion del centro estatal de emprendedores de Valladolid, Yucatan')
        ;
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save(storage_path('app/documentos/hello world.xlsx'));

       
        return response()->download(storage_path('app/documentos/hello world.xlsx'));
		

	}

    public function r1(Request $r){
        $data = $r->all();
        
       
        $nombre_doc = 'exxel.xlsx';

        $spreadsheet = IOFactory::load(storage_path('app/plantillas/'.$nombre_doc));
        $spreadsheet->setActiveSheetIndex(0);


        if (isset($data['t_r'])) {
            if ($data['t_r']=='Estatal') {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('E5', 'X');
            }else{
                if ($data['t_r']=='Federal') {
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('G5', 'X');
                }
            }
        }
        
        if (isset($data['clas'])) {
            switch ($data['clas']) {
                case 'Obra':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('E7', 'X');
                    break;
                case 'Servicio':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('G7', 'X');
                    break;
                case 'Adquisicion':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('I7', 'X');
                    break;
                case 'Civiles':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('K7', 'X');
                    break;
            }
        }
        if (isset($data['modalidad_p'])) {
            switch ($data['modalidad_p']) {
                case 'LP':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('M6', 'X');
                break;
                case 'I3P':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('M7', 'X');
                break;
                case 'AD':
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('M8', 'X');
                break;
            }
        }
        
        if (isset($data['modalidad_c'])) {
            if ($data['modalidad_c']=='P.U') {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('O6', 'X');
            }else{
                if ($data['modalidad_c']=='P.A') {
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('O8', 'X');
                }
            }
        }
        if (isset($data['numeroc'])) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A10', $data['numeroc'])
                ->setCellValue('C21', $data['numeroc'])
                ;
        }



        if (!isset($data['idproyecto'])) {
            $data['idproyecto']=Contrato::find($data['idcontrato'])->idproyecto;
        }
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('E10', Proyecto::find($data['idproyecto'])->nombre);

        //$fuente = F_financiera::find(FxP::where('idprograma',Proyecto::find($data['idproyecto'])->idprograma)->get()[0]->idfuente)->nombre;
        
        $pres = Presupuesto::where('idproyecto',$data['idproyecto'])->get();
        $presupuesto=0;
        $fuente ='';
        foreach ($pres as $key) {
            $presupuesto+=$key->total;
            $fuente = $fuente.'
            '.Programa::where('idprograma',$key->idprograma)->get()[0]->nombre;

        }
        
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('E14', $fuente);
        $siniva = round(($presupuesto/116)*100,2);
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C17', $presupuesto)
                ->setCellValue('C16', $presupuesto)
                ;
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B16', $siniva);
        





        if (isset($data['c_contable'])) {
            //$fecha = $this->fecha($data['c_contable']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C22', $data['c_contable']);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C22', 'N/A');
        }

        if (isset($data['c_base'])) {
            //$fecha = $this->fecha($data['c_base']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C23', $data['c_base']);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C23', 'N/A');
        }

        if (isset($data['convocatoria'])) {
            $fecha = $this->fecha($data['convocatoria']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C24', $fecha);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C24', 'N/A');
        }

        if (isset($data['l_base'])) {
            $fecha = $this->fecha($data['l_base']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C25', $fecha);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C25', 'N/A');
        }
        
        if (isset($data['v_sitios'])) {
            $fecha = $this->fecha($data['v_sitios']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C26', $fecha);
            if (isset($data['h_sitiost'])) {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F26', $data['h_sitiost']);
            }
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C26', 'N/A');
        }

        if (isset($data['j_aclaraciones'])) {
            $fecha = $this->fecha($data['j_aclaraciones']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C27', $fecha);
            if (isset($data['h_aclaraciones'])) {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F27', $data['h_aclaraciones']);
            }
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C27', 'N/A');
        }

        if (isset($data['a_proposiciones'])) {
            $fecha = $this->fecha($data['a_proposiciones']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C28', $fecha);
            if (isset($data['h_proposisiones'])) {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F28', $data['h_proposisiones']);
            }
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C28', 'N/A');
        }

        if (isset($data['fallo_apertura'])) {
            $fecha = $this->fecha($data['fallo_apertura']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C29', $fecha);
            if (isset($data['h_fallo'])) {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F29', $data['h_fallo']);
            }
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C29', 'N/A');
        }

        if (isset($data['f_contrato'])) {
            $fecha = $this->fecha($data['f_contrato']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C30', $fecha);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C30', 'N/A');
        }

        if (isset($data['M01'])) {
            $fecha = $this->fecha($data['M01']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C31', $fecha);
        }

        if (isset($data['inicio'])) {
            $inicio = Carbon::parse($data['inicio']);
            $fecha = $this->fecha($data['inicio']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C32', $fecha);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C32', 'N/A');
        }

        if (isset($data['fin'])) {
            $fecha = $this->fecha($data['fin']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C33', $fecha);
                $plazo = $inicio->diffInDays($data['fin'])+1;
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('C34', 'D.N')
                        ->setCellValue('F34', $plazo);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C33', 'N/A');
        }


        if (isset($data['f_entregac'])) {
            $fecha = $this->fecha($data['f_entregac']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C35', $fecha);
        }else {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C35', 'N/A');
        }

        if (isset($data['a_contratar'])) {
            $iva = round($data['a_contratar']*.16,2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('L21', $data['a_contratar']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('L24', $iva);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('L27', round($iva+$data['a_contratar'],2));
        
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('O21', round((($iva+$data['a_contratar'])/100)*$data['porcentaje_a'],2))
                ->setCellValue('O24', round((($iva+$data['a_contratar'])/100)*$data['porcentaje_a'],2))
                ->setCellValue('N24',$data['porcentaje_a']/100)
                ;
        }
        
        if (isset($data['idcontratista'])) {
            $contratista = Contratista::find($data['idcontratista']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('N28','EMPRESA- '.$contratista->nombre)
                ->setCellValue('N32','CONTACTAR A- '.$contratista->contacto)
                ->setCellValue('N33','R.F.C. '.$contratista->rfc)
                ->setCellValue('N34','CORREO- '.$contratista->correo)
                ->setCellValue('N35','TELEFONO- '.$contratista->telefono)
                ;
        }
       

       
        if ($data['idproyecto']!='') {
            $contrato = new Contrato();
            $contrato->idproyecto = $data['idproyecto'];

        }
        if ($data['idcontrato']!='') {
            $contrato = Contrato::find($data['idcontrato']);
            if ($contrato->r1!='') {
                Storage::delete($contrato->r1);
            }
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save(storage_path('app/documentos/'.$data['numeroc'].'.xlsx'));
        
        
        $contrato->idcontratista = $data['idcontratista'];
        $contrato->inicio = $data['inicio'];
        $contrato->fin = $data['fin'];
        $contrato->plazo = $plazo;
        $contrato->monto_contratado = $data['a_contratar'];
        $contrato->n_contrato = $data['numeroc'];
        $contrato->registro = date('Y-m-d');
        $contrato->r1 ='documentos/'.$data['numeroc'].'.xlsx';
        $contrato->carga='auto';
        $contrato->save();
        
        $redirect = new ProyectoController();
        return $redirect->listadoContratos($r);



       
       
        dd('ALGO SALIO MAL PORFAAVOR REGRESA A LA VENTANA ANTERIOR E INTENTA DE NUEVO');


	}


    public function fafef(Request $r){
        $data = $r->all();

        if (isset($data['idfaf'])) {
            $nombre_doc = 'fafef.xlsx';

            $spreadsheet = IOFactory::load(storage_path('app/plantillas/'.$nombre_doc));
            $p = Proyecto::find($data['idfaf']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B12', $p->n_ugi);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C12', $p->n_ubp);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('D12', TiposP::find($p->idtipop)->nombre);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('E12', $p->nombre);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('G12', $p->municipio);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('H12', $p->localidad);
            $ideje = Programa::find($p->idprograma)->idejecutora;
            if ($ideje==1) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('I12', 'Instituto para la Construcción y Conservación de Obra Pública en Yucatán');
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('R12', $p->descripcion);



            $meses = array('Enero','Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            $carbon = new Carbon();

            $fecha = $carbon->now();
            $mes = $meses[($carbon->format('n'))-1];
        
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('O6', $carbon->format('d'));
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('P6', $mes);    
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('Q6', $carbon->format('Y'));

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $writer->save(storage_path('app/documentos/'.$p->nombre.'.xlsx'));
            return response()->download(storage_path('app/documentos/'.$p->nombre.'.xlsx'))->deleteFileAfterSend(true);

        }else{
            return response()->download(storage_path('app/plantillas/fafef.xlsx'));
        }
        dd('ALGO SALIO MAL PORFAAVOR REGRESA A LA VENTANA ANTERIOR E INTENTA DE NUEVO');

	}

    public function reporte(Request $r){
        $data = $r->all();
        $nombre_doc = 'reporte.xlsx';
        $spreadsheet = IOFactory::load(storage_path('app/plantillas/'.$nombre_doc));
        
        if (isset($data['idproyecto'])) {
           
            $p = Proyecto::find($data['idproyecto']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A13', $p->idproyecto);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B13', $p->nombre);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C13', $p->localidad);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('D13', $p->municipio);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('E13', Programa::where('idprograma',$p->idprograma)->get()[0]->nombre);

            $presu = Presupuesto::where('idproyecto',$p->idproyecto)->get();
            $suma = 0;
            foreach ($presu as $key) {
                $suma+=$key->total;
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F13', $suma);
            $contra = Contrato::where('idproyecto',$p->idproyecto)->get();
            $cont =13;
            $total = 0;
            foreach ($contra as $key) {
            
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("G$cont", $key->n_contrato);
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("H$cont", $key->monto_contratado);
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("I$cont", $key->monto_contratado*.16);
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("J$cont", ($key->monto_contratado*.16)+$key->monto_contratado);

                $cont++;
                $total+=($key->monto_contratado*.16)+$key->monto_contratado;
            }
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue("I$cont", 'Total');
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue("J$cont", $total);
        }else{
            $proyecto=DB::table('proyecto')
                    ->join('programa','proyecto.idprograma','=','programa.idprograma')
                    ->join('contratos','contratos.idproyecto','=','proyecto.idproyecto')
                    ->join('tiposp','tiposp.idtipop','=','proyecto.idtipop')
                    ->join('eje_gasto','eje_gasto.idejecutora','=','programa.idejecutora')
                    ->select(
                            'proyecto.idproyecto'
                            ,'programa.idprograma'
                            ,'proyecto.nombre'
                            ,DB::Raw('programa.nombre as programa')
                            ,DB::Raw('tiposp.nombre as tipop')
                            ,DB::Raw('eje_gasto.acronimo as ejecutora')
                            ,\DB::Raw("DATE_FORMAT(proyecto.registro, '%Y-%m-%d') as registrop")
                            ,'contratos.n_contrato'
                            ,'n_ugi'
                            ,'n_ubp'
                            ,'avance'
                            
                    );
            if (isset($data['var'])) {
                $proyecto=$proyecto->whereRaw("proyecto.nombre like '%".$data['var']."%' 
                or programa.nombre like'%".$data['var']."%' 
                or n_contrato like'%".$data['var']."%'
                or n_ubp like'%".$data['var']."%'
                or n_ugi like'%".$data['var']."%'
                ");
            }
    
            $proyecto=$proyecto->get();

            $filtro=[];
            foreach ($proyecto as $key) {
                $filtro_tipoo=$data['filtro_tipo'];
                $filtro_ejecutorao=$data['filtro_ejecutora'];
                $filtro_programao=$data['filtro_programa'];
                if ($data['filtro_tipo']=='Todos') {
                    $filtro_tipoo=$key->tipop;
                }
                if ($data['filtro_ejecutora']=='Todos') {
                    $filtro_ejecutorao=$key->ejecutora;
                }
                if ($data['filtro_programa']=='Todos') {
                    $filtro_programao=$key->programa;
                }
                if ($key->tipop==$filtro_tipoo && $key->programa==$filtro_programao && $key->ejecutora==$filtro_ejecutorao) {
                    $b=true;
                    foreach ($filtro as $ke) {
                       if ($ke->idproyecto==$key->idproyecto) {
                          $b=false;
                       }
                    }
                    if ($b) {
                        $filtro[]=$key;
                    }
                    
                }
            }
            

            $cp = 13;
            $idant=0;
            foreach ($filtro as $value) {
                if ($value->idproyecto!=$idant) {
                    $idant=$value->idproyecto;
                    $p = Proyecto::find($value->idproyecto);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$cp", $p->idproyecto);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("B$cp", $p->nombre);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("C$cp", $p->localidad);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("D$cp", $p->municipio);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("E$cp", Programa::where('idprograma',$p->idprograma)->get()[0]->nombre);
        
                    $presu = Presupuesto::where('idproyecto',$p->idproyecto)->get();
                    $suma = 0;
                    foreach ($presu as $key) {
                        $suma+=$key->total;
                    }
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("F$cp", $suma);
                    $contra = Contrato::where('idproyecto',$p->idproyecto)->get();
                    $cont =$cp;
                    $total = 0;
                    foreach ($contra as $key) {
                    
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("G$cont", $key->n_contrato);
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("H$cont", $key->monto_contratado);
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("I$cont", $key->monto_contratado*.16);
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("J$cont", ($key->monto_contratado*.16)+$key->monto_contratado);
        
                        $cont++;
                        $total+=($key->monto_contratado*.16)+$key->monto_contratado;
                    }
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("I$cont", 'Total');
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("J$cont", $total);
                    $cp=$cont+2;
                }
               
            }
            
        }
            
            
            
        $name='reporte'.time();
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save(storage_path('app/documentos/'.$name.'.xlsx'));
        return response()->download(storage_path('app/documentos/'.$name.'.xlsx'))->deleteFileAfterSend(true);

        
        dd('ALGO SALIO MAL PORFAVOR REGRESA A LA VENTANA ANTERIOR E INTENTA DE NUEVO');

	}

    public function reporte_soli(Request $r){
        $data = $r->all();
        $nombre_doc = 'solicitudes.xlsx';
        $spreadsheet = IOFactory::load(storage_path('app/plantillas/'.$nombre_doc));
        
        if (isset($data['idsolicitud'])) {
           
            $p = Solicitud::find($data['idsolicitud']);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A13', $p->idsolicitud);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B13', $p->nombre);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('C13', $p->localidad);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('D13', $p->municipio);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('E13', $p->n_oficio);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F13', $p->descripcion);
           
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue("G13", $p->tipo);
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue("I13", $p->solicitante);
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue("K13", $p->inversion);
        }else{
            $soli=Solicitud::all();
           
            $filtro=[];
            foreach ($soli as $key) {
                $filtro_tipoo=$data['filtro_tipo'];
                $filtro_localidad=$data['filtro_localidad'];
                $filtro_municipio=$data['filtro_municipio'];
                if ($data['filtro_tipo']=='Todos') {
                    $filtro_tipoo=$key->tipo;
                }
                if ($data['filtro_localidad']=='Todos') {
                    $filtro_localidad=$key->localidad;
                }
                if ($data['filtro_municipio']=='Todos') {
                    $filtro_municipio=$key->municipio;
                }
                if ($key->tipo==$filtro_tipoo && $key->municipio==$filtro_municipio && $key->localidad==$filtro_localidad) {
                    $filtro[]=$key;
                }
            }
            

            $cp = 13;
            $idant=0;
            foreach ($filtro as $p) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A$cp", $p->idsolicitud);
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("B$cp", $p->nombre);
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("C$cp", $p->localidad);
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("D$cp", $p->municipio);
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("E$cp", $p->n_oficio);
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("F$cp", $p->descripcion);
               
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("G$cp", $p->tipo);
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("I$cp", $p->solicitante);
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("K$cp", $p->inversion); 
                $cp++;
            }
            
        }
            
            
            
        $name='reporteSolicitud'.time();
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save(storage_path('app/documentos/'.$name.'.xlsx'));
        return response()->download(storage_path('app/documentos/'.$name.'.xlsx'))->deleteFileAfterSend(true);

        
        dd('ALGO SALIO MAL PORFAVOR REGRESA A LA VENTANA ANTERIOR E INTENTA DE NUEVO');

	}
    
   
 
}