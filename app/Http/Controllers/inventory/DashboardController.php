<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard_homeDetails()
    {
        $store_id = User::where('auth_token',request()->bearerToken())->first()->store_id;

        $count_products = Product::where('store_id',$store_id)->count();
        return $count_sells = Product::selectRaw("SUM(columna2) AS Total")->where('store_id',$store_id)->get();

    }
}
