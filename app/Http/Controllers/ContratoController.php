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
use App\Model\Contratista;
use App\Model\Contrato;
use App\Model\F_financiera;



use Carbon\Carbon;
use App\Http\Controllers\ProyectoController;



class ContratoController extends Controller{
    //retorna al formulario
    public function form(Request $r){
        $data = $r->all();
        if (isset($data['idproyecto'])) {
            $datos['idproyecto'] = $data['idproyecto'];
            $datos['contratistas'] = Contratista::all();
            $datos['origen_r'] = 'en';
            $datos['nombre_p'] = Proyecto::find($data['idproyecto'])->nombre;
            $presu = Presupuesto::where('idproyecto',$data['idproyecto'])->get();
            $datos['presupuesto'] = 0;
            $c=Contrato::where('idproyecto',$data['idproyecto'])->get();
            $t=0;
            foreach ($c as $k) {
                $t+=($k->monto_contratado*.16)+$k->monto_contratado;
            }

            foreach ($presu as $key) {
                $datos['presupuesto']+=$key->total;
            }
            $datos['contrato'] = new Contrato();
            $datos['contrato']->monto_contratado=0;
            $datos['disponible']= $datos['presupuesto']-$t;
            $datos['idcontrato'] = '';
        }
        if (isset($data['idcontrato'])) {
            $datos['idproyecto'] = '';
            $datos['contratistas'] = Contratista::all();
            $datos['contrato'] = Contrato::find($data['idcontrato']);
            $datos['nombre_p'] = Proyecto::find($datos['contrato']->idproyecto)->nombre;
            $datos['origen_r'] = ')[0]->nombre';
            $presu = Presupuesto::where('idproyecto',$datos['contrato']->idproyecto)->get();
            $c=Contrato::where('idproyecto',$datos['contrato']->idproyecto)->get();
            $t=0;
            foreach ($c as $k) {
                $t+=($k->monto_contratado*.16)+$k->monto_contratado;
            }

            $datos['presupuesto'] = 0;
            foreach ($presu as $key) {
                $datos['presupuesto']+=$key->total;
            }
            $datos['idcontrato'] = $data['idcontrato'];
            $datos['disponible']= ($datos['presupuesto']-$t)+$datos['contrato']->monto_contratado;

        }
        $datos['origen_r']='Origen desconocido';
       
        if ($data['captura']=='auto') {
            return view('contrato.form')->with($datos);
        }else {
            return view('contrato.formM')->with($datos);
        }
         
        
    }


    


    public function save(Request $r){
        $data = $r->all();
        if (!is_Null($data['idproyecto'])) {
            $validar = Contrato::all();
            foreach ($validar as $key) {
                if ($key->n_contrato===$data['numeroc']) {
                    $proyecto=new ProyectoController();
                    return $proyecto->listadoContratos($r);
                }
            }
            $contrato = new Contrato();
            $contrato->idproyecto = $data['idproyecto'];

        }else{
            $validar = Contrato::all();
            foreach ($validar as $key) {
                if ($key->idcontrato!=$data['idcontrato']) {
                    if ($key->n_contrato===$data['numeroc']) {
                        $proyecto=new ProyectoController();
                        return $proyecto->listadoContratos($r);
                    }
                }
                
            }
            $contrato = Contrato::find($data['idcontrato']);
        }
        $contrato->n_contrato = $data['numeroc'];
        $contrato->idcontratista = $data['idcontratista'];
        $contrato->inicio = $data['inicio'];
        $contrato->fin = $data['fin'];
        $contrato->monto_contratado = $data['a_contratar'];


        $inicio = Carbon::parse($data['inicio']);

        $plazo = $inicio->diffInDays($data['fin']);

        $contrato->plazo = $plazo;
        $contrato->registro = date('Y-m-d');

        if($r->hasfile('documento')){
			$archivo=$r->file('documento');
			$nombre='Contrato_'.$data['numeroc'].'.'.$archivo->getClientOriginalExtension();
			$nombre_archivo=$archivo->storeAs('documentos', $nombre);
            if ($contrato->r1!='') {
                Storage::delete($contrato->r1);
            }
		}
		else{
            if ($contrato->r1=='') {
                $nombre_archivo='';
            }else {
                $nombre_archivo=$contrato->r1;
            }
			
		}
        $contrato->r1 = $nombre_archivo;
        $contrato->carga='manual';



        $contrato->save();
        
         
        $proyecto=new ProyectoController();
        return $proyecto->listadoContratos($r);
    }

    public function delete(Request $r){
        $d = $r->all();

        $edit = Contrato::find($d['idcontrato']);
        if ($edit->r1!='') {
            Storage::delete($edit->r1);

        }
        $edit->delete();
        
        $proyecto=new ProyectoController();
        return $proyecto->listadoContratos($r);
    }

}