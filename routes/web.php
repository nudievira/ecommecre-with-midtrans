<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Transaction\BucketController;
use App\Http\Controllers\Transaction\ProductCustomerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\UserManagement\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('authenticate', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');

Route::group(['controller' => AuthController::class, 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
});
/**
 * Home Route
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::group(['controller' => ProductController::class, 'prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('index', 'index')->name('index');
        Route::get('show', 'show')->name('show');
        Route::post('update', 'update')->name('update');
        Route::get('data-table', 'dataTable')->name('dataTable');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    });

    Route::group(['controller' => ProductCustomerController::class, 'prefix' => 'product-customer', 'as' => 'product-customer.'], function () {
        Route::get('index', 'index')->name('index');
    });

    Route::group(['controller' => BucketController::class, 'prefix' => 'cart', 'as' => 'cart.'], function () {
        Route::get('index', 'index')->name('index');
        Route::post('store/{id}', 'store')->name('store');
        Route::post('update-qty', 'updateQty')->name('updateQty');
    });

    Route::group(['controller' => TransactionController::class, 'prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('index', 'index')->name('index');
        Route::get('show/{id}', 'show')->name('show');
        Route::get('data-table', 'dataTable')->name('dataTable');
        Route::post('store', 'store')->name('store');
        Route::get('payment/{id}', 'payment')->name('payment');
    });

    Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');
    Route::post('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');    


});
