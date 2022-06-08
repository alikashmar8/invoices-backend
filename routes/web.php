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
Route::get('/businesses/{business}/contacts', [App\Http\Controllers\BusinessController::class, 'getContacts'])->middleware('auth');
Route::get('/businesses/{business}/members', [App\Http\Controllers\BusinessController::class, 'showMembers'])->middleware('auth');
Route::post('/businesses/{business}/members', [App\Http\Controllers\BusinessController::class, 'addNewTeamMember'])->middleware('auth');
Route::post('/businesses/{business}/members/{user}/remove', [App\Http\Controllers\BusinessController::class, 'removeTeamMember'])->middleware('is_business_manager');
Route::post('/businesses/{business}/members/{user}/update-role', [App\Http\Controllers\BusinessController::class, 'updateRole'])->middleware('is_business_manager');

Route::post('/invitations', [App\Http\Controllers\InvitationController::class, 'store'])->middleware('auth');
Route::post('/invitations/{invitation}/accept', [App\Http\Controllers\InvitationController::class, 'accept'])->middleware('auth');
Route::post('/invitations/{invitation}/reject', [App\Http\Controllers\InvitationController::class, 'reject'])->middleware('auth');
Route::post('/invitations/{invitation}/destroy', [App\Http\Controllers\InvitationController::class, 'destroy'])->middleware('auth');

Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markRead'])->middleware('auth')->name('markNotificationAsRead');
Route::post('/notifications/{notification}/mark-unread', [App\Http\Controllers\NotificationController::class, 'markUnread'])->middleware('auth')->name('markNotificationAsUnread');
Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->middleware('auth')->name('deleteNotification');

Route::get('/invoices/create', [App\Http\Controllers\InvoiceController::class, 'create'])->middleware('auth');
Route::post('/invoices', [App\Http\Controllers\InvoiceController::class, 'storeIn'])->middleware('auth')->name('invoices.store');
Route::get('/invoices/{invoice}/edit', [App\Http\Controllers\InvoiceController::class, 'edit'])->middleware('auth');
Route::put('/invoices/{invoice}', [App\Http\Controllers\InvoiceController::class, 'update'])->middleware('auth')->name('invoices.update');
Route::get('/invoices/exportIn/{id}', [App\Http\Controllers\InvoiceController::class, 'exportIn'])->middleware('auth');
Route::get('/invoices/exportOut/{id}', [App\Http\Controllers\InvoiceController::class, 'exportOut'])->middleware('auth');

Route::get('/bills/create', [App\Http\Controllers\BillsController::class, 'create'])->middleware('auth');
Route::post('/bills', [App\Http\Controllers\BillsController::class, 'store'])->middleware('auth')->name('bills.store');
Route::get('/bills/{bill}/generate/pdf', [App\Http\Controllers\BillsController::class, 'generatePDF']);

Route::get('/contacts/business/{business}', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts.index')->middleware('auth');
Route::post('/contacts', [App\Http\Controllers\ContactsController::class, 'store'])->name('contacts.store')->middleware('auth');
Route::delete('/contacts/{contact}', [App\Http\Controllers\ContactsController::class, 'destroy'])->name('contacts.destroy')->middleware('auth');
Route::get('/contacts/create/{business}', [App\Http\Controllers\ContactsController::class, 'create'])->name('contacts.create')->middleware('auth');
Route::get('/contacts/edit/{id}', [App\Http\Controllers\ContactsController::class, 'edit'])->name('contacts.edit')->middleware('auth');
Route::post('/contacts/update', [App\Http\Controllers\ContactsController::class, 'update'])->name('contacts.update')->middleware('auth');


Route::post('/memberCheckerIfExist', [App\Http\Controllers\UsersController::class, 'memberCheckerIfExist'])->middleware('auth')->name('memberCheckerIfExist');

//plans
Route::get('/pricing', function () {return view('plan.pricing');});
Route::get('/plan-{id}', [App\Http\Controllers\UsersController::class, 'registerPlan'])->middleware('auth');
Route::post('/transfer', [App\Http\Controllers\UsersController::class, 'transfer'])->middleware('auth')->name('transfer');

//pdf
