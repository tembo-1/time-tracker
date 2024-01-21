<?php

use App\Http\Controllers\Site\Auth\LoginController;
use App\Http\Controllers\Site\Auth\RegisterController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\SiteController;
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

/**
 * Public routers
 */
//Route::get('/',                                             [SiteController::class,     'index'])->name('mainPage');
//Route::get('/catalog',                                      [SiteController::class,     'index'])->name('catalogPage');
//Route::get('/catalog/products',                             [SiteController::class,     'index']);
//Route::get('/help',                                         [SiteController::class,     'index']);
//
///**
// * Routes for authorization
// */
//Route::group(['middleware' => 'guest'], function () {
//    Route::get('/login',                                    [SiteController::class,     'index'])->name('authPage');
//    Route::post('/login',                                   [LoginController::class,    'login'])->name('login');
//
//    Route::get('/registration',                             [SiteController::class,     'index']);
//    Route::post('/registration',                            [RegisterController::class, 'store']);
//});
//
///**
// * Secure routers for the manager
// */
//Route::group(['middleware' => ['auth', 'manager']], function () {
//    Route::get('/manager/orders',                           [SiteController::class,     'index']);
//    Route::get('/manager/requests',                         [SiteController::class,     'index']);
//});
//
///**
// * Secure routers for the user/client
// */
//Route::group(['middleware' => ['auth', 'user']], function () {
//    Route::get('/cart',                                     [SiteController::class,     'index']);
//    Route::get('/orders',                                   [SiteController::class,     'index']);
//    Route::get('/cartItems',                                [CartController::class,     'index']);
//});
//
///**
// * Public routers for authorized users
// */
//Route::group(['middleware' => 'auth'], function () {
//    Route::get('/logout',                                   [LoginController::class,    'logout']);
//});

