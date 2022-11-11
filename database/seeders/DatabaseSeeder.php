<?php

namespace Database\Seeders;

use \App\Models\BusinessType;
use App\Models\PaymentMethod;
use \App\Models\Product;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreSuscription;
use App\Models\Suscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        BusinessType::create(['business_type_name' => 'Supermarker']);
        BusinessType::create(['business_type_name' => 'Cloting Store']);

        Store::create([
            'business_name' => 'Jenel',
            'propetiary_name' => 'Nelson Cardenas',
            'address' => 'Carrera 15',
            'store_phone' => '3112534282',
            'store_phone_secondary' => '3112534282',
            'city' => 'Bogota',
            'business_type_id' => 1,
        ]);


        Role::create(['role_name' => 'Super Administrator']);
        Role::create(['role_name' => 'Administrator']);
        Role::create(['role_name' => 'Employe']);
        Role::create(['role_name' => 'Owner']);
        Role::create(['role_name' => 'Customer']);

        User::create([
            'name' => 'Javier',
            'email' => 'javier',
            'password' => bcrypt('123'),
            'role_id' => 3,
            'store_id' => 1,
        ]);

        Product::create([
            'product_name' => 'Smirnoff',
            'price' => '7000',
            'stock' => 3,
            'barcode' => '5410316951777',
            'purshase_price' => '5000',
            'store_id' => 1,
        ]);
        Product::create([
            'product_name' => 'Crema',
            'price' => '50000',
            'stock' => 3,
            'barcode' => '3499320003087',
            'purshase_price' => '45000',
            'store_id' => 1,
        ]);
        Product::create([
            'product_name' => 'Protector solar',
            'price' => '98000',
            'stock' => 10,
            'barcode' => '8429420195950',
            'purshase_price' => '70000',
            'store_id' => 1,
        ]);
        
        Suscription::create([
            'months_duration'=>12,
            'suscription_price'=>120000,
            'business_type_id'=>1,
        ]);
        Suscription::create([
            'months_duration'=>1,
            'suscription_price'=>120000,
            'business_type_id'=>2,
        ]);

        PaymentMethod::create(['payment_method_name'=>'Nequi']);
        PaymentMethod::create(['payment_method_name'=>'Efecty']);
        PaymentMethod::create(['payment_method_name'=>'Card']);
        PaymentMethod::create(['payment_method_name'=>'Wire transfer']);

        StoreSuscription::create([
            'store_id'=>1,
            'suscription_id'=>2,
            'payment_method_id'=>2,
        ]);

        
    }
}
