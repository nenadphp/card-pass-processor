<?php

use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Middleware\isCardValidMiddleware;
use App\Http\Middleware\isObjectValidMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/reception', [ReceptionController::class, 'cardReception'])
    ->middleware([
        isCardValidMiddleware::class,
        isObjectValidMiddleware::class,
    ]);


Route::get('/password-generator', [PasswordGeneratorController::class, 'generate']);
