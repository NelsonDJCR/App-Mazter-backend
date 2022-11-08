<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Route::get('/keygenerate', function ()
{
    Artisan::call('key:generate');
    return "Cleared!";
});
