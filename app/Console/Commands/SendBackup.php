<?php

namespace App\Console\Commands;

use App\Mail\SendBackup as MailSendBackup;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBackup extends Command
{

    protected $signature = 'generate:backup {user_id}';

    protected $description = 'Send a copy of the database of the products and user information';

    public function handle()
    {
        echo "_________________________\n";
        echo "Realizando Backup...\n";
        $user_id = $this->argument('user_id');

        $products = Product::where('user_id', $user_id)->get();

        $sql = "";

        $user = User::find($user_id);

        #Get SQL for update data user
        $sql .= "UPDATE users SET " .
            " comercial_name = '" . $user->comercial_name .
            "',propetiary_name = '" . $user->propetiary_name .
            "',email = '" . $user->email .
            "',phone = '" . $user->phone .
            "',phone_secondary = " . ($user->phone_secondary ? $user->phone_secondary : "null") .
            ",color = '" . $user->color .
            "',state_suscription = '" . $user->state_suscription .
            "',business_type_id = '" . $user->business_type_id . "' WHERE id = $user_id; \n\n\n";


        # Get SQL for each product register 
        foreach ($products as $key) {
            $sql .= "INSERT INTO products (name,bar_code,price,discount,sales,stock,amount_products,user_id,state,route_image) 
            VALUES (\"" .
                $key->name . "\"," .
                ($key->bar_code ? $key->bar_code : "null")  . "," .
                $key->price . "," .
                $key->discount . "," .
                $key->sales . "," .
                $key->stock . "," .
                $key->amount_products . "," .
                $key->user_id . "," .
                $key->state . "," .
                ($key->route_image ? $key->route_image : "null")
                . "); ";
        }

        # Send Email with SQL text
        $data = $sql;
        $mail = new MailSendBackup($data);
        Mail::to('je.nelsondjcr@gmail.com')->send($mail);

        echo "Backup finalizado\n";
        echo "_________________________\n";
        return Command::SUCCESS;
    }
}
