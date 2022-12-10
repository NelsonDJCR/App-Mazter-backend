<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\inventory\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Test;

Route::prefix('v1')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard_homeDetails', 'dashboard_homeDetails');
    });
    
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::get('logout', 'logout');
    });

    Route::group(["middleware" => "auth:sanctum"], function () {

        Route::controller(UserController::class)->group(function (){
            Route::get('getUser','getUser')->name('getUser');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::prefix('products')->group(function () {
                Route::get('get', 'getProducts');
                Route::post('getProduct', 'getProduct');
                Route::post('save', 'saveProduct');
                Route::post('show', 'showProduct');
                Route::post('delete', 'deleteProduct');
                Route::get('getProductsSelect', 'getProductsSelect');
            });
        });

        Route::controller(ShoppingCartController::class)->group(function () {
            Route::post('registerProductShoppingCart', 'registerProductShoppingCart');
            Route::post('getProductShoppingCart', 'getProductShoppingCart');
            Route::post('changeAmountProductShoppingCart', 'changeAmountProductShoppingCart');
            Route::post('checkoutShoppingCart', 'checkoutShoppingCart');
            Route::post('getItemsCart', 'getItemsCart');
            Route::get('addNewCart', 'addNewCart');
        });
    });
});
