<?php
namespace App\Http\Controllers\View;

use App\Http\Controllers\Api\ApiCiclos;
use App\Http\Controllers\Api\ApiEgresos;
use App\Http\Controllers\Api\ApiLogin;
use App\Http\Controllers\Api\ApiPromocionados;
use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class Egresos extends Controller
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
            //'estado_inscripcion' => ['CONFIRMADA','EGRESO'],
            'page' => request('page')
        ];
        $params = array_merge($default,$params);

        $api = new ApiEgresos($auth);
        $egresos = $api->getAll($params);

        $data = compact('egresos','ciclo','auth');

        return view('egresos.index',$data);
    }
}
