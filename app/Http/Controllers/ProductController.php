<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProducts()
    {
        return $this->productsUser(request()->bearerToken());
    }
    public function productsUser()
    {
        $store_id = getStoreId();
        return Product::where('store_id',$store_id)->get();
    }

    public function getProduct()
    {
        return Product::where('product_id',request()->product_id)->first();
    }

    public function saveProduct()
    {
        $rules = [
            'product_name' => 'required|max:255',
            'barcode' => 'nullable|numeric',
            'price' => 'required|integer|max:999999',
            'purshase_price' => 'required|integer|max:999999',
            'discount' => 'nullable|max:99|integer',
            'stock' => 'nullable|max:1000|integer',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(),406);
        }
        try {
            $data = request()->all();
            $data['store_id'] = User::where('id',getUserId())->first()->store_id;;
            Product::create($data);
            return $this->returnMsg('Register saved');
        } catch (\Throwable $th) {
            return $this->msgServerError($th);
        }
    }

    public function updateProduct()
    {
        try {

            $p = Product::find(request()->product_id);
            $p->product_name = request()->name;
            $p->price = request()->price;
            $p->stock = request()->stock;
            $p->barcode = request()->barcode;
            $p->save();
            return $p;
        } catch (\Throwable $th) {
            return $th;
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
            Product::find(request()->product_id)->delete();
            return $this->productsUser(request()->bearerToken());
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function msgServerError($th)
    {
        return response()->json([$th],406);
    }
    public function returnMsg($response = null)
    {
        return response()->json(['msg'=>$response],200);
    }
    public function test($response = null)
    {
        return response()->json(['msg'=>"Siuuuuuuuu"],200);
    }

    public function getProductsSelect()
    {
        $store_id = getStoreId();
        return Product::select('product_id as value','product_name as label')->where('store_id',$store_id)->get();
    }
}
