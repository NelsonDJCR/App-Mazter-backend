<?php

namespace App\Http\Controllers;

use App\Models\inventory\Sale;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function registerProductShoppingCart()
    {
        /*
        #
        #  VALIDE EXIST PRODUCTS
        #  THE VALIDATION AMOUNT FOR BAR CODE MO WORKING
        */

        // Get data user
        $user = User::select('store_id', 'id as user_id')->where('auth_token', request()->bearerToken())->first();

        // Find product
        if (request()->typeFilter == 'product_id') {
            $product = Product::find(request()->filter);
        } else {
            $product = Product::where('barcode', 'LIKE', request()->filter . '%')->first();
        }
        $valideEmpty = ShoppingCart::where('shopping_cart_id', request()->shopping_cart_id)->with('getListProducts')->first();
        if (empty($valideEmpty)) {
            // register  new cart
            $shoppingCart = new ShoppingCart();
            $shoppingCart->store_id = $user->store_id;
            $shoppingCart->user_id = $user->user_id;
            $shoppingCart->cart = 1;
            $shoppingCart->save();
            // Register first item
            $data = new shoppingCartItem();
            $data->product_id = $product->product_id;
            $data->amount = 1;
            $data->price = $product->price;
            $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
            $data->save();
            return $this->getListCart($user->store_id, request()->shopping_cart_id);
        } else {

            $shoppingCart = ShoppingCart::find(request()->shopping_cart_id);
            $productInCart = shoppingCartItem::where('product_id', $product->product_id)->where('shopping_cart_id', $shoppingCart->shopping_cart_id)->first();
            if (empty($productInCart)) {
                // Register a new product
                $data = new shoppingCartItem();
                $data->product_id = $product->product_id;
                $data->amount = 1;
                $data->price = $product->price;
                $data->shopping_cart_id = $shoppingCart->shopping_cart_id;
                $data->save();
                return $this->getListCart($user->store_id, request()->shopping_cart_id);
            } else {
                // Change amount
                $productInCart->amount = $productInCart->amount + 1;
                $productInCart->save();
                return $this->getListCart($user->store_id, request()->shopping_cart_id);
            }
        }
    }

    public function getProductShoppingCart()
    {
        $store_id = User::where('auth_token', request()->bearerToken())->first()->store_id;
        return $this->getListCart($store_id, null);
    }
    public function getListCart($store_id, $shopping_cart_id = null)
    {
        $user_id = User::where('auth_token', request()->bearerToken())->first()->id;
        $carts = ShoppingCart::with('getListProducts')->where('store_id', $store_id);
        if ($shopping_cart_id) {
            $carts->where('shopping_cart_id', $shopping_cart_id);
        }

        $carts = $carts->where('user_id', $user_id)->get();

        $total = 0;
        foreach ($carts as $value) {
            foreach ($value->getListProducts as $getListProduct) {
                $total = $total + ($getListProduct->price * $getListProduct->amount);
            }
        }
        // return $total;


        $firts_cart = ShoppingCart::with('getListProducts')->where('store_id', $store_id)->where('user_id', $user_id)->first();
        // foreach ($firts_cart as $item) {
        $total_firts_cart = 0;
        try {
            foreach ($firts_cart->getListProducts as $getListProduct) {
                $total_firts_cart = $total_firts_cart + ($getListProduct->price * $getListProduct->amount);
            }
        } catch (\Throwable $th) {
        }
        // }
        // return $total_firts_cart;
        return response()->json([
            'carts' => $carts,
            'total' => $total,
            'total_first_cart' => $total_firts_cart
        ]);
    }

    public function getItemsCart()
    {
        $user = User::select('store_id', 'id as user_id')->where('auth_token', request()->bearerToken())->first();
        $shopping_cart_id = ShoppingCart::where('store_id', $user->store_id)->where('user_id', $user->user_id)->where('shopping_cart_id', request()->shopping_cart_id)->first()->shopping_cart_id;
        $data = shoppingCartItem::getProduct()->where('shopping_cart_id', $shopping_cart_id)->get();
        $total = 0;
        foreach ($data as $getListProduct) {
            $total = $total + ($getListProduct->price * $getListProduct->amount);
        }
        // return $total;
        return response()->json([
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function changeAmountProductShoppingCart()
    {

        $product_stock = Product::where('product_id', request()->product_id)->first()->stock;
        $store_id = User::where('auth_token', request()->bearerToken())->first()->store_id;
        // $shopping_cart_id = ShoppingCart::find(request()->shopping_cart_id)->first()->shopping_cart_id;
        $shoppingCartItem = shoppingCartItem::where('product_id', request()->product_id)->where('shopping_cart_id', request()->shopping_cart_id)->first();

        $amount = request()->operator == '+' ? $shoppingCartItem->amount + 1 : $shoppingCartItem->amount - 1;

        if ($amount == 0) {
            // If the quantity is 0 it is removed from the shoppingCartItem
            $shoppingCartItem->delete();
            return $this->getListCart($store_id, request()->shopping_cart_id);
        } else if ($product_stock < $amount) {
            return $this->getListCart($store_id, request()->shopping_cart_id);
        }

        $shoppingCartItem->amount = $amount;

        $shoppingCartItem->save();

        $data = shoppingCartItem::getProduct()->where('shopping_cart_id', request()->shopping_cart_id)->get();
        $total = 0;
        foreach ($data as $getListProduct) {
            $total = $total + ($getListProduct->price * $getListProduct->amount);
        }
        // return $this->getListCart($store_id, request()->shopping_cart_id);
        return response()->json([
            'data' => $this->getListCart($store_id, request()->shopping_cart_id),
            'total' => $total
        ]);
    }

    public function checkoutShoppingCart()
    {
        try {
            # Cart_id 
            $cart_id = request()->cart_id;
            $cart_id = 1;
            DB::beginTransaction();
            # Get products from shopping cart
            $user = User::select('store_id', 'id as user_id')->where('auth_token', request()->bearerToken())->first();
            $shopping_cart = ShoppingCart::select('shopping_cart_id')->where('store_id', $user->store_id)->where('cart', $cart_id)->where('user_id', $user->user_id)->first();
            $productsInCart = ShoppingCartItem::where('shopping_cart_id', $shopping_cart->shopping_cart_id)->get();

            # Update amount and get aount finish
            $total = 0;
            foreach ($productsInCart as $productInCart) {
                $total = $total + ($productInCart->price * $productInCart->amount);
                $product = Product::find($productInCart->product_id);
                $product->stock = $productInCart->amount - $product->stock;
                $product->save();
                # Delete all products from ShoppingCartItem
                $productInCart->delete();
            }
            #Delete shopping cart
            $shopping_cart->delete();

            # Create json with products, amount, total
            $json_products = json_encode($productsInCart);

            # Save register in sales_table
            $sale = new Sale();
            $sale->user_id = $user->user_id;
            $sale->store_id = $user->store_id;
            $sale->total = $total;
            $sale->json_products = $json_products;
            $sale->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function addNewCart()
    {
        $user = User::select('store_id', 'id as user_id')->where('auth_token', request()->bearerToken())->first();

        $shoppingCart = new ShoppingCart();
        $shoppingCart->store_id = $user->store_id;
        $shoppingCart->user_id = $user->user_id;
        $shoppingCart->cart = 1;
        $shoppingCart->save();

        $user = User::select('store_id', 'id as user_id')->where('auth_token', request()->bearerToken())->first();
        $shopping_cart_id = ShoppingCart::where('store_id', $user->store_id)->where('user_id', $user->user_id)->where('shopping_cart_id', $shoppingCart->shopping_cart_id)->first()->shopping_cart_id;
        $data = shoppingCartItem::getProduct()->where('shopping_cart_id', $shopping_cart_id)->get();

        $carts = ShoppingCart::where('store_id', $user->store_id)->where('user_id', $user->user_id)->get();
        return response()->json([
            'shopping_cart_id' => $shoppingCart->shopping_cart_id,
            'data' => $data,
            'carts' => $carts,
        ]);
    }

    public function deleteCart()
    {
        try {
            $items = shoppingCartItem::where('shopping_cart_id', request()->shopping_cart_id)->get();
            foreach ($items as $key) {
                $key->delete();
            }
        } catch (\Throwable $th) {
        }
        ShoppingCart::find(request()->shopping_cart_id)->delete();
        $store_id = User::where('auth_token', request()->bearerToken())->first()->store_id;
        return $this->getListCart($store_id, null);
        // return response()->json([
        // ]);
    }
}
