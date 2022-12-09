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
        $store_id = User::where('auth_token', request()->bearerToken())->first()->store_id;

        // Find product
        if (request()->typeFilter == 'product_id') {
            $product = Product::find(request()->filter);
        } else {
            $product = Product::where('barcode', 'LIKE', request()->filter . '%')->first();
        }

        $valideEmpty = ShoppingCart::where('store_id', $store_id)->where('shopping_cart_state', 1)->with('getListProducts')->first();
        if (empty($valideEmpty)) {
            // register  new cart
            // return "register  new cart";
            $shoppingCart = new ShoppingCart();
            $shoppingCart->store_id = $store_id;
            $shoppingCart->cart = request()->cart;
            $shoppingCart->save();
            // Register first item
            // return "Register first item";
            $data = new shoppingCartItem();
            $data->product_id = $product->product_id;
            $data->amount = 1;
            $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
            $data->save();
            return $this->getListCart($store_id, request()->cart);
        } else {
            $shoppingCart = ShoppingCart::where('store_id', $store_id)->where('cart', request()->cart)->first();
            $productInCart = shoppingCartItem::where('product_id', $product->product_id)->where('shopping_cart_id', $shoppingCart->shopping_cart_id)->first();
            if (empty($productInCart)) {
                // Register a new product
                // return "Register a new product";
                $data = new shoppingCartItem();
                $data->product_id = $product->product_id;
                $data->amount = 1;
                $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
                $data->save();
                return $this->getListCart($store_id, request()->cart);
            } else {
                // Change amount
                // return "Change amount";
                $productInCart->amount = $productInCart->amount + 1;
                $productInCart->save();
                return $this->getListCart($store_id, request()->cart);
            }
        }
    }

    public function getProductShoppingCart()
    {
        $store_id = User::where('auth_token', request()->bearerToken())->first()->store_id;
        return $this->getListCart($store_id, request()->cart);
    }
    public function getListCart($store_id, $cart)
    {
        $cart = ShoppingCart::with('getListProducts')->where('store_id', $store_id)->where('cart', $cart)->get();
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

        $product_stock = Product::where('product_id', request()->product_id)->first()->stock;
        $store_id = User::where('auth_token', request()->bearerToken())->first()->store_id;
        $shoppingCartItem = shoppingCartItem::where('product_id', request()->product_id)->first();

        $amount = request()->operator == '+' ? $shoppingCartItem->amount + 1 : $shoppingCartItem->amount - 1;

        if ($product_stock < $amount) {
            return $this->getListCart($store_id, request()->cart);
        } else if ($amount == 0) {
            // If the quantity is 0 it is removed from the shoppingCartItem
            $shoppingCartItem->delete();
            return $this->getListCart($store_id, request()->cart);
        }
        $shoppingCartItem->amount = $amount;

        $shoppingCartItem->save();
        return $this->getListCart($store_id, request()->cart);
    }
}
