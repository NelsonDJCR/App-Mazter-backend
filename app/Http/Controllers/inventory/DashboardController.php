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
        // $store_id = User::where('auth_token',request()->bearerToken())->first()->store_id;
        $store_id = 1;

        $totalProductsRegister = Product::where('store_id',$store_id)->count();
        $totalSales = Product::selectRaw("SUM(product_sales) AS total")->where('store_id',$store_id)->get();

        $totalSales = $totalSales[0]->total;

        return response()->json([
            'totalProductsRegister' =>$totalProductsRegister,
            'totalSales' =>$totalSales,
        ]);

    }
}
