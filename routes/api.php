<?php

use App\Http\Controllers\API\Admin;
use App\Http\Controllers\API\AuthController;
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
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::patch('/reset_password', [AuthController::class, 'resetPassword'])->name('admin.reset-password');
    Route::post('/forgot_password', [AuthController::class, 'forgotPassword'])->name('admin.forgot-password');
});

Route::prefix('admin')->group(function () {
    Route::get('/admins', [Admin\AdminController::class, 'index'])->name('admin.list-admins');
    Route::get('/admins/{id}', [Admin\AdminController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-admins');
    Route::delete('/admins/{id}', [Admin\AdminController::class, 'delete'])->where('id', '[0-9]+')->name('admin.delete-admins');
    Route::post('/admins', [Admin\AdminController::class, 'create'])->name('admin.create-admins');
    Route::post('/admins/{id}', [Admin\AdminController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-admins');
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::patch('/change_password', [AuthController::class, 'changePasswordFirstLogin'])->name('admin.change-password-first-login');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::delete('/confirm_token_reset_password', [AuthController::class, 'confirmResetPasswordToken'])->name('admin.confirm-token-reset-password');
});

Route::prefix('admin')->group(function () {
    Route::post('/create_store_infos', [Admin\StoreInfoController::class, 'create'])->name('admin.create-store-infos');
    Route::patch('/update_store_infos', [Admin\StoreInfoController::class, 'update'])->name('admin.update-store-infos');
});

Route::prefix('admin')->group(function () {
    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('admin.index-categories');
    Route::get('/categories/{id}', [Admin\CategoryController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-category');
    Route::post('/categories', [Admin\CategoryController::class, 'create'])->name('admin.create-category');
    Route::post('/categories/{id}', [Admin\CategoryController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-category');
    Route::delete('/categories/{id}', [Admin\CategoryController::class, 'delete'])->where('id', '[0-9]+')->name('admin.delete-category');
});

Route::prefix('admin')->group(function () {
    Route::get('/sizes', [Admin\SizeController::class, 'index'])->name('admin.index-sizes');
    Route::get('/sizes/{id}', [Admin\SizeController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-size');
    Route::post('/sizes', [Admin\SizeController::class, 'create'])->name('admin.create-size');
    Route::patch('/sizes/{id}', [Admin\SizeController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-size');
    Route::delete('/sizes/{id}', [Admin\SizeController::class, 'delete'])->where('id', '[0-9]+')->name('admin.delete-size');
});

Route::prefix('admin')->group(function () {
    Route::get('/colors', [Admin\ColorController::class, 'index'])->name('admin.index-colors');
    Route::get('/colors/{id}', [Admin\ColorController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-color');
    Route::post('/colors', [Admin\ColorController::class, 'create'])->name('admin.create-color');
    Route::patch('/colors/{id}', [Admin\ColorController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-color');
    Route::delete('/colors/{id}', [Admin\ColorController::class, 'delete'])->where('id', '[0-9]+')->name('admin.delete-color');
});

Route::prefix('admin')->group(function () {
    Route::get('/discounts', [Admin\DiscountController::class, 'index'])->name('admin.list-discounts');
    Route::get('/discounts/{id}', [Admin\DiscountController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-discounts');
    Route::delete('/discounts/{id}', [Admin\DiscountController::class, 'deleteDiscount'])->where('id', '[0-9]+')->name('admin.delete-discount');
    Route::post('/discounts', [Admin\DiscountController::class, 'create'])->name('admin.create-discounts');
    Route::patch('/discounts/{id}', [Admin\DiscountController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-discounts');
});

Route::prefix('admin')->group(function () {
    Route::get('/campaigns', [Admin\CampaignController::class, 'index'])->name('admin.list-campaigns');
    Route::get('/campaigns/{id}', [Admin\CampaignController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-campaigns');
    Route::delete('/campaigns/{id}', [Admin\CampaignController::class, 'deleteCampaign'])->where('id', '[0-9]+')->name('admin.delete-campaigns');
    Route::post('/campaigns', [Admin\CampaignController::class, 'create'])->name('admin.create-campaigns');
    Route::post('/campaigns/{id}', [Admin\CampaignController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-campaigns');
});

Route::prefix('admin')->group(function () {
    Route::get('/products', [Admin\ProductController::class, 'index'])->name('admin.list-products');
    Route::get('/products/{id}', [Admin\ProductController::class, 'detail'])->where('id', '[0-9]+')->name('admin.detail-products');
    Route::delete('/products/{id}', [Admin\ProductController::class, 'deleteProduct'])->where('id', '[0-9]+')->name('admin.delete-products');
    Route::post('/products', [Admin\ProductController::class, 'create'])->name('admin.create-products');
    Route::post('/products/{id}', [Admin\ProductController::class, 'update'])->where('id', '[0-9]+')->name('admin.update-products');
});
