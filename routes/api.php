<?php

use App\Http\Controllers\API;
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

Route::get('/health-check', [API\HealthCheckController::class, 'index'])->name('health_check');

Route::prefix('admin')->group(function () {
    Route::controller(API\AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('admin.login');
        Route::patch('/reset_password', 'resetPassword')->name('admin.reset-password');
        Route::get('/confirm_token_reset_password', 'confirmResetPasswordToken')
            ->name('admin.confirm-reset-password-token');
        Route::post('/forgot_password', 'forgotPassword')->name('admin.forgot-password');
    });
    Route::middleware(['auth:sanctum', 'auth.first_login'])->group(function () {
        Route::controller(API\AuthController::class)->middleware([config('const.auth.low')])->group(function () {
            Route::patch('/change_password', 'changePasswordFirstLogin')
                ->name('admin.change_password')->withoutMiddleware(['auth.first_login']);
            Route::delete('/logout', 'logout')->name('admin.logout');
        });
    });
});

Route::post('/save-json', [API\FabbiController::class, 'saveJson'])->name('save_json');


