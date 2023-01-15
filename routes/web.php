<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthController;

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

Route::any('/', [FrontendController::class, 'index'])->name('homepage');
Route::any('/variant/{id}', [FrontendController::class, 'formWithVariant']);
Route::any('/feedback', [FrontendController::class, 'sendFeedbackEmail']);
Route::any('/add-feedback', [FrontendController::class, 'newFeedback']);

Route::any('/!/save-feedback', [FrontendController::class, 'storeFeedback']);
Route::any('/sendEmail', [FrontendController::class, 'sendEmail'])->name('sendEmail');

Route::any('/delete-member/{id}', [FrontendController::class, 'deleteMember']);

Route::any('/admin', [FrontendController::class, 'showDashboard'])->name('dashboard')->middleware('auth');
Route::any('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::any('/!/login', [AuthController::class, 'login']);
Route::any('/!/logout', [AuthController::class, 'logout']); /* TODO: logout */
Route::any('/admin/calendar', [FrontendController::class, 'showCalendar'])->name('calendar')->middleware('auth');

Route::any('/newOrder', [FrontendController::class, 'newOrder'])->name('newOrder');
Route::any('/!/saveCustomer', [FrontendController::class, 'saveCustomer'])->name('saveCustomer');
Route::any('/!/finishOrder/{id}', function ($id) {
    Illuminate\Support\Facades\DB::table('calendar')->where('id', $id)->update(['isDone' => 1]);
    return redirect(route('calendar'));
});
Route::any('/!/unfinishOrder/{id}', function ($id) {
    Illuminate\Support\Facades\DB::table('calendar')->where('id', $id)->update(['isDone' => 0]);
    return redirect(route('calendar'));
});
