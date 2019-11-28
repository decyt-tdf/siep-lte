<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiMatriculasCuantitativas extends Controller
{
    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }

    public function getPorNivel($params=[])
    {
        $api = new ApiConsume($this->authMode);
        $api->get("api/v1/matriculas/cuantitativa/por_nivel",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }

    public function getPorSeccion($params=[])
    {
        $api = new ApiConsume($this->authMode);
        $api->get("api/v1/matriculas/cuantitativa/por_seccion",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }
}