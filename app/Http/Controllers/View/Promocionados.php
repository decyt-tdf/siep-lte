<?php
namespace App\Http\Controllers\View;

use App\Http\Controllers\Api\ApiCiclos;
use App\Http\Controllers\Api\ApiLogin;
use App\Http\Controllers\Api\ApiPromocionados;
use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class Promocionados extends Controller
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

        $api = new ApiPromocionados($auth);
        $promocionados = $api->getAll($params);

        $data = compact('promocionados','ciclo','auth');

        return view('promocionados.index',$data);
    }
}
