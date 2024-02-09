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

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'showDashboard'])->name('dashboard');

    Route::get('invoices', [AdminController::class, 'showInvoices'])->name('admin.invoices');
    Route::any('showInvoice/{id}', [AdminController::class, 'showInvoice'])->name('showInvoice');

    Route::get('customers', [AdminController::class, 'showCustomers'])->name('admin.customers');
    Route::post('saveCustomer', [AdminController::class, 'saveCustomer'])->name('saveCustomer');
    Route::any('updateCustomer/{id}', [AdminController::class, 'updateCustomer'])->name('updateCustomer');
    Route::any('exportCustomers', [ExportController::class, 'exportCustomers'])->name('export');
    Route::any('archive-customer/{id}', [AdminController::class, 'archiveCustomer'])->name('archiveCustomer');
    Route::get('deleteCustomer/{id}', [AdminController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::any('newOrder', [AdminController::class, 'newOrder'])->name('newOrder');

    Route::get('feedback', [AdminController::class, 'showFeedback'])->name('admin.feedback');
    Route::any('refresh-feedbacks', [AdminController::class, 'refreshFeedbacks'])->name('admin.feedbacks.refresh');

    Route::get('vouchers', [AdminController::class, 'showVouchers'])->name('admin.vouchers');
    Route::any('generateVoucher/{price}', [AdminController::class, 'generateVoucher'])->name('generateVoucher');
    Route::post('validateVoucher', [AdminController::class, 'validateVoucher'])->name('validateVoucher');
    Route::any('useVoucher', [AdminController::class, 'useVoucher'])->name('useVoucher');
    Route::any('showVoucher', [AdminController::class, 'showVoucher'])->name('showVoucher');
    Route::any('generateMiniVoucher/{hex}', [AdminController::class, 'generateMiniVoucher'])->name('generateMiniVoucher');

    Route::get('development', [AdminController::class, 'showDevelopment'])->name('admin.development');

    Route::get('log/{type}', [AdminController::class, 'showErrorLog'])->name('admin.errorlog');
});

/* CRONY */
Route::any('cron/today', [CronController::class, 'today'])->name('cron.today');
Route::any('cron/bill', [CronController::class, 'bill'])->name('cron.bill');
