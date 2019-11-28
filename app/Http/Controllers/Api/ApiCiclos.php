<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiCiclos extends Controller
{
    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }

    public function getAll()
    {
        $api = new ApiConsume($this->authMode);
        $api->get("api/forms/ciclos");
        if($api->hasError()) { return $api->getError(); }
        $ciclos = $api->response();

        return compact('ciclos');
    }
}