<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiLogin;
use Closure;

class authToApi
{
    public function handle($request, Closure $next)
    {
        if(!session('user')) {
            return redirect('login');
        }

        $login = new ApiLogin();
        $loginResponse = $login->getUserData($login->token());
        if(isset($loginResponse['error']) && $loginResponse['code']==403) {
            session()->flush();
            return redirect('login');
        }

        return $next($request);
    }
}