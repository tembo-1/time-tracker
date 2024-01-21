<?php

use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\TaskController;
use App\Http\Controllers\Site\TaskTimerController;
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
 * Secure routers for the manager
 */
//Route::group(['middleware' => ['auth', 'manager']], function () {
//
//});
//

Route::post('/project',                 [ProjectController::class,    'store']);
Route::post('/task',                    [TaskController::class,       'store']);
Route::post('/startTimer',              [TaskTimerController::class,  'store']);
Route::post('/endTimer',                [TaskTimerController::class,  'update']);

//
///**
// * Secure routers for the user/client
// */
//Route::group(['middleware' => ['auth', 'user']], function () {
//
//});
//
///**
// * Public routers for authorized users
// */
//Route::group(['middleware' => 'auth'], function () {
//
//});
