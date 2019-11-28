<?php
namespace App\Http\Controllers\View;

use App\Http\Controllers\Api\ApiCiclos;
use App\Http\Controllers\Api\ApiInscripciones;
use App\Http\Controllers\Api\ApiLogin;
use App\Http\Controllers\Api\ApiMatriculasCuantitativas;
use App\Http\Controllers\Api\ApiRepitentes;
use App\Http\Controllers\Api\ApiSecciones;
use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\BladeHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class Secciones extends Controller
{
    public function index()
    {
        $auth = new ApiAuthMode();
        
        $ciclo = Carbon::now()->year;

        if(request('ciclo')&& is_numeric(request('ciclo'))) {
            $ciclo =  request('ciclo');
        }

        $params = request()->all();

        $default = [
            'por_pagina' => 10,
            'ciclo' => $ciclo,
            'estado_inscripcion'=> 'CONFIRMADA',
            'division'=> 'con',
        ];

        $params = mergeApiParam($default,$params);

        $api = new ApiMatriculasCuantitativas($auth);
        $secciones = $api->getPorSeccion($params);

        $data = compact('ciclo','secciones','params','auth');

        return view('secciones.index',$data);
    }

    public function show($id)
    {
        $auth = new ApiAuthMode();
        
        $ciclo = Carbon::now()->year;
        if(request('ciclo')) {
            $ciclo = request('ciclo');
        }

        // Datos de seccion
        $api = new ApiSecciones($auth);
        $params = ['with' => 'centro,titulacion'];
        $seccion = $api->getId($id,$params);

        $api = new ApiInscripciones($auth);
        $params = [
            'ciclo' => $ciclo,
            'centro_id' => $seccion['centro_id'],
            'curso_id' => $seccion['id'],
            'por_pagina' => 'all'
        ];

        $inscripciones = $api->getAll($params);

        $data = compact('seccion','inscripciones','ciclo');
        return view('secciones.view',$data);
    }
}
