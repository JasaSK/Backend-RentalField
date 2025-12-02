<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\FieldCategoryController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Middleware\CheckLogin;

Route::get('/',  function () {
    return redirect()->route('admin.page.login');
});

Route::get('admin/page/login', [AuthController::class, 'PageLogin'])->name('admin.page.login');

Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::post('/Logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([CheckLogin::class])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/banner', [BannerController::class, 'index'])->name('admin.banner');
    Route::post('/admin/banner/store', [BannerController::class, 'store'])->name('admin.banner.store');
    Route::put('/admin/banner/update/{id}', [BannerController::class, 'update'])->name('admin.banner.update');
    Route::delete('/admin/banner/destroy/{id}', [BannerController::class, 'destroy'])->name('admin.banner.destroy');

    Route::get('/admin/galleries', [GalleryController::class, 'index'])->name('admin.gallery');
    Route::post('/admin/galleries/store', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::put('/admin/galleries/update/{id}', [GalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/admin/galleries/destroy/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

    Route::get('/admin/refund', [RefundController::class, 'index'])->name('admin.refund');
    Route::post('/admin/refund/accept/{id}', [RefundController::class, 'acceptRefund'])->name('admin.refund.accept');
    Route::post('/admin/refund/reject/{id}', [RefundController::class, 'rejectRefund'])->name('admin.refund.reject');

    Route::get('/admin/fields', [FieldController::class, 'index'])->name('admin.fields');
    Route::post('/admin/fields/store', [FieldController::class, 'store'])->name('admin.fields.store');
    Route::put('/admin/fields/update/{id}', [FieldController::class, 'update'])->name('admin.fields.update');
    Route::delete('/admin/fields/destroy/{id}', [FieldController::class, 'destroy'])->name('admin.fields.destroy');

    Route::get('/admin/order', [OrderController::class, 'index'])->name('admin.order');

    Route::get('/admin/field-categories', [FieldCategoryController::class, 'index'])->name('admin.field-categories');
    Route::post('/admin/field-categories/store', [FieldCategoryController::class, 'store'])->name('admin.field-categories.store');
    Route::put('/admin/field-categories/update/{id}', [FieldCategoryController::class, 'update'])->name('admin.field-categories.update');
    Route::delete('/admin/field-categories/destroy/{id}', [FieldCategoryController::class, 'destroy'])->name('admin.field-categories.destroy');

    Route::get('/admin/gallery-categories', [GalleryCategoryController::class, 'index'])->name('admin.gallery-categories');
    Route::post('/admin/gallery-categories/store', [GalleryCategoryController::class, 'store'])->name('admin.gallery-categories.store');
    Route::put('/admin/gallery-categories/update/{id}', [GalleryCategoryController::class, 'update'])->name('admin.gallery-categories.update');
    Route::delete('/admin/gallery-categories/destroy/{id}', [GalleryCategoryController::class, 'destroy'])->name('admin.gallery-categories.destroy');

    Route::get('/admin/maintenance', 
        [MaintenanceController::class, 'index']
    )->name('admin.maintenance');
   
    Route::post('/admin/maintenance/store', 
        [MaintenanceController::class, 'store']
    )->name('admin.maintenance.store');

    Route::get('/admin/maintenance/show/{id}', 
        [MaintenanceController::class, 'show']
    )->name('admin.maintenance.show');

    Route::put('/admin/maintenance/update/{id}', 
        [MaintenanceController::class, 'update']
    )->name('admin.maintenance.update');

    Route::delete('/admin/maintenance/destroy/{id}', 
        [MaintenanceController::class, 'destroy']
    )->name('admin.maintenance.destroy');
});
