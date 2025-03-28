<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! session()->has('checkedItems')) {
            return redirect()->back();
        }

        try {
            $provinces = Cache::remember('provinces', 180, function () {
                return Http::get('https://provinces.open-api.vn/api/?depth=3')->json();
            });
        } catch (\Exception $e) {
            dd($e);
        }

        return Inertia::render('Home/Cart/Checkout', [
            'checkedItems' => session('checkedItems'),
            'provinces' => $provinces,
        ]);
    }
}
