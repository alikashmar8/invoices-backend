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
Route::post('/edit-business-form/{business}', [App\Http\Controllers\BusinessController::class, 'update'])->name('create-business-form')->middleware('auth');

Route::get('/businesses', [App\Http\Controllers\BusinessController::class, 'index'])->name('businesses')->middleware('auth');
Route::get('/businesses/{business}', [App\Http\Controllers\BusinessController::class, 'show'])->middleware('is_business_member');
Route::post('/businesses/{business}/make-favorite', [App\Http\Controllers\BusinessController::class, 'makeFavorite'])->name('businesses.make-favorite')->middleware('is_business_member');
Route::post('/businesses/{business}/leave', [App\Http\Controllers\BusinessController::class, 'leave'])->name('businesses.leave')->middleware('is_business_member');
Route::get('/businesses/{business}/employees', [App\Http\Controllers\BusinessController::class, 'showMembers'])->middleware('auth');
Route::post('/businesses/{business}/employees', [App\Http\Controllers\BusinessController::class, 'addNewEmployee'])->middleware('auth');
Route::post('/businesses/{business}/employees/{user}/remove', [App\Http\Controllers\BusinessController::class, 'removeTeamMember'])->middleware('is_business_manager');
Route::post('/businesses/{business}/employees/{user}/update-role', [App\Http\Controllers\BusinessController::class, 'updateRole'])->middleware('is_business_manager');

Route::post('/invitations', [App\Http\Controllers\InvitationController::class, 'store'])->middleware('auth');
Route::post('/invitations/{invitation}/accept', [App\Http\Controllers\InvitationController::class, 'accept'])->middleware('auth');
Route::post('/invitations/{invitation}/reject', [App\Http\Controllers\InvitationController::class, 'reject'])->middleware('auth');
Route::post('/invitations/{invitation}/destroy', [App\Http\Controllers\InvitationController::class, 'destroy'])->middleware('auth');

Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markRead'])->middleware('auth')->name('markNotificationAsRead');
Route::post('/notifications/{notification}/mark-unread', [App\Http\Controllers\NotificationController::class, 'markUnread'])->middleware('auth')->name('markNotificationAsUnread');
Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->middleware('auth')->name('deleteNotification');

Route::get('/invoices/create', [App\Http\Controllers\InvoiceController::class, 'create'])->middleware('auth');
Route::get('/invoices/createDefault', [App\Http\Controllers\InvoiceController::class, 'createDefault'])->middleware('auth');
Route::get('/invoices/edit/{invoice}', [App\Http\Controllers\InvoiceController::class, 'edit'])->middleware('auth');
Route::post('/editInvoiceForm/{invoice}', [App\Http\Controllers\InvoiceController::class, 'update'])->middleware('auth')->name('editInvoiceForm');

Route::post('/createInvoiceForm', [App\Http\Controllers\InvoiceController::class, 'store'])->middleware('auth');

Route::post('/memberCheckerIfExist', [App\Http\Controllers\UsersController::class, 'memberCheckerIfExist'])->middleware('auth')->name('memberCheckerIfExist');
