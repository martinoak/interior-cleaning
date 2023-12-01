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

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('admin', [AdminController::class, 'showDashboard'])->name('dashboard')->middleware('auth');

Route::get('admin/invoices', [AdminController::class, 'showInvoices'])->name('admin.invoices')->middleware('auth');
Route::any('showInvoice/{id}', [AdminController::class, 'showInvoice'])->name('showInvoice')->middleware('auth');

Route::get('admin/customers', [AdminController::class, 'showCustomers'])->name('admin.customers')->middleware('auth');
Route::post('saveCustomer', [AdminController::class, 'saveCustomer'])->name('saveCustomer');
Route::any('exportCustomers', [ExportController::class, 'exportCustomers'])->name('export');
Route::any('archive-customer/{id}', [AdminController::class, 'archiveCustomer'])->name('archiveCustomer');
Route::any('newOrder', [AdminController::class, 'newOrder'])->name('newOrder');

Route::get('admin/feedback', [AdminController::class, 'showFeedback'])->name('admin.feedback')->middleware('auth');

Route::get('admin/vouchers', [AdminController::class, 'showVouchers'])->name('admin.vouchers')->middleware('auth');
Route::any('generateVoucher/{price}', [AdminController::class, 'generateVoucher'])->name('generateVoucher');
Route::post('validateVoucher', [AdminController::class, 'validateVoucher'])->name('validateVoucher');
Route::any('useVoucher', [AdminController::class, 'useVoucher'])->name('useVoucher');
Route::any('admin/showVoucher', [AdminController::class, 'showVoucher'])->name('showVoucher')->middleware('auth');
Route::any('generateMiniVoucher/{hex}', [AdminController::class, 'generateMiniVoucher'])->name('generateMiniVoucher');

Route::get('admin/log/{type}', [AdminController::class, 'showErrorLog'])->name('admin.errorlog')->middleware('auth');

/* CRONY */
Route::any('cron/weekend', [CronController::class, 'weekend'])->name('cron.weekend');
Route::any('cron/bill', [CronController::class, 'bill'])->name('cron.bill');
