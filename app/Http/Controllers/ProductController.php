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
            'barcode' => 'nullable|numeric',
            'price' => 'required|integer|max:999999',
            'discount' => 'nullable|max:99|integer',
            'stock' => 'nullable|max:1000|integer',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(),406);
        }
        try {
            Product::create(request()->all());
            return $this->returnMsg('Register saved');
        } catch (\Throwable $th) {
            return $this->msgServerError($th);
        }
    }

    public function showProduct()
    {
        return Product::where('barcode','like',request()->code.'%')->first();
        try {
            $data = Product::where('barcode',request()->code)->first();
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
    public function test($response = null)
    {
        return response()->json(['msg'=>"Siuuuuuuuu"],200);
    }
}
