<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\User;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function registerProductShoppingCart(Request $r)
    {
        // Find product
        $product = Product::where('barcode', 'LIKE', request()->barcode . '%')->first();

        $valideEmpty = ShoppingCart::where('user_id', request()->user_id)->where('state', 1)->with('getListProducts')->first();
        if (empty($valideEmpty)) {
            // register  new cart
            $shoppingCart = new ShoppingCart();
            $shoppingCart->user_id = request()->user_id;
            $shoppingCart->cart = request()->cart;
            $shoppingCart->save();
            // Register first item
            $data = new shoppingCartItem();
            $data->product_id = $product->product_id;
            $data->amount = 1;
            $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
            $data->save();
            return $this->getListCart(request()->user_id, request()->cart);
        } else {
            $shoppingCart = ShoppingCart::where('user_id', request()->user_id)->where('cart', request()->cart)->first();
            $productInCart = shoppingCartItem::where('product_id', $product->product_id)->where('shopping_cart_id', $shoppingCart->shopping_cart_id)->first();
            if (empty($productInCart)) {
                // Register a new product
                $data = new shoppingCartItem();
                $data->product_id = $product->id;
                $data->amount = 1;
                $data->shopping_cart_id = $shoppingCart->id;
                $data->save();
                return $this->getListCart(request()->user_id, request()->cart);
            } else {
                // Change amount
                $productInCart->amount = $productInCart->amount + 1;
                $productInCart->save();
                return $this->getListCart(request()->user_id, request()->cart);
            }
        }
    }

    public function getProductShoppingCart()
    {
        return $this->getListCart(request()->user_id,request()->cart);
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
        return request()->all();
        shoppingCartItem::where('product_id',request()->product_id)->leftjoin("shopping_carts", "shopping_carts.id", ".");
    }
}
