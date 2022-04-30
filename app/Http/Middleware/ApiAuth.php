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
        $apikey = $request->header('apikey');
        if($this->userCheck($username,$apikey)){
            return $next($request);
        }
        return JsonResponse::response(JsonResponse::STATUS_REFUSED,"auth failed");
    }

    private function userCheck($username,$apikey): bool
    {
        // TODO userCheck with real users
        $user = new stdClass;
        $user->name = "akrian";
        $user->apikey = "2323232323232323";
        if($username == $user->name AND $user->apikey == $apikey){
            return true;
        }
        return false;
    }
}
