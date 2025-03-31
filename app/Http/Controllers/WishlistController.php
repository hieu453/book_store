<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Wishlist/Index', [
            'wishlists' => Wishlist::where('user_id', Auth::id())->with('product.category')->paginate(12),
        ]);
    }

    public function add(Request $request)
    {
        $productInWishlist = Wishlist::where('product_id', $request->get('productId'))->where('user_id', Auth::id())->first();
        if ($productInWishlist) {
            Wishlist::destroy($productInWishlist->id);
            return response()->json(['message' => 'Product was removed from wishlist!']);
        }

        $wishlist = new Wishlist;
        $wishlist->user_id = Auth::id();
        $wishlist->product_id = $request->get('productId');
        $wishlist->save();

        return response()->json(['message' => 'Product added to wishlist!']);
    }
}
