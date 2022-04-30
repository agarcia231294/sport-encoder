<?php

namespace App\Http\Middleware;

use App\Http\Share\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use stdClass;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $username = $request->header('user');
        $api_key = $request->header('api_key');
        if($this->userCheck($username,$api_key)){
            return $next($request);
        }
        return JsonResponse::response(JsonResponse::STATUS_REFUSED,"auth failed",null,401);
    }

    private function userCheck($username,$api_key): bool
    {
        // TODO userCheck with real users
        $user = new stdClass;
        $user->name = "akrian";
        $user->api_key = "2323232323232323";
        if($username == $user->name AND $user->api_key == $api_key){
            return true;
        }
        return false;
    }
}
