<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Model\Ejecutora;
use App\Model\F_financiera;
use App\Model\Programa;
use App\Model\Proyecto;
use App\Model\Status;
use App\Model\Presupuesto;
use App\Model\Documentos as Documento;
use App\Model\TDocumentos as Doc;
use App\Model\DocumentoXP As DxP;
use App\Model\ComentariosPM;
use App\Model\Usuario;
use App\Model\Contrato;
use App\Model\Revisar;

use Zipper;




use App\Http\Controllers\ProyectoController;
use Carbon\Carbon;



class ProgramaController extends Controller{

    public function zip(Request $r)
    {
        $data = $r->all();

        $documentos = Documento::where('idproyecto',$data['idproyecto'])->get();

        $files =array();
        
        $proyecto = Proyecto::find($data['idproyecto']);

        foreach ($documentos as $key) {
            $files[] = storage_path('app/'.$key->nombre);

        }
        
        Zipper::make(storage_path('app/zip/temp/'.$proyecto->nombre.'.zip'))->add($files)->close();
        
       
        return response()->download(storage_path('app/zip/temp/'.$proyecto->nombre.'.zip'))->deleteFileAfterSend(true);
    
        
        

        
        
        /* Le indicamos en que carpeta queremos que se genere el zip y los comprimimos*/
        
        /* Por último, si queremos descarlos, indicaremos la ruta del archiv, su nombre
        y lo descargaremos*/
        
    }
    //retorna al formulario


    public function saveComent(Request $r){
        $data = $r->all();
        $c = new ComentariosPM();
        $c->comentario = $data['comentario'];
        $c->idusuario = auth()->user()->idusuario;
        $c->idprograma = $data['idprograma'];
        $c->registro = date('Y-m-d');
        $c->status = 'Activo';
        $c->save();
       return $this->listadoProyecto($r);
    }

    public function changeComent(Request $r){
        $data = $r->all();

        $c = ComentariosPM::find($data['idcomentario']);
        $c->status = 'Finalizado';
        $c->save();
       return $this->listadoProyecto($r);
    }

    public function form(Request $r){
        $datos['ejecutora']=Ejecutora::all();
        $datos['financiera']=F_financiera::all();
        $datos['mensaje'] = 'Bienvenido, porfavor introduce el identificador del programa.';
         //compruebo si va a agregar o si es devuelto por un error al guardar
         
        return view('programa.form')->with($datos);
    }

    //retorna al listado de porogramas
    public function listado(){

        $programas=Programa::all();
        $c =0;
        foreach ($programas as $key ) {
            $c++;
            $e=Ejecutora::find($key->idejecutora)->acronimo;
            $key->idejecutora=$e;
            $key->orden =$c;

            $presus = Presupuesto::where('idprograma',$key->idprograma)->get();
            $sumaP=0;
            foreach ($presus as $pres) {
               $sumaP+=$pres->total;
            }
            $key->total = number_format($sumaP);
        }
        $datos['programa'] = $programas;
        $datos['mensaje'] = 'Bienvenido, aqui encontrarás los programas ya registrados.';

        return view('programa.listado')->with($datos);
    }

    //retorna al listado de proyectos
    public function listadoProyecto(Request $r){
        $datos=$r->all();
        //2 por get y 1 por post
        //GET
        if (!$r->isMethod('post')) {
            //si viene del listado de programas retorna un filtro de proyectos
            if (isset($datos['idprograma'])) {
                //GET
                $response['programa'] = Programa::find($datos['idprograma']);
                $response['comentarios'] = ComentariosPM::where('idprograma',$datos['idprograma'])->get();
                $response['programa']->idejecutora = Ejecutora::find($response['programa']->idejecutora)->acronimo;
                $response['proyectos'] = Proyecto::where('idprograma',$datos['idprograma'])->get();
                //calcular el avance

                foreach ($response['proyectos'] as $key) {
                    //obtengo los documentoa asignados del proyecto
                    $document = DxP::where('idproyecto',$key->idproyecto)->get();
                    //recorrro y compruebo si han sido cargados
                    $cargados = 0;
                    $total = 0;
                    foreach ($document as $doc) {
                        $total++;
                        $d = DB::table('documentos_proyecto')
                        ->select(
                                'idtipod',
                                'idproyecto',
                                'nombre'
            
                            )
                        ->whereRaw("idtipod like '%".$doc->idtipod."%' and idproyecto like'%".$key->idproyecto."%'")
                        ->get();
                        if (isset($d[0]->nombre)) {
                            $cargados++;
                        }
                    }
                   
                    if ($total>0) {
                        $key->avance=($cargados/$total)*100;
                    
                    }else{
                        $key->avance=0;
                    }
                    
                    $key->save();
                }

                //calcu
                $response['mensaje'] = 'Esta es la informacion y los proyectos del programa..';
            }else{
                //si se accede por medio de la url
                //GET
                $response['programa'] = [];
                $response['proyectos'] = Proyecto::all();
                $response['comentarios'] = [];   
                $response['mensaje'] = 'Estos son todos los proyectos registrados al dia de hoy:';
            }

        }else{
            if (isset($datos['idprograma'])) {
                //post
                $response['programa'] = Programa::find($datos['idprograma']);
                $response['programa']->idejecutora = Ejecutora::find($response['programa']->idejecutora)->acronimo;
                $response['comentarios'] = ComentariosPM::where('idprograma',$datos['idprograma'])->get();
                $response['proyectos'] = Proyecto::where('idprograma',$datos['idprograma'])->get(); 
                $response['mensaje'] = 'Esta es la informacion y los proyectos del programa..';
            }else{
                if (isset($datos['nombrePrograma'])) {
                    $programa = Programa::where('nombre',$datos['nombrePrograma'])->get()[0];

                }else{
                    $programa = Programa::where('idprograma',Proyecto::find($datos['idproyecto'])->idprograma)->get()[0];
                }
                $response['programa'] = $programa;
                $response['programa']->idejecutora = Ejecutora::find($response['programa']->idejecutora)->acronimo;
                $response['comentarios'] = ComentariosPM::where('idprograma',$response['programa']->idprograma)->get();

                $response['proyectos'] = Proyecto::where('idprograma',$programa['idprograma'])->get();  
                $response['mensaje'] = 'Esta es la informacion del programa que ya se encuentra en el sistema..';
            }
            //POST
        }
        foreach ($response['comentarios'] as $key) {
            $key->nombre = Usuario::find($key->idusuario)->email;
        }
        $c=0;




        if ($response['programa']!=[]) {
            //comprueba si falta el documento y calcula la fecha limite para  cargarlo
            if ($response['programa']->doc_pdf=="") {
                $carbon = new Carbon();
                $date = Carbon::parse($response['programa']->registro);
                $endDate = $date->addDay(5);
                $response['programa']->fechaL = $endDate->format('d-m-Y');

            }

            $presus = Presupuesto::where('idprograma',$response['programa']->idprograma)->get();
            foreach ($presus as $key) {
                $consulta=DB::table('proyecto')
                ->select(
                        'idproyecto'
                        ,'idprograma'
                    )
                ->whereRaw("idproyecto like '%".$key->idproyecto."%' and idprograma like'%".$response['programa']->idprograma."%'")
                ->get();
                if (!isset($consulta[0])) {
                    $response['proyectos'][]=Proyecto::find($key->idproyecto);
                }
            }
            
        }

        

        foreach ($response['proyectos'] as $key) {
            $c++;
            //$presupuesto = Presupuesto::find($key->idpresupuesto);
            $presus = Presupuesto::where('idproyecto',$key->idproyecto)->get();
            $sumaP=0;
            foreach ($presus as $pres) {
               $sumaP+=$pres->total;
               $pres->idprograma = Programa::find($pres->idprograma)->nombre;
               $pres->total = number_format($pres->total);
            }
            $key->presupuesto=$presus;
            $presupuesto=$sumaP;
            $stat = Status::find($key->idstatus)->nombre;
            $key->idstatus = $stat;
            $key->idpresupuesto = number_format($presupuesto);
            $key->orden=$c;


            
        } 
        if (auth()->user()->idrol==1) {
            $response['revisar']=count(Revisar::all());
        }else{
            $response['revisar']=0;
           }
       
        return view('programa.listadoProyectos')->with($response);
    }

    //da de alta un programa y crea los proyectos dependientes de el asi como una marca para luego completar sus datos
	public function save(Request $r){
        $datos=$r->all();
        //comprueba que no haya un registro igual
        
        $validate=Programa::all();
        foreach ($validate as $key ) {
            if (isset($datos['idprograma'])) {
                if ($key->idprograma!=$datos['idprograma']) {
                    if ($key->nombre===$datos['nombrePrograma']) {
                        return $this->listadoProyecto($r);
                    }
                }
            }else{
                if ($key->nombre===$datos['nombrePrograma']) {
                    return $this->listadoProyecto($r);
                }
            }
            
        }
       
        //registra el programa
        if (isset($datos['idprograma'])) {
            $programa=Programa::find($datos['idprograma']);
        }else{
            $programa=new Programa();
        }

        $programa->nombre=$datos['nombrePrograma'];
        if (isset($datos['idejecutora'])) {
            $programa->idejecutora=$datos['idejecutora'];
        }else{
            $programa->idejecutora=1;
        }
        $programa->registro=date('Y-m-d');
        if (isset($datos['ciclo'])) {
            $programa->ciclo = $datos['ciclo'];
        }
        //comprueba si existe documento a subir
        if($r->hasfile('documento')){
			$archivo=$r->file('documento');
				$nombre=$datos['nombrePrograma'].'.'.$archivo->getClientOriginalExtension();
				$nombre_archivo=$archivo->storeAs('documentos', $nombre);
		}
		else{
            if ($programa->doc_pdf=='') {
			    $nombre_archivo='';
            }else {
                $nombre_archivo=$programa->doc_pdf;
            }
		}
       
        $programa->doc_pdf=$nombre_archivo;
      

        
        $programa->save();
        $totalP=0;
        //crea los proyectos dependientes y comprueba la cantidad real
        if (isset($datos['proyectos'])) {
            foreach ($datos['proyectos'] as $key ) {
                if ($key!='') {
                    $totalP++;
                    $proyecto=new Proyecto();
                    $proyecto->nombre=$key;
                    $proyecto->idprograma=$programa->idprograma;
                    $proyecto->registro=date('Y-m-d');
                    $proyecto->vigencia = date('Y');
                    $proyecto->idstatus=1;
                    $proyecto->idtipop=1;
                    $proyecto->estado = 'Yucatán';
                    $proyecto->save();
                   
                    if ($programa->idejecutora!=1) {
                        $documentos = Doc::all();
                        foreach ($documentos as $key) {
                            $x = new DxP();
                            $x->idproyecto = $proyecto->idproyecto;
                            $x->idtipod = $key->idtipod;
                            $x->save();
                            
                        }
                    }else{
                        $documentos = Doc::all();
                        foreach ($documentos as $key) {
                            if ($key->idtipod!=8 && $key->idtipod!=9) {
                                $x = new DxP();
                                $x->idproyecto = $proyecto->idproyecto;
                                $x->idtipod = $key->idtipod;
                                $x->save();
                            }
                        }
                    }
                }
            }
    
            $nPrograma=Programa::find($programa->idprograma);
            $nPrograma->tl_proyectos=$totalP;
            $nPrograma->save();
        }
        
       return $this->listadoProyecto($r);
    }

    public function delete(Request $r){
        $d = $r->all();

        $c = ComentariosPM::where('idprograma',$d['idprograma'])->delete();
        $Presupuesto = Presupuesto::where('idprograma',$d['idprograma'])->get();
        foreach ($Presupuesto as $key) {
            $key->delete();
        }
        if (isset(Proyecto::where('idprograma',$d['idprograma'])->get()[0])) {
            $Presupuesto2 = Presupuesto::where('idproyecto',Proyecto::where('idprograma',$d['idprograma'])->get()[0]->idproyecto)->get();
            foreach ($Presupuesto2 as $key) {
                $key->delete();
            }
        }
        
        $proyecto = Proyecto::where('idprograma',$d['idprograma'])->get();

        
        foreach ($proyecto as $key) {
            $d['idproyecto'] = $key->idproyecto;
            $contrato = Contrato::where('idproyecto',$d['idproyecto'])->get();
            foreach ($contrato as $key) {
                Storage::delete($key->r1);
                $key->delete();
            }
    
            $edit = Proyecto::find($d['idproyecto']);
            $DxP = DxP::where('idproyecto',$d['idproyecto'])->delete();
            $docs = Documento::where('idproyecto',$d['idproyecto'])->get();
            foreach ($docs as $key) {
                Storage::delete($key->nombre);
                $key->delete();
            }
            $n=Revisar::where('idproyecto',$edit->idproyecto)->delete();

            $edit->delete();
            /*/
            if ($edit->idpresupuesto!=1) {
                $pre = Presupuesto::find($edit->idpresupuesto);
                $pre->delete();
            }
            /*/
        }

        $programa=Programa::find($d['idprograma']);
        Storage::delete($programa->doc_pdf);
        $programa->delete();
        
        return $this->listado();
    }

    public function mostrar_doc($nombre_doc){ 
		$path = storage_path('app/documentos/'.$nombre_doc);

		if(!file::exists($path)){
			abort(404);
		}

		$file = File::get($path);
		$type = File::mimeType($path);
		$response = Response::make($file, 200);
		$response -> header("Content-Type", $type);
		return $response;

	}
    public function edit(Request $r){ 
        $datos = $r->all();
        $data['ejecutora'] = Ejecutora::all();
		$data['programa'] = Programa::find($datos['idprograma']);
        $data['mensaje'] = 'Editemos el programa: '.$data['programa']->nombre;
        return view('programa.edit')->with($data);

	}
    public function descargar_doc($nombre_doc){ 
		
		$path = storage_path('app/documentos/'.$nombre_doc);

		if(!file::exists($path)){
			abort(404);
		}
		
		return response()->download($path);

	}
    //para cargar un documento luego de subir el programa
    public function cargarAfter(Request $r){ 
        $datos = $r->all();
      
		//selecciono el programa en cuestion para editar
        if (isset($datos['idprograma'])) {
            $edit = Programa::find($datos['idprograma']);
            //compruebo si existe el archivo en cuestion innesesario pero por seguriridad.
            //ya fue validado en el frontend
            if($r->hasfile('documento')){
                $archivo=$r->file('documento');
                    if ($edit->doc_pdf!='') {
                        Storage::delete($edit->doc_pdf);
                    }
                    $nombre = $edit->nombre.'.'.$archivo->getClientOriginalExtension();
                    $nombre_archivo = $archivo->storeAs('documentos', $nombre);
            }
            else{
                $nombre_archivo='';
            }
            $edit->doc_pdf = $nombre_archivo;
            $edit->save();
            return $this->listadoProyecto($r);
        }
        
        if (isset($datos['idproyecto'])) {
            $edit = Doc::find($datos['idtipod']);
            //compruebo si existe el archivo en cuestion innesesario pero por seguriridad.
            //ya fue validado en el frontend
            if($r->hasfile('documento')){
                $archivo=$r->file('documento');
                $nombre = $edit['acronimo'].'proyecto'.$datos['idproyecto'].'.'.$archivo->getClientOriginalExtension();
                $nombre_archivo = $archivo->storeAs('documentos', $nombre);
                $validate = Documento::where('idproyecto',$datos['idproyecto'])->get();
                $issetD = false;
                foreach ($validate as $key) {
                    if ($key->idtipod==$datos['idtipod']) {
                        Storage::delete($key->nombre);
                        $key->nombre=$nombre_archivo;
                        $issetD = true;
                        $key->save();
                    }
                }
                if (!$issetD) {
                    $alta = new Documento();
                    $alta->idproyecto = $datos['idproyecto'];
                    $alta->idtipod = $datos['idtipod'];
                    $alta->nombre = $nombre_archivo;
                    $alta->save();
                }

            }
            
            $proyecto = new ProyectoController();
            return $proyecto->documents($r);
        }
       

	}

    


 
}