<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $cartItem->checked = $request->product['checked'] ?? false;
            $cartItem->save();
        } else {
            $cart = new Cart;
            $cart->product_id = $request->product['productId'];
            $cart->user_id = $request->product['userId'];
            $cart->checked = $request->product['checked'] ?? false;
            $cart->quantity = $request->product['quantity'];
            $cart->save();
        }

        return response()->noContent();
    }

    public function increaseQuantity(Request $request)
    {
        $cart = Cart::where('id', $request->itemId)->first();
        $cart->quantity += 1;
        $cart->save();

        return response()->noContent();
    }

    public function decreaseQuantity(Request $request)
    {
        $cart = Cart::where('id', $request->itemId)->first();
        $cart->quantity -= 1;
        $cart->save();

        return response()->noContent();
    }

    public function setCheckedItemsToSession(Request $request)
    {
        session()->put('checkedItems', $request->checkedItems);

        return to_route('checkout');
    }

    public function checkItem(Request $request)
    {
        if ($request->has('isCheckAll')) {
            Cart::where('user_id', Auth::id())->update([
                'checked' => $request->input('isCheckAll')
            ]);
        } else {
            $item = Cart::where('id', $request->itemId)->where('user_id', Auth::id())->first();
            $item->checked = ! $item->checked;
            $item->save();
        }

        return response()->noContent();
    }

    public function deleteCartItems(Request $request)
    {
        foreach ($request->cartItems as $cartItem) {
            Cart::destroy($cartItem['id']);
        }
        return redirect()->back();
    }

    public function removeItems($ids)
    {
        $itemIds = [];
        foreach (explode(',', $ids) as $stringId) {
            $itemIds[] = (int) $stringId;
        }

        Cart::destroy($itemIds);

        return redirect()->back();
    }
}
