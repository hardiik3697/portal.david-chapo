<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentOnlineController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StripeController;

/** Grouping under */
Route::group(['middleware' => ['prevent-back-history']], function () {
    Route::group(['middleware' => ['guest']], function () {
        /** Authentication */
            Route::controller(AuthController::class)
                    ->group(function () {
                        Route::get('/login', 'login')->name('login');
                        Route::post('/signin', 'signin')->name('signin');
                    });
        /** Authentication */
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        /** Dashboard */
            Route::get('/', [IndexController::class, 'index'])->name('index');
            Route::get('/generate', [IndexController::class, 'generate'])->name('generate');
        /** Dashboard */

        /** Setting */
            Route::controller(SettingController::class)
                    ->prefix('/setting')
                    ->name('setting.')
                    ->group(function () {
                        Route::get('/{param?}', 'index')->name('index');
                        Route::post('/update', 'update')->name('update');
                    });
        /** Setting */

        /** Platform */
            Route::controller(PlatformController::class)
                    ->prefix('/platform')
                    ->name('platform.')
                    ->group(function () {
                        Route::any('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::match(['post', 'patch'], '/store', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::get('/view/{id}', 'view')->name('view');
                        Route::post('/status', 'status')->name('status');
                    });
        /** Platform */

        /** Users */
            Route::controller(UserController::class)
                    ->prefix('/users')
                    ->name('users.')
                    ->group(function () {
                        Route::any('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::match(['post', 'patch'], '/store', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::get('/view/{id}', 'view')->name('view');
                        Route::post('/status', 'status')->name('status');
                    });
        /** Users */

        /** Stripe */
            Route::controller(StripeController::class)
                    ->prefix('/stripes')
                    ->name('stripes.')
                    ->group(function () {
                        Route::any('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::match(['post', 'patch'], '/store', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::get('/view/{id}', 'view')->name('view');
                        Route::post('/status', 'status')->name('status');
                    });
        /** Stripe */

        /** Customers */
            Route::controller(CustomerController::class)
                    ->prefix('/customers')
                    ->name('customers.')
                    ->group(function () {
                        Route::any('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::match(['post', 'patch'], '/store', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::get('/view/{id}', 'view')->name('view');
                        Route::post('/status', 'status')->name('status');
                    });
        /** Customers */

        /** Payments */
            Route::controller(PaymentController::class)
                    ->prefix('/payment')
                    ->name('payment.')
                    ->group(function () {
                        Route::any('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::match(['post', 'patch'], '/store', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::get('/view/{id}', 'view')->name('view');
                        Route::post('/status', 'status')->name('status');
                        Route::get('/search-user', 'searchUser')->name('search-user');
                        Route::get('/get-user/{id?}', 'getUser')->name('get-user');
                        Route::get('/get-username', 'getUsername')->name('get-username');
                    });
        /** Payments */

        /** Payment-online */
            Route::controller(PaymentOnlineController::class)
                    ->prefix('/paymentOnline')
                    ->name('paymentOnline.')
                    ->group(function () {
                        Route::post('/status', 'status')->name('status');
                        Route::any('/{id?}', 'index')->name('index');
                        Route::get('/view/{id}', 'view')->name('view');
                    });
        /** Payment-online */

        /** Category */
            Route::controller(CategoryController::class)
                    ->prefix('/category')
                    ->name('category.')
                    ->group(function () {
                        Route::any('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::match(['post', 'patch'], '/store', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::get('/view/{id}', 'view')->name('view');
                        Route::post('/status', 'status')->name('status');
                    });
        /** Category */

        /** Random route to login route */
            Route::get("{path}", function () { return redirect()->route('index'); })->where('path', '.+');
        /** Random route to login route */
    });
});
