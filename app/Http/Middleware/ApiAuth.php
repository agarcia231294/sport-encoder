<?php

namespace App\Http\Middleware;

use App\Http\Share\JsonResponse;
use App\Models\User;
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
        $api_key = $request->header('api_key');
        if($this->userCheck($api_key)){
            return $next($request);
        }
        return JsonResponse::response(JsonResponse::STATUS_REFUSED,"auth failed",null,401);
    }

    private function userCheck($api_key): bool
    {
        $user = User::where('api_key',$api_key)->first();
        if($user){
            return true;
        }
        return false;
    }
}
