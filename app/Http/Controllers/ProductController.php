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
        $products = Product::with('category', 'images')
                    ->when($request->query('price'), function ($query, $price) {
                        $query->orderBy('price', $price);
                    })
                    ->when($request->query('name'), function ($query, $name) {
                        $query->orderBy('name', $name);
                    })
                    ->paginate(9)->withQueryString();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                $image->url = $image->getImage();
            }
        }

        return Inertia::render('Home/Products/Index', [
            'products' => $products,
            'filters' => $request->only(['price', 'name']),
        ]);
    }

    public function show($slug, $id)
    {
        $product = Product::with('category', 'reviews.rate', 'reviews.user', 'reviews.likes', 'images')->where('id', $id)->first();
        foreach ($product->images as $image) {
            $image->url = $image->getImage();
        }

        $randomRelatedProducts = Product::with('category:id,name', 'images')
                                            ->where('category_id', $product->category_id)
                                            ->where('id', '!=', $product->id)
                                            ->inRandomOrder()
                                            ->limit(8)
                                            ->get();


        foreach ($randomRelatedProducts as $relatedProduct) {
            foreach ($relatedProduct->images as $image) {
                $image->url = $image->getImage();
            }
        }


        return Inertia::render('Home/Products/Show', [
            'product' => $product,
            'relatedProducts' => $randomRelatedProducts,
            'isInWishlist' => Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first() ? true : false,
        ]);
    }

    public function liveSearch(?string $keyword = null)
    {
        $products = [];
        if ($keyword) {
            $products = Product::with('category', 'images')->where('name', 'LIKE', "%{$keyword}%")->take(5)->get();

            foreach ($products as $product) {
                foreach ($product->images as $image) {
                    $image->url = $image->getImage();
                }
            }
        }
        return response()->json(['products' => $products]);
    }
}
