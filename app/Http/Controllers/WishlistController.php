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
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product.category', 'product.images')->paginate(12);
        foreach ($wishlists as $wishlist) {
            foreach ($wishlist->product->images as $image) {
                $image->url = $image->getImage();
            }
        }
        return Inertia::render('Home/Wishlist/Index', [
            'wishlists' => $wishlists,
        ]);
    }

    public function add(Request $request)
    {
        $productInWishlist = Wishlist::where('product_id', $request->get('productId'))->where('user_id', Auth::id())->first();
        if ($productInWishlist) {
            Wishlist::destroy($productInWishlist->id);
            return response()->json(['message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích!']);
        }

        $wishlist = new Wishlist;
        $wishlist->user_id = Auth::id();
        $wishlist->product_id = $request->get('productId');
        $wishlist->save();

        return response()->json(['message' => 'Đã thêm sản phẩm vào danh sách yêu thích!']);
    }
}
