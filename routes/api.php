<?php

use App\Http\Controllers\Api\RefundController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CategoryFieldController;
use App\Http\Controllers\Api\CategoryGalleryController;
use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TicketController;
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

Route::get('/fields', [FieldController::class, 'index']);
Route::get('/fields/{id}', [FieldController::class, 'show']);
Route::post('/fields/search', [FieldController::class, 'search']);

Route::get('/schedule', [ScheduleController::class, 'index']);
Route::get('/schedule/{fieldId}', [ScheduleController::class, 'show']);

Route::get('/category-fields', [CategoryFieldController::class, 'index']);
Route::get('/category-fields/{id}', [CategoryFieldController::class, 'show']);

Route::get('/category-gallery', [CategoryGalleryController::class, 'index']);
Route::get('/category-gallery/{id}', [CategoryGalleryController::class, 'show']);
Route::get('bookings/booked-hours/{fieldId}', [BookingController::class, 'bookedHours']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/booking/{id}', [BookingController::class, 'show']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']);
    Route::get('/booking-history', [BookingController::class, 'history']);
    //    
    Route::put('/booking/{id}', [BookingController::class, 'update']);
    //
    
    Route::post('/refund/request', [RefundController::class, 'requestRefund']);
    Route::get('/refund/user', [RefundController::class, 'getRefund']);
    Route::get('/refund/{id}', [RefundController::class, 'show']);
    
    Route::post('/payment/create-qris/{booking_id}', [PaymentController::class, 'createQrisPayment']);
    Route::get('/payment/{booking_id}', [PaymentController::class, 'getQris']);
    Route::post('/payment/{booking_id}/expire', [PaymentController::class, 'expirePayment']);
    
    Route::get('/ticket/{booking_id}', [TicketController::class, 'showTicket']);
    Route::get('/booking/{id}/ticket', [TicketController::class, 'downloadTicket']);
});
Route::get('/booking/status/{id}', [BookingController::class, 'getStatus']);
Route::post('/payment/midtrans/callback', [PaymentController::class, 'midtransCallback']);