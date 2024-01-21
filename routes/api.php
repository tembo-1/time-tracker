<?php

use App\Http\Controllers\API\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'owner'], function () {

});

Route::get('/treolan',                                  [ApiController::class,      'treolan']);
Route::get('/merlion',                                  [ApiController::class,      'merlion']);
Route::get('/rm',                                       [ApiController::class,      'rm']);
Route::get('/marvel',                                   [ApiController::class,      'marvel']);
Route::get('/nvprint',                                  [ApiController::class,      'nvprint']);
Route::get('/resurs-media',                             [ApiController::class,      'resursMedia']);
Route::get('/currency',                                 [ApiController::class,      'currency']);
