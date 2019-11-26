<?php
namespace App\Http\Controllers\View;

use App\Http\Controllers\Api\ApiCiclos;
use App\Http\Controllers\Api\ApiLogin;
use App\Http\Controllers\Api\ApiRepitentes;
use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class Repitentes extends Controller
{
    public function index()
    {
        $auth = new ApiAuthMode();

        $ciclo = Carbon::now()->year;

        if(request('ciclo')) {
            $ciclo =  request('ciclo');
        }

        $params = request()->all();
        $default = [
            'ciclo' => $ciclo,
            'estado_inscripcion' => 'CONFIRMADA',
            'page' => request('page')
        ];
        $params = array_merge($default,$params);

        $api = new ApiRepitentes($auth);
        $repitentes = $api->getAll($params);

        $data = compact('repitentes','ciclo','ciclos');

        return view('repitentes.index',$data);
    }
}
