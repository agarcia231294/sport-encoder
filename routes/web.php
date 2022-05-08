<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
})->name('home');


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', [DashboardController::class, 'home'])->name('dashboard.home');
Route::get('dashboard/sessions', [DashboardController::class, 'indexSessions'])->name('dashboard.sessions');
Route::get('dashboard/sessions/{id}', [DashboardController::class, 'showSession'])->name('dashboard.session');
Route::get('dashboard/sessions/{id}/graph', [DashboardController::class, 'showGraph'])->name('dashboard.session');
Route::get('dashboard/apikey', [DashboardController::class, 'apiKey'])->name('dashboard.apikey');
Route::get('dashboard/apikey/regenerate', [DashboardController::class, 'apiKeyRegenerate'])->name('dashboard.apikey.regenerate');