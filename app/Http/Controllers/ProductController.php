<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('price')) {
            return Inertia::render('Home/Products/Index', [
                'products' => Product::with('category')->orderBy('price', $request->query('price'))->paginate(9),
            ]);
        }

        return Inertia::render('Home/Products/Index', [
            'products' => Product::with('category')->paginate(9),
        ]);
    }

    public function show($slug, $id)
    {
        return Inertia::render('Home/Products/Show', [
            'product' => Product::with('category')->where('id', $id)->first(),
            'isInWishlist' => Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first() ? true : false,
        ]);
    }
}
