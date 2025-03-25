<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! session()->has('checkedItems')) {
            return redirect()->back();
        }

        return Inertia::render('Home/Cart/Checkout', [
            'checkedItems' => session('checkedItems'),
            'provinces' => Http::get('https://provinces.open-api.vn/api/?depth=3')->json(),
        ]);
    }
}
