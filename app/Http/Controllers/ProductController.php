<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Review;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Home/Products/Index', [
            'products' => Product::with('category')
                ->when($request->query('price'), function ($query, $price) {
                    $query->orderBy('price', $price);
                })
                ->paginate(9)->withQueryString(),
            'filters' => $request->only(['price']),

        ]);
    }

    public function show($slug, $id)
    {
        return Inertia::render('Home/Products/Show', [
            'product' => Product::with('category')->where('id', $id)->first(),
            'isInWishlist' => Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first() ? true : false,
            'reviews' => Review::with('likes', 'user')->get(),
        ]);
    }
}
