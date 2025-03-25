<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {

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

    public function getIsAdded(int $productId)
    {
        return Wishlist::where('product_id', $productId)->where('user_id', Auth::id())->first() ? true : false;
    }
}
