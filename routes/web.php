<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile-{id}', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/myBusinesses', [App\Http\Controllers\BusinessController::class, 'show'])->name('myBusinesses')->middleware('auth');
Route::post('/createBusinessForm', [App\Http\Controllers\BusinessController::class, 'store'])->name('createBusinessForm')->middleware('auth');

Route::get('/business-{id}', [App\Http\Controllers\BusinessController::class, 'showBusiness'])->middleware('auth');
