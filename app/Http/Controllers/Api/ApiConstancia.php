<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiConstancia extends Controller
{
    public $auth;
    public $error;

    public function __construct(ApiAuthMode $auth)
    {
        $this->auth = $auth;
    }

    public function inscripcionPDF($inscripcion_id)
    {
        $api = new ApiConsume($this->auth);
        $api->forceDownload();
        $api->get("api/v1/constancia/{$inscripcion_id}");

        if($api->hasError()) { return $this->error = $api->getError(); }
        $response = $api->response();

        return response($response)->header('Content-Type', 'application/pdf');

/*        return response()->streamDownload(function () use($response) {
            echo $response;
        }, 'test.pdf');*/
    }
    public function regularPDF($inscripcion_id)
    {
        $api = new ApiConsume($this->auth);
        $api->forceDownload();
        $api->get("api/v1/constancia_regular/{$inscripcion_id}");

        if($api->hasError()) { return $this->error = $api->getError(); }
        $response = $api->response();

        return response($response)->header('Content-Type', 'application/pdf');
    }
}