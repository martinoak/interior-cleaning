<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomepageController;
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

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::any('sendEmail', [HomepageController::class, 'sendEmail'])->name('sendEmail');
Route::any('feedback', [HomepageController::class, 'sendFeedbackEmail'])->name('feedback');
Route::match(['get', 'post'], 'setVariant', [HomepageController::class, 'setVariant'])->name('setVariant');
Route::any('add-feedback', [HomepageController::class, 'newFeedback'])->name('addFeedback');
Route::post('save-feedback', [HomepageController::class, 'storeFeedback'])->name('storeFeedback');
Route::any('delete-feedback/{id}', [HomepageController::class, 'deleteFeedback'])->name('deleteFeedback');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('admin', [AdminController::class, 'showDashboard'])->name('dashboard')->middleware('auth');

Route::get('admin/calendar', [AdminController::class, 'showCalendar'])->name('admin.calendar')->middleware('auth');
Route::any('deleteCalendarNote/{id}', function ($id) {
    \Illuminate\Support\Facades\DB::table('calendar')->where('id', $id)->delete();

    return to_route('admin.calendar');
})->name('deleteCalendarNote');
Route::post('saveCalendarEvent', [AdminController::class, 'saveCalendarEvent'])->name('saveCalendarEvent');
Route::any('finishOrder/{id}', function ($id) {
    \Illuminate\Support\Facades\DB::table('calendar')->where('id', $id)->update(['isDone' => 1]);

    return to_route('admin.calendar');
})->name('finishOrder');
Route::any('unfinishOrder/{id}', function ($id) {
    \Illuminate\Support\Facades\DB::table('calendar')->where('id', $id)->update(['isDone' => 0]);

    return to_route('admin.calendar');
})->name('unfinishOrder');

Route::get('admin/invoices', [AdminController::class, 'showInvoices'])->name('admin.invoices')->middleware('auth');
Route::any('generateInvoice/{id}', [AdminController::class, 'generateInvoice'])->name('generateInvoice');
Route::post('saveInvoice', [AdminController::class, 'saveInvoice'])->name('saveInvoice');

Route::get('admin/customers', [AdminController::class, 'showCustomers'])->name('admin.customers')->middleware('auth');
Route::post('saveCustomer', [AdminController::class, 'saveCustomer'])->name('saveCustomer');
Route::any('exportCustomers', [ExportController::class, 'exportCustomers'])->name('export');
Route::any('archive-member/{id}', [AdminController::class, 'archiveMember'])->name('archiveMember');
Route::any('newOrder', [AdminController::class, 'newOrder'])->name('newOrder');

Route::get('admin/feedback', [AdminController::class, 'showFeedback'])->name('admin.feedback')->middleware('auth');

Route::get('admin/vouchers', [AdminController::class, 'showVouchers'])->name('admin.vouchers')->middleware('auth');
Route::any('generateVoucher', [AdminController::class, 'generateVoucher'])->name('generateVoucher');
Route::post('validateVoucher', [AdminController::class, 'validateVoucher'])->name('validateVoucher');
Route::any('useVoucher', [AdminController::class, 'useVoucher'])->name('useVoucher');
Route::any('admin/showVoucher', [AdminController::class, 'showVoucher'])->name('showVoucher')->middleware('auth');
Route::any('generateMiniVoucher/{hex}', [AdminController::class, 'generateMiniVoucher'])->name('generateMiniVoucher');

Route::get('admin/log/{type}', [AdminController::class, 'showErrorLog'])->name('admin.errorlog')->middleware('auth');

/* CRONY */
Route::any('cron/weekend', [CronController::class, 'weekend'])->name('cron.weekend');
Route::any('cron/bill', [CronController::class, 'bill'])->name('cron.bill');
