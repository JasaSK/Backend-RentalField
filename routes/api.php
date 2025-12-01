<?php

use App\Http\Controllers\RefundController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryFieldController;
use App\Http\Controllers\CategoryGalleryController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TicketController;
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
Route::get('/schedule/{id}', [ScheduleController::class, 'show']);

Route::get('/category-fields', [CategoryFieldController::class, 'index']);
Route::get('/category-fields/{id}', [CategoryFieldController::class, 'show']);

Route::get('/category-gallery', [CategoryGalleryController::class, 'index']);
Route::get('/category-gallery/{id}', [CategoryGalleryController::class, 'show']);
Route::get('bookings/booked-hours/{fieldId}', [BookingController::class, 'bookedHours']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/booking/{id}', [BookingController::class, 'show']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::put('/booking/{id}', [BookingController::class, 'update']);
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']);
    Route::get('/booking-history', [BookingController::class, 'history']);

    // User Ajukan Refund
    Route::post('/refund/request/{bookingId}', [RefundController::class, 'requestRefund']);

    // Admin — Approve & Process
    Route::post('/refund/approve/{id}', [RefundController::class, 'approveRefund']);
    Route::post('/refund/process/{id}', [RefundController::class, 'processRefund']);

    // Admin — List & Detail
    Route::get('/refunds', [RefundController::class, 'index']);
    Route::get('/refunds/{id}', [RefundController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/booking', [BookingController::class, 'index']);

    Route::post('/category-fields', [CategoryFieldController::class, 'store']);
    Route::put('/category-fields/{id}', [CategoryFieldController::class, 'update']);
    Route::delete('/category-fields/{id}', [CategoryFieldController::class, 'destroy']);

    Route::post('/fields', [FieldController::class, 'store']);
    Route::put('/fields/{id}', [FieldController::class, 'update']);
    Route::delete('/fields/{id}', [FieldController::class, 'destroy']);

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
});
Route::post('/payment/create-qris/{booking_id}', [PaymentController::class, 'createQrisPayment']);
Route::post('/payment/midtrans/callback', [PaymentController::class, 'midtransCallback']);

Route::get('/ticket/{id}', [TicketController::class, 'showTicket']);
Route::get('/booking/{id}/ticket', [TicketController::class, 'downloadTicket']);
Route::post('/ticket/verify', [TicketController::class, 'verifyTicket']);
