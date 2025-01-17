<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Cart/Index', [
            'cart' => session('cart'),
        ]);
    }

    public function add(Request $request)
    {
        $cartNumber = session('cartNumber');

        // dd(session('cart'));

        if (session()->has('cart')) {
            if (array_key_exists($request->productId, session('cart'))) {
                $productQuantity = session('cart')[ $request->productId ][ 'quantity' ];
                $productQuantity += $request->product[ 'quantity' ];

                $product = [
                    'name' => $request->product[ 'name' ],
                    'quantity' => $productQuantity,
                    'price' => $request->product[ 'price' ],
                ];

                session()->put("cart.{$request->productId}", $product);
            } else {
                session()->put("cart.{$request->productId}", $request->product);
            }
        } else {
            session()->put('cart', [
                $request->productId => $request->product,
            ]);
        }

        session()->put('cartNumber', (bool)$cartNumber ? ++$cartNumber : 1);
        return redirect()->back();
    }
}
