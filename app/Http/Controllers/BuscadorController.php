<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Ejecutora;
use App\Model\F_financiera;
use App\Model\Status;
use App\Model\TiposP;
use App\Model\Usuario;
use App\Model\Contratista;
use App\Model\Rol;
use Faker\Factory as Faker;


class BuscadorController extends Controller{
   
    public function buscar(Request $r){
        $context = $r->all();
		if($r->isMethod('post')){		
			$registros=DB::table('proyecto')
						->join('programa','proyecto.idprograma','=','programa.idprograma')
						->join('contratos','contratos.idproyecto','=','proyecto.idproyecto')
						->join('tiposp','tiposp.idtipop','=','proyecto.idtipop')
						->join('eje_gasto','eje_gasto.idejecutora','=','programa.idejecutora')
						->select(
								'proyecto.idproyecto'
								,'proyecto.nombre'
								,'proyecto.municipio'
								,'tipo_infra'
								,DB::Raw('programa.nombre as programa')
								,DB::Raw('tiposp.nombre as tipop')
								,DB::Raw('eje_gasto.acronimo as ejecutora')
								,\DB::Raw("DATE_FORMAT(proyecto.registro, '%Y-%m-%d') as registrop")
								,'contratos.n_contrato'
								,'n_ugi'
								,'n_ubp'
								,'avance'
								
							)
						->whereRaw("proyecto.nombre like '%".$context['var']."%' 
									or programa.nombre like'%".$context['var']."%' 
									or n_contrato like'%".$context['var']."%'
									or n_ubp like'%".$context['var']."%'
									or n_ugi like'%".$context['var']."%'
									")
						->get();
			$datos=array();
			$datos['registros']=$registros;
			$datos['var']=$context['var'];
		}else {
			$datos=array();
			$registros=DB::table('proyecto')
						->join('programa','proyecto.idprograma','=','programa.idprograma')
						->join('contratos','contratos.idproyecto','=','proyecto.idproyecto')
						->join('tiposp','tiposp.idtipop','=','proyecto.idtipop')
						->join('eje_gasto','eje_gasto.idejecutora','=','programa.idejecutora')
						->select(
								'proyecto.idproyecto'
								,'proyecto.nombre'
								,'proyecto.municipio'
								,'tipo_infra'
								,DB::Raw('programa.nombre as programa')
								,DB::Raw('tiposp.nombre as tipop')
								,DB::Raw('eje_gasto.acronimo as ejecutora')
								,\DB::Raw("DATE_FORMAT(proyecto.registro, '%Y-%m-%d') as registrop")
								,'contratos.n_contrato'
								,'n_ugi'
								,'n_ubp'
								,'avance'
								
							)->get();
			$datos['registros']=$registros;
			$datos['var']='';
		}






        return view('buscador.index')->with($datos);
		

	}
 
}