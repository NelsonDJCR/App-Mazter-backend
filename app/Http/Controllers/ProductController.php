<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProducts()
    {
        return Product::getProducts();
    }

    public function saveProduct()
    {
        $rules = [
            'name' => 'required|max:255',
            'bar_code' => '|nullable|integer',
            'price' => 'required|integer|max:999999',
            'discount' => 'required|max:99|integer',
            'stock' => 'nullable|max:1000|integer',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(),406);
        }
        try {
            Product::create(request()->all());
            $this->returnMsg('Register saved');
        } catch (\Throwable $th) {
            return $this->msgServerError($th);
        }
    }

    public function showProduct()
    {
        try {
            $data = Product::find(request()->id);
            if (!empty($data)) {
                return response()->json($data,200);
            }else{
                return $this->returnMsg('No hay registros asociados');
            }
        } catch (\Throwable $th) {
            return $this->msgServerError($th,406);
        }
    }

    public function deleteProduct()
    {
        try {
            Product::find(request()->id)->delete();
            return response()->json(200);
        } catch (\Throwable $th) {
            return $this->msgServerError($th);
        }
    }

    public function msgServerError($th)
    {
        return response()->json([
            'msg' => 'Server error',
            'error' => $th
        ],406);
    }
    public function returnMsg($response = null)
    {
        return response()->json(['msg'=>$response],200);
    }
}
