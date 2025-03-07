<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! session('checkedItems')) {
            return redirect()->back();
        }
        return Inertia::render('Home/Cart/Checkout', [
            'checkedItems' => session('checkedItems'),
        ]);
    }
}
