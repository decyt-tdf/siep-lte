<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiTrayectoria extends Controller
{
    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }

    public function get($personaId,$params=[]) {
        $api = new ApiConsume($this->authMode);
        $api->get("api/v1/personas/{$personaId}/trayectoria",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }
}