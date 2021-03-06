<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiUsers extends Controller
{
    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }

    public function getAll($params=[])
    {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $api->get("acl/users",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }

    public function getId($id,$params=[])
    {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $api->get("acl/users/{$id}",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }
}