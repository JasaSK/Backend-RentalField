<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Tes route awal API
Route::get('/ping', function () {
    return response()->json(['message' => 'API aktif!']);
});
