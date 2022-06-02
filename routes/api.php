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
    Route::post(  'sessions',     'SessionController@createApi');
    // Route::get(   'sessions',     'SessionController@indexApi');
    // Route::get(   'sessions/{id}','SessionController@showApi');
    // Route::put(   'sessions/{id}','SessionController@updateApi');
    // Route::delete('sessions/{id}','SessionController@deleteApi');

    /** 
     * Distances Routes
    */
    Route::post('sessions/{sesion_id}/distances','DistanceController@createApi');

});