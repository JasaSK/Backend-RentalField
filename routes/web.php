<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/halaman1', [UserController::class, 'index'])->name('hal1');
