<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryFieldController;
use App\Http\Controllers\CategoryGalleryController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/resend-code', [AuthController::class, 'resendCode']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/banners', [BannerController::class, 'index']);
Route::get('/banners/{id}', [BannerController::class, 'show']);

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{id}', [GalleryController::class, 'show']);

Route::get('/field', [FieldController::class, 'index']);
Route::get('/field/{id}', [FieldController::class, 'show']);

Route::get('/schedule', [ScheduleController::class, 'index']);
Route::get('/schedule/{id}', [ScheduleController::class, 'show']);

Route::get('/category-field', [CategoryFieldController::class, 'index']);
Route::get('/category-field/{id}', [CategoryFieldController::class, 'show']);

Route::get('/category-gallery', [CategoryGalleryController::class, 'index']);
Route::get('/category-gallery/{id}', [CategoryGalleryController::class, 'show']);

Route::middleware(['auth:sanctum', RoleMiddleware::class . ':admin'])->group(function () {

    Route::post('/category-field', [CategoryFieldController::class, 'store']);
    Route::put('/category-field/{id}', [CategoryFieldController::class, 'update']);
    Route::delete('/category-field/{id}', [CategoryFieldController::class, 'destroy']);

    Route::post('/field', [FieldController::class, 'store']);
    Route::put('/field/{id}', [FieldController::class, 'update']);
    Route::delete('/field/{id}', [FieldController::class, 'destroy']);

    Route::post('/banners', [BannerController::class, 'store']);
    Route::put('/banners/{id}', [BannerController::class, 'update']);
    Route::delete('/banners/{id}', [BannerController::class, 'destroy']);

    Route::post('/category-gallery', [CategoryGalleryController::class, 'store']);
    Route::put('/category-gallery/{id}', [CategoryGalleryController::class, 'update']);
    Route::delete('/category-gallery/{id}', [CategoryGalleryController::class, 'destroy']);

    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::put('/galleries/{id}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);

    Route::post('/schedule', [ScheduleController::class, 'store']);
    Route::put('/schedule/{id}', [ScheduleController::class, 'update']);
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy']);

    Route::get('/booking', [BookingController::class, 'index']);
    Route::get('/booking/{id}', [BookingController::class, 'show']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::put('/booking/{id}', [BookingController::class, 'update']);
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']);
});
Route::post('/payment/create/{booking_id}', [PaymentController::class, 'createPayment']);
Route::post('/payment/midtrans-callback', [PaymentController::class, 'midtransCallback']);
