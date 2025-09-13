<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\OniController;
use App\Http\Controllers\Admin\ServiceBookController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\VinController;
use App\Http\Controllers\Admin\VouchersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CronController;
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
            Route::any('export', [CustomersController::class, 'exportCustomers'])->name('invoices.export');
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
        Route::resource('users', UsersController::class)->except(['show', 'destroy'])->names('admin.users');

        Route::get('log/{type}', [AdminController::class, 'showErrorLog'])->name('admin.errorlog');
    });

    Route::middleware(['can:car-park'])->group(function () {
        Route::resource('vin', VinController::class)->except('show');
        Route::resource('vehicles', VehicleController::class);
        Route::get('vehicles/vtp/{filename}', [VehicleController::class, 'serveVTP'])->name('vtp');
        Route::resource('vehicles/{vehicle}/service-book', ServiceBookController::class)
            ->except('show')
            ->parameters([
                'service-book' => 'id',
            ])
            ->names('service-book');
        Route::get('vehicles/service-book/attachments/{id}', [ServiceBookController::class, 'serveAttachment'])->name('attachment');

        Route::resource('oni', OniController::class)->only('index', 'show');
    });
});

/* CRONY */
Route::group(['prefix' => 'cron'], function () {
    Route::any('today', [CronController::class, 'today'])->name('cron.today');
    Route::any('bill', [CronController::class, 'bill'])->name('cron.bill');
    Route::any('invalidate-vouchers', [CronController::class, 'invalidateVouchers'])->name('cron.invalidate-vouchers');
    Route::any('car-park', [CronController::class, 'carPark'])->name('cron.car-park');
});
