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

Route::post('/create-business-form', [App\Http\Controllers\BusinessController::class, 'store'])->name('create-business-form')->middleware('auth');

Route::get('/businesses', [App\Http\Controllers\BusinessController::class, 'index'])->name('businesses')->middleware('auth');
Route::get('/businesses/{business}', [App\Http\Controllers\BusinessController::class, 'show'])->middleware('auth');
Route::get('/businesses/{business}/employees', [App\Http\Controllers\BusinessController::class, 'showMembers'])->middleware('auth');
Route::post('/businesses/{business}/employees', [App\Http\Controllers\BusinessController::class, 'addNewEmployee'])->middleware('auth');

Route::post('/invitations', [App\Http\Controllers\InvitationController::class, 'store'])->middleware('auth');
Route::post('/invitations/{invitation}/accept', [App\Http\Controllers\InvitationController::class, 'accept'])->middleware('auth');
Route::post('/invitations/{invitation}/reject', [App\Http\Controllers\InvitationController::class, 'reject'])->middleware('auth');

Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markRead'])->middleware('auth')->name('markNotificationAsRead');
Route::post('/notifications/{notification}/mark-unread', [App\Http\Controllers\NotificationController::class, 'markUnread'])->middleware('auth')->name('markNotificationAsUnread');
Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->middleware('auth')->name('deleteNotification');


Route::post('/memberCheckerIfExist', [App\Http\Controllers\UsersController::class, 'memberCheckerIfExist'])->middleware('auth')->name('memberCheckerIfExist');
