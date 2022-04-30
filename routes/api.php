<?php

use App\Http\Middleware\ApiAuth;
use App\Http\Share\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware([ApiAuth::class])->group(function () {
    
    /** 
     * Sessions Routes
    */
    Route::get('sessions', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::get('sessions/{id}', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::post('sessions', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::put('sessions/{id}', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::delete('sessions/{id}', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });


    /** 
     * Distances Routes
    */
    Route::get('sessions/{id}/distances', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::get('sessions/{id}/distances/stadistics', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::post('sessions/{id}/distances', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });
    Route::delete('sessions/{id}/distances/{timestamp}', function() {
        return JsonResponse::response(JsonResponse::STATUS_SUCCESS, "TODO");
    });

});