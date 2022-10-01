<?php

namespace Database\Seeders;

use \App\Models\BusinessType;
use \App\Models\Product;
use App\Models\Store;
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
        BusinessType::create(['name' => 'Supermercado']);
        BusinessType::create(['name' => 'Tecnología']);

        Store::create([
            'comercial_name' => 'Store 1',
            'propetiary_name' => 'Propetiary 1',
            'email' => 'st1',
            'phone' => '312312312',
            'password' => bcrypt('123'),
            'business_type_id' => 1,
        ]);

        Product::create(['name' => 'Soup','price' => '1231','store_id' => 1]);
        Product::create(['name' => 'Chess','price' => '5221','store_id' => 1]);
        Product::create(['name' => 'Bread','price' => '15000','store_id' => 1]);

        Store::create([
            'comercial_name' => 'Store 2',
            'propetiary_name' => 'Propetiary 2',
            'email' => 'st2',
            'phone' => '312312312',
            'password' => bcrypt('123'),
            'business_type_id' => 1,
        ]);

        Product::create(['name' => 'USB','price' => '1323','store_id' => 2]);
        Product::create(['name' => 'Airpods','price' => '123','store_id' => 2]);
        Product::create(['name' => 'Phone','price' => '1231231','store_id' => 2]);


    }
}
