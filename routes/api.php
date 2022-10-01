<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProductController::class)->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('get', 'getProducts');
        Route::post('save', 'saveProduct');
        Route::get('show', 'showProduct');
        Route::get('delete', 'deleteProduct');
    });
});
