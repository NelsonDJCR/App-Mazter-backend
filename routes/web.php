<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::get('/', function () {
    
});
Route::get('/keygenerate', function ()
{
    Artisan::call('key:generate');
    return "Cleared!";
});
