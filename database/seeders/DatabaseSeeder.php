<?php

namespace Database\Seeders;

use \App\Models\BusinessType;
use \App\Models\Product;
use App\Models\Store;
use App\Models\StoreState;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        BusinessType::create(['name' => 'Supermarker']);
        BusinessType::create(['name' => 'Cloting Store']);
        
        StoreState::create([
            'name' => 'inactive',
            'name' => '',
            'name' => '',
            'name' => '',
            'name' => '',
            'name' => '',
        ]);
        User::create([
            'comercial_name' => 'Store 1',
            'propetiary_name' => 'Propetiary 1',
            'email' => 'st1',
            'phone' => '312312312',
            'password' => bcrypt('123'),
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
            'password' => bcrypt('123'),
            'business_type_id' => "1",
        ]);

        Product::create(['name' => 'USB','price' => '1323','user_id' => 2]);
        Product::create(['name' => 'Airpods','price' => '123','user_id' => 2]);
        Product::create(['name' => 'Phone','price' => '1231231','user_id' => 2]);


    }
}
