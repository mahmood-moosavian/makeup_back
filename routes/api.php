<?php

use App\Http\Controllers\API\V1\Auth\ConfirmCodeController;
use App\Http\Controllers\API\V1\Auth\EnterMobileController;
use App\Http\Controllers\API\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\API\V1\Auth\ResetPasswordController;
use App\Http\Controllers\API\V1\Auth\VerificationController;
use App\Http\Controllers\API\V1\UserController;
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

Route::prefix('v1')->group(function () {
    /*
     * Auth
     */
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::post('entermobile', [EnterMobileController::class, 'getMobile']);//->middleware('throttle:smsattemp');
    Route::post('confirmCode', [ConfirmCodeController::class, 'confirmCode']);//->middleware('throttle:smsattemp');

    /*
     * User
     */
    Route::get('user', [UserController::class, 'show']);

    Route::patch('user', [UserController::class, 'update']);

    Route::delete('user', [UserController::class, 'destroy']);
});
