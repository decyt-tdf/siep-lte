<?php

namespace App\Http\Controllers\Api\Util;

use App\Http\Controllers\Api\ApiLogin;
use App\Http\Controllers\Controller;

class ApiAuthMode extends Controller
{
    public $headers = [];

    private $_token = null;
    private $_apikey = null;

    public function __construct($mode='JWT') {
        switch ($mode) {
            case 'JWT':
            case 'JWTSOCIAL':
                $this->_token = ApiLogin::token();
                $this->authMode($mode,$this->_token);
                break;
            case 'APIKEY':
                $this->_apikey = ApiLogin::apikey();
                $this->authMode($mode,$this->_apikey);
                break;
        }
    }

    public function jwt() {
        $this->authMode('JWT',$this->_token);
    }

    public function social() {
        $this->authMode('JWTSOCIAL',$this->_token);
    }

    public function apikey() {
        $this->authMode('APIKEY',$this->_apikey);
    }

    private function authMode($mode,$value)
    {
        switch($mode) {
            case 'APIKEY':
                $this->setHeaders([
                    'X-SIEP-AUTH' => $mode,
                    'X-SIEP-APIKEY' => $value
                ]);
                break;
            case 'JWT':
                $this->setHeaders([
                    'X-SIEP-AUTH' => $mode,
                    'Authorization' => "Bearer {$value}"
                ]);
                break;
            case 'JWTSOCIAL':
                $this->setHeaders([
                    'X-SIEP-AUTH' => $mode,
                    'Authorization' => "Bearer {$value}"
                ]);
                break;
        }
    }

    private function setHeaders($headers) {
        $this->headers = [
            'headers' => $headers
        ];
    }
}
