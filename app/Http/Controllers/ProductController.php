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
    public function productsUser($token)
    {
        $user_id = User::where('auth_token',$token)->first()->id;
        return Product::where('user_id',$user_id)->get();
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
            $user_id = User::where('auth_token',request()->bearerToken())->first()->id;
            $data = request()->all();
            $data['user_id'] = $user_id;
            Product::create($data);
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
            Product::find(request()->product_id)->delete();
            return $this->productsUser(request()->user_id);
        } catch (\Throwable $th) {
            return $th;
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

    public function getProductsSelect()
    {
        $user_id = User::where('auth_token', request()->bearerToken())->first()->id;
        return Product::select('product_id as value','name as label')->where('user_id',$user_id)->get();
    }
}
