<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Products/Index', [
            'products' => Product::with('category')->paginate(12),
        ]);
    }

    public function show($slug, $id)
    {
        return Inertia::render('Home/Products/Show', [
            'product' => Product::with('category')->where('id', $id)->first(),
        ]);
    }
}
