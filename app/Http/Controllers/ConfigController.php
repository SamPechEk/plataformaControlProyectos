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


class ConfigController extends Controller{
    //GENERA LOS DOCUMENTOS A PARTIR DE PLANTILLAS

    public function options(Request $r){
        $datos = $r->all();
        switch ($datos['selected']) {
            case 'eje_gasto':
                $edit = new Ejecutora;
                $edit->nombre = $datos['nombre'];
                break;
            case 'ffinanciera':
                $edit = new F_financiera;
                $edit->nombre = $datos['nombre'];
                break;
            case 'status':
                $edit = new Status;
                $edit->nombre = $datos['nombre'];
                break;
            case 'tiposp':
                $edit = new TiposP;
                $edit->nombre = $datos['nombre'];
                break;
        }
        $edit->save();
        $data['mensaje'] = 'Listo, se ha dado de alta un nuevo registro.';
        return view('config.form')->with($data);	
	}

    public function registerC(Request $r){
        $datos = $r->all();

        $edit = new Contratista();
        $edit->nombre = strtoupper($datos['nombre']);
        $edit->contacto = strtoupper($datos['ncontacto']);
        $edit->rfc = strtoupper($datos['rfc']);
        $edit->correo = $datos['correo'];
        $edit->telefono = $datos['telefono'];
        $edit->save();

        $edit->save();
        return view('config.registerC');	
	}

    public function registerUser(Request $r){
        $data=$r->all();
        
        $email_nuevo=explode(" ",$data['usuario'])[0].'@inccopy.gob.mx';
        $validar=Usuario::all();
        foreach ($validar as $valida) {
            if ($valida->nombre==$data['usuario']) {
                return 'ERROR, este usuario ya esta registrado.';
            }
           
            if ($valida->email==$email_nuevo) {
                $bandera = true;
                while ($bandera) {
                    $faker = Faker::create();
                    $email_nuevo=explode(" ",$data['usuario'])[0].$faker->regexify('([A-Z0-9]){2}').'@inccopy.gob.mx';
                    $bandera = false;
                    foreach ($validar as $valida2) {
                        if ($valida2->email==$email_nuevo) {
                            $bandera = true;
                        }
                    }
                };
            }
        }
        if ($data['autokey']=='true') {
            $faker = Faker::create();
            $password=explode(" ",$data['usuario'])[0].'@'.$faker->regexify('([A-Z0-9]){5}');
        }else {
            $password=$data['password'];
        }

        $usuario=new Usuario();
        $usuario->idrol=$data['selected'];
        $usuario->email=$email_nuevo;
        $usuario->nombre=$data['usuario'];
        $usuario->password=bcrypt($password);
        $usuario->save();
        return 'Se ha registrado al usuario: '.$email_nuevo.' Su clave de acesso es: '.$password;
		

	}
    public function formRegisterUser(Request $r){
        $tipos = Rol::all();
        $datos['rol'] = $tipos;
        $datos['mensaje'] = 'Vamos a registrar un usuario!';
        if ($r->isMethod('post')) {
            $datos['mensaje'] = $this->registerUser($r);
        }
        return view('config.formUser')->with($datos);
		

	}
 
}