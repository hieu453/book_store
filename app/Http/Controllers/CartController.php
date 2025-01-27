<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Home/Cart/Index', [
            'cartItems' => Cart::with(['user', 'product'])->where('user_id', $request->user()->id)->get(),
        ]);
    }

    public function addToCart(Request $request)
    {
        $cartItem = Cart::where('product_id', $request->product['productId'])->first();

        if ($cartItem) {
            $cartItem->quantity += $request->product['quantity'];
            $cartItem->save();
        } else {
            $cart = new Cart;
            $cart->product_id = $request->product['productId'];
            $cart->user_id = $request->product['userId'];
            $cart->quantity = $request->product['quantity'];
            $cart->save();
        }

        return response()->json(['message' => 'Cart added']);
    }

    public function increaseQuantity(Request $request)
    {
        $cart = Cart::with(['product', 'user'])->where('id', $request->itemId)->first();
        $cart->quantity += 1;
        $cart->save();

        // return response()->json(['cart' => $cart]);
        return response()->noContent();
    }

    public function decreaseQuantity(Request $request)
    {
        $cart = Cart::where('id', $request->itemId)->first();
        $cart->quantity -= 1;
        $cart->save();

        return response()->noContent();
    }

    public function showCheckout(Request $request)
    {
        // dd($request->totalPrice);
        return Inertia::render('Home/Cart/Checkout');
    }

    public function deleteCartItems(Request $request)
    {
        foreach ($request->cartItems as $cartItem) {
            Cart::destroy($cartItem['id']);
        }
        return redirect()->back();
    }

    public function removeItem($itemId)
    {
        Cart::destroy($itemId);

        return redirect()->back();
    }
}
