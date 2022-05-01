<?php

namespace App\Http\Controllers;

use App\Http\Share\JsonResponse;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function indexApi(Request $request): HttpJsonResponse
    {
        $user = User::where('api_key',$request->header('api_key'))->first();
        if(!$user){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "user not found");
        }
        $sessions = Session::where('user_id',$user->id)->get();
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, $sessions->count()." sessions found", ['sessions'=>$sessions]);
    }

    public function createApi(Request $request): HttpJsonResponse
    {
        $user = User::where('api_key',$request->header('api_key'))->first();
        if(!$user){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "user not found");
        }
        $session = Session::create([
            'user_id' => $user->id
        ]);
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "Sessions created", ['session'=>$session], 201);
    }

    public function showApi(Request $request, $id): HttpJsonResponse
    {
        $user = User::where('api_key',$request->header('api_key'))->first();
        if(!$user){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "user not found");
        }
        $session = Session::where('id',$id)->where('user_id',$user->id)->first();
        if(!$session){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "session not found",null,404);
        }
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "Session found", ['session'=>$session]);
    }

    public function updateApi(Request $request, $id): HttpJsonResponse
    {
        $user = User::where('api_key',$request->header('api_key'))->first();
        if(!$user){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "user not found");
        }
        $session = Session::where('id',$id)->where('user_id',$user->id)->first();
        if(!$session){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "session not found",null,404);
        }
        // TODO modify session

        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "Session modify //TODO", ['session'=>$session]);
    }

    public function deleteApi(Request $request, $id): HttpJsonResponse
    {
        $user = User::where('api_key',$request->header('api_key'))->first();
        if(!$user){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "user not found");
        }
        $session = Session::where('id',$id)->where('user_id',$user->id)->first();
        if(!$session){
            return JsonResponse::response(JsonResponse::STATUS_NOT_FOUND, "session not found",null,404);
        }
        $session->delete();
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "Session removed");
    }
}
