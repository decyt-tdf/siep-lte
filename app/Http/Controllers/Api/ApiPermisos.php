<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiPermisos extends Controller
{
    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }

    public function getAll($params=[]) {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $api->get("acl/permission",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }

    public function add($name) {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $params['name'] = $name;

        $api->post("acl/permission",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }

    public function del($id) {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $params['id'] = $id;

        $api->delete("acl/permission",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }
}