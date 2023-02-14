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

        $totalProductsRegister = Product::where('store_id',getStoreId())->count();
        $totalSales = Product::selectRaw("SUM(product_sales) AS total")->where('store_id',getStoreId())->get();

        $totalSales = $totalSales[0]->total;

        return response()->json([
            'totalProductsRegister' =>$totalProductsRegister,
            'totalSales' =>$totalSales,
        ]);

    }
}
