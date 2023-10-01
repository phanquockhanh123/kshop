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

    // delete a category
    Route::delete('/categories/{id}', [Admin\CategoryController::class, 'deleteCategory'])->name('admin.delete-category');
});

Route::prefix('admin')->group(function () {
    Route::get('/discounts', [Admin\DiscountController::class, 'index'])->name('admin.list-discounts');
    Route::get('/discounts/{id}', [Admin\DiscountController::class, 'detail'])->name('admin.detail-discounts');
    Route::delete('/discounts/{id}', [Admin\DiscountController::class, 'deleteDiscount'])->name('admin.delete-discount');
    Route::post('/discounts', [Admin\DiscountController::class, 'create'])->name('admin.create-discounts');
    Route::patch('/discounts/{id}', [Admin\DiscountController::class, 'update'])->name('admin.update-discounts');
});

Route::prefix('admin')->group(function () {
    Route::get('/campaigns', [Admin\CampaignController::class, 'index'])->name('admin.list-campaigns');
    Route::get('/campaigns/{id}', [Admin\CampaignController::class, 'detail'])->name('admin.detail-campaigns');
    Route::delete('/campaigns/{id}', [Admin\CampaignController::class, 'deleteCampaign'])->name('admin.delete-campaigns');
    Route::post('/campaigns', [Admin\CampaignController::class, 'create'])->name('admin.create-campaigns');
    Route::patch('/campaigns/{id}', [Admin\CampaignController::class, 'update'])->name('admin.update-campaigns');
});






