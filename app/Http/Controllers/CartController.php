<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Cart/Index');
    }

    public function showCheckout(Request $request)
    {
        // dd($request->totalPrice);
        return Inertia::render('Home/Cart/Checkout');
    }
}
