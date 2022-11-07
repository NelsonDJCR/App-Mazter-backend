<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\User;

class ShoppingCartController extends Controller
{
    public function registerProductShoppingCart()
    {

        // Get Id User
        $user_id = User::where('auth_token',request()->bearerToken())->first()->id;

        // Find product
        if (request()->typeFilter == 'product_id') {
            $product = Product::find(request()->filter);
        }else {
            $product = Product::where('barcode', 'LIKE', request()->filter . '%')->first();
        }

        $valideEmpty = ShoppingCart::where('user_id', $user_id)->where('state', 1)->with('getListProducts')->first();
        if (empty($valideEmpty)) {
            // register  new cart
            // return "register  new cart";
            $shoppingCart = new ShoppingCart();
            $shoppingCart->user_id = $user_id;
            $shoppingCart->cart = request()->cart;
            $shoppingCart->save();
            // Register first item
            // return "Register first item";
            $data = new shoppingCartItem();
            $data->product_id = $product->product_id;
            $data->amount = 1;
            $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
            $data->save();
            return $this->getListCart($user_id, request()->cart);
        } else {
            $shoppingCart = ShoppingCart::where('user_id', $user_id)->where('cart', request()->cart)->first();
            $productInCart = shoppingCartItem::where('product_id', $product->product_id)->where('shopping_cart_id', $shoppingCart->shopping_cart_id)->first();
            if (empty($productInCart)) {
                // Register a new product
                // return "Register a new product";
                $data = new shoppingCartItem();
                $data->product_id = $product->product_id;
                $data->amount = 1;
                $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
                $data->save();
                return $this->getListCart($user_id, request()->cart);
            } else {
                // Change amount
                // return "Change amount";
                $productInCart->amount = $productInCart->amount + 1;
                $productInCart->save();
                return $this->getListCart($user_id, request()->cart);
            }
        }
    }

    public function getProductShoppingCart()
    {
        $user_id = User::where('auth_token',request()->bearerToken())->first()->id;
        return $this->getListCart($user_id,request()->cart);
    }
    public function getListCart($user_id, $cart)
    {
        $cart = ShoppingCart::with('getListProducts')->where('user_id', $user_id)->where('cart', $cart)->get();
        $total = 0;
        foreach ($cart as $value) {
            foreach ($value->getListProducts as $getListProduct) {
                $total = $total + ($getListProduct->price * $getListProduct->amount);
            }
        }
        return response()->json([
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function changeAmountProductShoppingCart()
    {
        $user_id = User::where('auth_token',request()->bearerToken())->first()->id;
        $product = shoppingCartItem::where('product_id',request()->product_id)->first();

        $amount = request()->operator == '+' ? $product->amount + 1 : $product->amount - 1;
        if ($amount == 0) {
            $product->delete();
            return $this->getListCart($user_id,request()->cart);
        }
        
        $product->amount = $amount;

        $product->save();
        return $this->getListCart($user_id,request()->cart);
    }
}
