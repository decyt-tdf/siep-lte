<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ApiInscripciones extends Controller
{
    public $error;

    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }
    public function getAll($params=[])
    {
        $api = new ApiConsume($this->authMode);
        $api->get("api/v1/inscripcion/lista",$params);

        if($api->hasError()) { return $this->error = $api->getError(); }
        $response = $api->response();

        return $response;
    }

    public function getId($id,$params=[])
    {
        $api = new ApiConsume($this->authMode);
        $api->get("api/v1/inscripcion/id/{$id}",$params);

        if($api->hasError()) { return $this->error = $api->getError(); }
        $response = $api->response();

        return $response;
    }
}