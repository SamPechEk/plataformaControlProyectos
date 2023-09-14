<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Model\TiposP;
use App\Model\Programa;
use App\Model\Presupuesto;
use App\Model\Status;
use App\Model\Proyecto;
use App\Model\Tdocumentos as Doc;
use App\Model\DocumentoXP as DxP;
use App\Model\Documentos as Documento;
use App\Model\Contrato;
use App\Model\Contratista;
use App\Model\Estado;
use App\Model\Localidad;
use App\Model\Municipio;
use App\Model\Revisar;


use Carbon\Carbon;
use App\Http\Controllers\ProgramaController;



class ProyectoController extends Controller{
    //retorna al formulario
    public function form(Request $r){
        $data = $r->all();
        $banderaPrograma=false;
        $banderaProyecto=false;
        $datos['tiposp']=TiposP::all();
        $datos['status']=Status::all();
        $datos['proyecto']=new Proyecto();
        $datos['presupuesto']=new Presupuesto();
        $datos['presupuestoPropio'] = new Presupuesto();
        $datos['proyecto']->idproyecto = '';
        $datos['idprograma']='';
        $datos['estados']=Estado::all();
        $datos['municipios']=Municipio::all();
        $datos['programas']=array();
        $datos['banderaaso']='false';
        $datos['banderaindirecto'] = 'false';
        $datos['banderaclave'] = 'false';
        if (isset($data['idprograma'])) {
            $banderaPrograma=true;
            $datos['idprograma']=Programa::find($data['idprograma'])->idprograma;
        }
        if (isset($data['idproyecto'])) {
            
            $banderaProyecto=true;
            $proyecto = Proyecto::find($data['idproyecto']);
            $datos['idprograma']=$proyecto->idprograma;

            if ($proyecto->clave!='') {
                $datos['banderaclave'] = 'true';
            }
            $datos['proyecto'] = $proyecto;
            if ($proyecto->descripcion=='') {
                $proyecto->descripcion=$proyecto->nombre;
            }

            $datos['presupuesto'] =Presupuesto::where('idproyecto',$data['idproyecto'])->get();
          
            if (count($datos['presupuesto'])!=0) {
                
                foreach ($datos['presupuesto'] as $key) {
                    $key->id = $key->idprograma;
                    if ($key->idprograma==Proyecto::find($data['idproyecto'])->idprograma) {
                        $datos['presupuestoPropio'] = $key;
                    }else{
                        $datos['banderaaso'] = 'true';
                    }
                    $key->idprograma = Programa::find($key->idprograma)->nombre;
                    
                    
                   
                 }
            }
            
           
        }

        if (!$banderaProyecto && !$banderaPrograma) {
            return redirect('/listado/programa');
        }
        $z = Programa::all();
        foreach ($z as $key) {
            if ($key->idprograma!= $datos['idprograma']) {
                $datos['programas'][]=$key;
            }
        }
        return view('proyecto.form')->with($datos);
    }

    public function avance(Request $r){
        $d = $r->all();

        $edit = Proyecto::find($d['idproyecto']);
        $edit->avance = $d['avance'];
        $edit->save();

         //compruebo si va a agregar o si es devuelto por un error al guardar
         
         $programa = new ProgramaController();
         return $programa->listadoProyecto($r);
    }

    public function delete(Request $r){
        $d = $r->all();

        $contrato = Contrato::where('idproyecto',$d['idproyecto'])->get();
        foreach ($contrato as $key) {
            Storage::delete($key->r1);
            $key->delete();
        }

        $edit = Proyecto::find($d['idproyecto']);
        $presu = Presupuesto::where('idproyecto',$d['idproyecto'])->delete();
        $DxP = DxP::where('idproyecto',$d['idproyecto'])->delete();
        $docs = Documento::where('idproyecto',$d['idproyecto'])->get();
        foreach ($docs as $key) {
            Storage::delete($key->nombre);
            $key->delete();
        }
        $n=Revisar::where('idproyecto',$edit->idproyecto)->delete();
        $edit->delete();
        /*/if ($edit->idpresupuesto!=1) {
            $pre = Presupuesto::find($edit->idpresupuesto);
            $pre->delete();
        }
        /*/


       
        

        
        $p = Proyecto::where('idprograma',$d['idprograma'])->get();
        $total = 0;
        foreach ($p as $key ) {
            $total++;
        }
        $p = Programa::find($d['idprograma']);
        $p->tl_proyectos = $total;
        $p->save();



        $programa = new ProgramaController();
        return $programa->listadoProyecto($r);
    }

    public function save(Request $r){
        $datos = $r->all();
        if ($datos['idproyecto']==0) {
            $proyectos = Proyecto::all();
            foreach ($proyectos as $key) {
               if ($key->nombre== $datos['nombreProyecto']) {
                return $this->listadoContratos($r);
               }
            }
            $proyecto=new Proyecto();
            $proyecto->nombre=$datos['nombreProyecto'];
            $proyecto->beneficiarios=$datos['beneficiarios'];
            $proyecto->idprograma=$datos['idprograma'];
            $proyecto->descripcion=$datos['descripcion'];
            if (isset($datos['clave'])) {
                $proyecto->clave = $datos['clave'];
            }
            $proyecto->registro=date('Y-m-d');
            $proyecto->vigencia = date('Y');
            $proyecto->idstatus=$datos['status'];
            $proyecto->idtipop=$datos['tipop'];
            $proyecto->empleos_g=$datos['empleosg'];
            $proyecto->estado = 'Yucatán';
            $proyecto->municipio=$datos['municipio'];
            $proyecto->tipo_infra=$datos['tipoinfra'];
            $proyecto->localidad=$datos['localidad'];
            if (!is_Null($datos['ugi'])) {
                $proyecto->n_ugi=$datos['ugi'];
            }
            if (!is_Null($datos['ubp'])) {
                $proyecto->n_ubp=$datos['ubp'];
            }
            /*$presupuesto = new Presupuesto();
            $presupuesto->total = $datos['presupuestoTotal'];
            if (isset($datos['porcentajeIndirecto'])) {
                $presupuesto->porcentajeIndirecto = $datos['porcentajeIndirecto'];
            }
           
            //$presupuesto->idf_financiera=1;
            $presupuesto->save();
            $proyecto->idpresupuesto=$presupuesto->idpresupuesto;
            */
            $proyecto->save();
            $rev= new Revisar();
            $rev->idproyecto=$proyecto->idproyecto;
            $rev->modificasion=date('Y-m-d');
            $rev->save();
            if (Programa::find($datos['idprograma'])->idejecutora!=1) {
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

            $p = Programa::find($datos['idprograma']);
            $p->tl_proyectos=count(Proyecto::where('idprograma',$datos['idprograma'])->get());
            $p->save();

            $programa = new ProgramaController();
            return $programa->listadoProyecto($r);
        
        }else{
            $proyecto=Proyecto::find($datos['idproyecto']);
            $proyecto->beneficiarios=$datos['beneficiarios'];
            $proyecto->nombre=$datos['nombreProyecto'];
            $proyecto->descripcion=$datos['descripcion'];
            if (isset($datos['clave'])) {
                $proyecto->clave = $datos['clave'];
            }
            $proyecto->idstatus=$datos['status'];
            $proyecto->idtipop=$datos['tipop'];
            $proyecto->empleos_g=$datos['empleosg'];
            $proyecto->tipo_infra=$datos['tipoinfra'];
            if (isset($datos['localidad'])) {
                $proyecto->localidad=$datos['localidad'];
            }
            $proyecto->municipio=$datos['municipio'];
            $proyecto->n_ugi=$datos['ugi'];
            $proyecto->n_ubp=$datos['ubp'];


            if ($datos['otrop']=='true') {
                $conta = 0;
                foreach ($datos['presupuestoTotal'] as $key3) {
                    if ($key3!=0) {
                        $presuEdit =  Presupuesto::where('idproyecto',$datos['idproyecto'])->get();
                        $presuEdit[$conta]->total = $key3;
                        $presuEdit[$conta]->porcentajeindirecto = $datos['indirecto'][$conta];
                        $presuEdit[$conta]->save();             
                    }
                    $conta++;
                }
            }else{
               
                if ($datos['presupuestoTotal'][0]!=0) {
                    $presuEdit =  Presupuesto::where('idproyecto',$datos['idproyecto'])->get();
                    if (isset($presuEdit[0])) {
                        $presuEdit=$presuEdit[0];
                    }else{
                        $presuEdit=new Presupuesto();
                        $presuEdit->idproyecto = $datos['idproyecto'];
                        $presuEdit->idprograma = Proyecto::find($datos['idproyecto'])->idprograma;;

                    }
                    $presuEdit->total = $datos['presupuestoTotal'][0];
                    $presuEdit->porcentajeindirecto = $datos['indirecto'][0];
                    $presuEdit->save();             
                }
            }
            
           
            $proyecto->save();
            if (!isset(Revisar::where('idproyecto',$proyecto->idproyecto)->get()[0])) {
                $rev= new Revisar();
                $rev->idproyecto=$proyecto->idproyecto;
                $rev->modificasion=date('Y-m-d');
                $rev->save();
            }else{
                $rev= Revisar::where('idproyecto',$proyecto->idproyecto)->get()[0];
                $rev->modificasion=date('Y-m-d');
                $rev->save();
            }
           
            $programa = new ProgramaController();
            return $programa->listadoProyecto($r);
        }

    }

    public function listadoContratos(Request $r){
        $datos=$r->all();
        //2 por get y 1 por post
        //GET
        if (!$r->isMethod('post')) {
            //si viene del listado de programas retorna un filtro de proyectos
            if (isset($datos['idproyecto'])) {
                //GET
                $response['proyecto'] = Proyecto::find($datos['idproyecto']);
                $response['contratos'] = Contrato::where('idproyecto',$datos['idproyecto'])->get();  
                $response['mensaje'] = 'Esta es la informacion y los contratos del proyecto..';
            }else{
                //si se accede por medio de la url
                //GET

                $response['proyecto'] = [];
                $response['contratos'] = Contrato::all();   
                $response['mensaje'] = 'Estos son todos los contratos registrados al dia de hoy:';
            }
           
        }else{
            if (isset($datos['idproyecto']) && $datos['idproyecto']!=0) {
                //post
                $response['proyecto'] = Proyecto::find($datos['idproyecto']);
                //$response['proyecto']->idejecutora = Ejecutora::find($response['proyecto']->idejecutora)->nombre;
                $response['contratos'] = Contrato::where('idproyecto',$datos['idproyecto'])->get(); 
                $response['mensaje'] = 'Esta es la informacion y los contratos del proyecto..';
            }else{
                
                $proyecto = Proyecto::where('idproyecto',Contrato::find($datos['idcontrato'])->idproyecto)->get()[0];
                
                $response['proyecto'] = $proyecto;
                $response['contratos'] = Contrato::where('idproyecto',$proyecto['idproyecto'])->get();  
                $response['mensaje'] = 'Esta es la informacion del proyecto que ya se encuentra en el sistema..';
            }
            //POST
        }
        if ($response['proyecto']!=[]) {
            $response['proyecto']->idtipop = TiposP::find($response['proyecto']->idtipop)->nombre;

            $presus = Presupuesto::where('idproyecto',$response['proyecto']->idproyecto)->get();
            $sumaP=0;
            foreach ($presus as $pres) {
               $sumaP+=$pres->total;
            }
            $response['proyecto']->idpresupuesto = number_format($sumaP);

            $response['proyecto']->idstatus = Status::find($response['proyecto']->idstatus)->nombre;
            $contrato = Contrato::where('idproyecto',$response['proyecto']->idproyecto)->get();
            
           
        }
        $suma =0;
        foreach ($response['contratos'] as $key) {
            if ($key->monto_contratado!=0) {
                $suma+=$key->monto_contratado;
            }
            $key->monto_contratado=number_format($key->monto_contratado);
            $stat = Contratista::find($key->idcontratista)->nombre;
            $key->idcontratista = $stat;
            if (isset($sumaP)) {
                $response['proyecto']->idpresupuesto = number_format($sumaP);

            }

        } 
        if (isset($sumaP)) {
            $response['proyecto']->disponible =number_format($sumaP-(($suma*.16)+$suma));

        }
        
       
        return view('proyecto.proyectos')->with($response);
    }
   
    public function documents(Request $r){
        $zip='false';
        $dat = Proyecto::find($r->all()['idproyecto']);
        $data['proyecto']= $dat;
        $data['documentos']= Doc::all();
        $temp = DxP::where('idproyecto',$r->all()['idproyecto'])->get();
        $asignados = array();
        //valido los documentos asignados al proyecto para el formulario
        foreach ( $data['documentos'] as $key) {
            $key->asig=false;
            foreach ($temp as $value) {
                if ($key->idtipod==$value->idtipod) {
                    $key->asig=true;
                }
            }
        }
        //filtro por documentos cargados ##esto talvez se puede optimizar
        foreach ($temp as $key) {
            //busco un tipo de documento y sus detalles
            $filtro = Doc::find($key->idtipod);
            //compruebo si ese documento ya se ha  cargado en el servidor y cambio el estado
            $doc = DB::table('documentos_proyecto')
                    ->select(
                            'idtipod',
                            'idproyecto',
                            'nombre'
        
                        )
                    ->whereRaw("idtipod like '%".$key->idtipod."%' and idproyecto like'%".$dat->idproyecto."%'")
                    ->get();
            if (isset($doc[0]->nombre)) {
                $filtro->estado = 'Cargado';
                $filtro->nombredoc = $doc[0]->nombre;
                $zip='true';
            }else{
                $filtro->estado = 'Pendiente';
            }
            //agrego el documento para el render de vue
            $asignados[]= $filtro;
        }
        $data['doc_asig'] = $asignados;
        $data['mensaje'] = 'Estos son los documentos de este proyecto.';
        $data['zip'] =$zip;
        return view('proyecto.documentos')->with($data);
        
                
    }

    public function saveAsig(Request $r){

        $data = $r->all();
        $docs = Doc::all();
        DxP::where('idproyecto',$data['idproyecto'])->delete();
        foreach ($docs as $key) {
            if (isset($data[$key->idtipod])) {
                $asig = new DxP();
                $asig->idproyecto = $data['idproyecto'];
                $asig->idtipod = $key->idtipod; 
                $asig->save();
            }
           
        }
       return $this->documents($r); 
                  
    }

    public function savePXP(Request $r){
        $data = $r->all();
        
        
        if ($data['idproyecto']!=0) {
            $consulta=DB::table('presupuesto')
            ->select(
                    'idproyecto'
                    ,'idprograma'
                )
            ->whereRaw("idproyecto like '%".$data['idproyecto']."%' and idprograma like'%".Proyecto::find($data['idproyecto'])->idprograma."%'")
            ->get();
            if(!isset($consulta[0])){
                $presu = new Presupuesto();
                $presu->idproyecto=$data['idproyecto'];
                $presu->idprograma=Proyecto::find($data['idproyecto'])->idprograma;
                $presu->porcentajeindirecto=0;
                $presu->total=0;
                $presu->save();
            }

            $ps=Presupuesto::where('idproyecto',$data['idproyecto'])->get();
            foreach ($ps as $key) {
               if ($key->idprograma!=Proyecto::find($data['idproyecto'])->idprograma) {
                   $key->delete();
               }
            }



            foreach ($data['programasaso'] as $key2) {
                $presu = new Presupuesto();
                $presu->idproyecto=$data['idproyecto'];
                $presu->idprograma=$key2;
                $presu->porcentajeindirecto=0;
                $presu->total=0;
                $presu->save();
            }



        }

       

        $x=Presupuesto::where('idproyecto',$data['idproyecto'])->get();
        $filter=[];
        foreach ($x as $key) {
            if ($key->idprograma!=Proyecto::find($data['idproyecto'])->idprograma) {
                $filter[]=$key;
            }
        }
        $x=$filter;
        foreach ($x as $key) {
            $key->idprograma = Programa::find($key->idprograma)->nombre;
        }
       

        return response()->json($x);

    }
    public function revisar(){
        $p = Revisar::all();
        $pr=[];
        foreach ($p as $key) {

           $z=Proyecto::find($key->idproyecto);
           $z->idtipop=Tiposp::find($z->idtipop)->nombre;
           $z->idprograma=Programa::find($z->idprograma)->nombre;
           $z->modificasion=$key->modificasion;
           $pr[]=$z;
        }
        $data['proyectos']=$pr;
       return view('proyecto.revisar')->with($data); 
                  
    }

    public function aprobar(Request $r){
       $n = $r->all();
       $z=Revisar::where('idproyecto',$n['idproyecto'])->delete();
       return $this->revisar(); 
                  
    }
}