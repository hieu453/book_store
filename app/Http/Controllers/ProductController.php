<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Products/Index', [
            'products' => Product::with('category')->get(),
        ]);
    }

    public function show(Request $request)
    {
        return Inertia::render('Home/Products/Show', [
            'product' => Product::with('category')->where('id', $request->id)->first(),
        ]);
    }
}
