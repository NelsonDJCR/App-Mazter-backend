<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class SendBackup extends Command
{

    protected $signature = 'generate:backup {id}';

    protected $description = 'Send a copy of the database of the products and user information';

    public function handle()
    {
        $id = $this->argument('id');
        
        $products = Product::where('user_id',$id)->get();

        $sql = "";

        foreach ($products as $key) {
            $sql.= "INSERT INTO products (
                'name','bar_code','price','discount','sales','stock','amount_products','user_id','state','route_image',
            ) VALUES (".
                $key->name.",".
                $key->bar_code.",".
                $key->price.",".
                $key->discount.",".
                $key->sales.",".
                $key->stock.",".
                $key->amount_products.",".
                $key->user_id.",".
                $key->state.",".$key->route_image.","
            ."); ";           
        }

        dd($sql);
        
        return Command::SUCCESS;
    }
}
