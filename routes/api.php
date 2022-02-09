<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;

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
Route::group([
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::post('refresh', [AuthApiController::class, 'refresh']);
    Route::post('me', [AuthApiController::class, 'me']);

});
