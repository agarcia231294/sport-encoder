<?php

namespace App\Http\Controllers;

use App\Http\Share\JsonResponse;
use App\Models\Distance;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DistanceController extends Controller
{
    
    public function createApi(Request $request, int $sesion_id): HttpJsonResponse
    {
        $user = User::where('api_key',$request->header('api-key'))->first();
        if(!$user){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "user not found");
        }

        $session = Session::where('id',$sesion_id)->where('user_id',$user->id)->first();
        if(!$session){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "session not found");
        }

        $cm = $request->get('cm');
        $timestamp = $request->get('timestamp');

        Log::debug("createApi");
        Log::debug($_REQUEST);
        Log::debug($_POST);

        $distance = Distance::create([
            'cm' => $cm,
            'timestamp' => $timestamp,
            'session_id' => $session->id
        ]);
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "Distance created", ['session'=>$distance], 201);
    }
}
