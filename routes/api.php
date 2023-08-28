<?php

use App\Http\Controllers\API\Admin;
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
    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('admin.index-categories');
    Route::get('/categories/{id}', [Admin\CategoryController::class, 'detail'])->name('admin.detail-category');
    Route::post('/categories', [Admin\CategoryController::class, 'create'])->name('admin.create-category');
    Route::patch('/categories/{id}', [Admin\CategoryController::class, 'update'])->name('admin.update-category');
    Route::delete('/categories', [Admin\CategoryController::class, 'delete'])->name('admin.delete-categories');
});




