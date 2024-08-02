<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\VerifyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Route::get('/user/profile', function () {
    //     // Uses first & second middleware...
    // });
});
require __DIR__ . '/auth.php';
