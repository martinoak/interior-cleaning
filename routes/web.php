<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

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

Route::any('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
Route::any('/delete-member/{id}', [FrontendController::class, 'deleteMember']);
