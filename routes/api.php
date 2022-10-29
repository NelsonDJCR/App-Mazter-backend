<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    Route::controller(ProductController::class)->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('get', 'getProducts');
            Route::post('save', 'saveProduct');
            Route::post('show', 'showProduct');
            Route::get('delete', 'deleteProduct');
        });
    });

    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::controller(ProductController::class)->group(function () {
            Route::post('test', 'test');
        });
    });
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
    });


    Route::controller(ShoppingCartController::class)->group(function (){
        Route::post('registerProductShoppingCart', 'registerProductShoppingCart');
        Route::post('getProductShoppingCart', 'getProductShoppingCart');
        Route::post('changeAmountProductShoppingCart', 'changeAmountProductShoppingCart');
    });

    
});

