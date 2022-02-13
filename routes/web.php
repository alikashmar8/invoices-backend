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

Route::get('/profile/{user}', [App\Http\Controllers\UsersController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/edit-profile-form', [App\Http\Controllers\UsersController::class, 'edit'])->name('edit-profile-form')->middleware('auth');

Route::get('/my-businesses', [App\Http\Controllers\BusinessController::class, 'index'])->name('my-businesses')->middleware('auth');
Route::post('/create-business-form', [App\Http\Controllers\BusinessController::class, 'store'])->name('create-business-form')->middleware('auth');

Route::get('/business/{business}', [App\Http\Controllers\BusinessController::class, 'show'])->middleware('auth');
Route::get('/business/{business}/employees', [App\Http\Controllers\BusinessController::class, 'showEmployees'])->middleware('auth');
