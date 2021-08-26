<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', LoginController::class);
Route::post('register', RegisterController::class);
Route::post('forgot', ForgotPasswordController::class);
Route::post('reset', ResetPasswordController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('me', MeController::class);
    Route::post('logout', LogoutController::class);
});

Route::fallback(function(){
	return abort(404);
});
