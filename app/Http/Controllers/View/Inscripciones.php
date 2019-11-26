<?php
namespace App\Http\Controllers\View;

use App\Http\Controllers\Api\ApiCiclos;
use App\Http\Controllers\Api\ApiInscripciones;
use App\Http\Controllers\Api\ApiLogin;
use App\Http\Controllers\Api\ApiTrayectoria;
use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class Inscripciones extends Controller
{
    public function __construct()
    {
        //$this->middleware('jwt');
    }

    public function index()
    {
        $auth = new ApiAuthMode();

        $ciclo = Carbon::now()->year;

        if(request('ciclo')&& is_numeric(request('ciclo'))) {
            $ciclo =  request('ciclo');
        }

        $params = request()->all();

        $default = [
            'ciclo' => $ciclo,
            'estado_inscripcion'=> 'CONFIRMADA'
        ];

        $params = mergeApiParam($default,$params);

        $api = new ApiInscripciones($auth);
        $inscripciones = $api->getAll($params);

        $data = compact('inscripciones','params','auth');

        return view('inscripciones.index',$data);
    }

    public function show($id)
    {
        $auth = new ApiAuthMode();
        
        $relaciones = [
            'inscripcion.alumno.familiares.familiar.persona.ciudad'
        ];
        $params = request()->all();
        $default['with'] = join(',',$relaciones);
        $params = array_merge($params,$default);

        $api = new ApiInscripciones($auth);
        $data = $api->getId($id,$params);

        if($api->error) {
            return view('error',[
                'error' => $api->error
            ]);
        } else {
            $inscripcion = $data['inscripcion'];

            $centro = $inscripcion['centro'];
            $alumno= $inscripcion['alumno'];
            $persona= $alumno['persona'];
            $familiares = $alumno['familiares'];

            $api = new ApiTrayectoria($auth);
            $trayectoria_alumno = $api->get($persona['id']);

            $data = compact('inscripcion','centro','alumno','persona','familiares','trayectoria_alumno');
        }

        return view('inscripciones.view',$data);
    }
}
