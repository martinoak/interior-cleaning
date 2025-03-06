<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\VehicleController;
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
Route::any('add-feedback', [HomepageController::class, 'newFeedback'])->name('addFeedback');
Route::post('save-feedback', [HomepageController::class, 'storeFeedback'])->name('storeFeedback');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::middleware('can:cleaning,admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('invoices', InvoicesController::class)->except('destroy');

        Route::resource('customers', CustomersController::class)->except('show');
        Route::group(['prefix' => 'customers'], function () {
            Route::any('export', [ExportController::class, 'exportCustomers'])->name('invoices.export');
            Route::any('archive/{id}', [CustomersController::class, 'archive'])->name('archiveCustomer');
        });

        Route::get('feedback', [AdminController::class, 'showFeedback'])->name('admin.feedback');
        Route::any('refresh-feedbacks', [AdminController::class, 'refreshFeedbacks'])->name('admin.feedbacks.refresh');

        Route::resource('vouchers', VouchersController::class)->except('create', 'edit', 'update');
        Route::group(['prefix' => 'vouchers'], function () {
            Route::post('validate', [VouchersController::class, 'validateVoucher'])->name('vouchers.validate');
            Route::any('validate/use', [VouchersController::class, 'useVoucher'])->name('vouchers.use');
        });
    });

    Route::middleware('can:admin')->group(function () {
        Route::get('development', [AdminController::class, 'showDevelopment'])->name('admin.development');

        Route::get('log/{type}', [AdminController::class, 'showErrorLog'])->name('admin.errorlog');
    });

    Route::middleware('can:car-park')->group(function () {
        Route::resource('vin', VinController::class)->except('show');
        Route::resource('vehicles', VehicleController::class)->except('store', 'update', 'destroy');
    });
});

/* CRONY */
Route::group(['prefix' => 'cron'], function () {
    Route::any('today', [CronController::class, 'today'])->name('cron.today');
    Route::any('bill', [CronController::class, 'bill'])->name('cron.bill');
    Route::any('invalidate-vouchers', [CronController::class, 'invalidateVouchers'])->name('cron.invalidate-vouchers');
});
