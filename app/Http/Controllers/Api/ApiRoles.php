<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Util\ApiAuthMode;
use App\Http\Controllers\Api\Util\ApiConsume;
use App\Http\Controllers\Controller;

class ApiRoles extends Controller
{
    public $authMode;
    public function __construct(ApiAuthMode $authMode)
    {
        $this->authMode= $authMode;
    }
    
    public function getAll($params=[]) {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $api->get("acl/role",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }
    
    public function add($name) {
        $params['name'] = $name;

        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $api->post("acl/role",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
    }

    public function del($id) {
        $api = new ApiConsume($this->authMode);
        $api->setHost(env('SIEP_AUTH_API'));

        $params['id'] = $id;

        $api->delete("acl/role",$params);
        if($api->hasError()) { return $api->getError(); }
        $response = $api->response();

        return $response;
   }
}