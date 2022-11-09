<?php

use App\Models\BusinessType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::get('/', function () {
    
});
Route::get('/seed', function () {
    $pass = bcrypt('123');
    BusinessType::create(['name' => 'Supermercado']);
        BusinessType::create(['name' => 'Tecnología']);
        User::create([
            'comercial_name' => 'Store 1',
            'propetiary_name' => 'Propetiary 1',
            'email' => 'st1',
            'phone' => '312312312',
            'password' => $pass,
            'business_type_id' => "1",
        ]);
        Product::create(['name' => 'Smirnoff','price' => '1231','user_id' => 1,'barcode'=>'5410316951777']);
        Product::create(['name' => 'Chess','price' => '5221','user_id' => 1]);
        Product::create(['name' => 'Bread','price' => '15000','user_id' => 1]);
        User::create([
            'comercial_name' => 'Store 2',
            'propetiary_name' => 'Propetiary 2',
            'email' => 'st2',
            'phone' => '312312312',
            'password' => $pass,
            'business_type_id' => "1",
        ]);
        Product::create(['name' => 'USB','price' => '1323','user_id' => 2]);
        Product::create(['name' => 'Airpods','price' => '123','user_id' => 2]);
        Product::create(['name' => 'Phone','price' => '1231231','user_id' => 2]);
});
Route::get('/keygenerate', function ()
{
    Artisan::call('key:generate');
    return "Cleared!";
});
