<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\VinController;
use App\Http\Controllers\VouchersController;
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

    Route::resource('invoices', InvoicesController::class)->except('create','store','destroy');

    Route::get('customers', [AdminController::class, 'showCustomers'])->name('admin.customers');
    Route::post('saveCustomer', [AdminController::class, 'saveCustomer'])->name('saveCustomer');
    Route::any('updateCustomer', [AdminController::class, 'updateCustomer'])->name('updateCustomer');
    Route::any('exportCustomers', [ExportController::class, 'exportCustomers'])->name('export');
    Route::any('archive-customer/{id}', [AdminController::class, 'archiveCustomer'])->name('archiveCustomer');
    Route::get('deleteCustomer/{id}', [AdminController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::any('newOrder', [AdminController::class, 'newOrder'])->name('newOrder');

    Route::get('feedback', [AdminController::class, 'showFeedback'])->name('admin.feedback');
    Route::any('refresh-feedbacks', [AdminController::class, 'refreshFeedbacks'])->name('admin.feedbacks.refresh');

    Route::resource('vouchers', VouchersController::class)->except('store');
    Route::group(['prefix' => 'vouchers'], function () {
        Route::post('validate', [VouchersController::class, 'validateVoucher'])->name('vouchers.validate');
        Route::any('validate/use', [VouchersController::class, 'useVoucher'])->name('vouchers.use');
    });

    Route::get('development', [AdminController::class, 'showDevelopment'])->name('admin.development');

    Route::get('log/{type}', [AdminController::class, 'showErrorLog'])->name('admin.errorlog');

    Route::resource('vin', VinController::class)->except('show');
});

/* CRONY */
Route::group(['prefix' => 'cron'], function () {
    Route::any('today', [CronController::class, 'today'])->name('cron.today');
    Route::any('bill', [CronController::class, 'bill'])->name('cron.bill');
});
