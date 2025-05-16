<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newProducts = Product::with('images')->orderBy('created_at', 'desc')->limit(6)->get();

        $orderItemIds = OrderItem::select('product_id')->get();
        $bestSellingProducts = Product::with('images')->whereIn('id', $orderItemIds)->orderBy('created_at', 'desc')->limit(6)->get() ?? [];

        foreach ($newProducts as $product) {
            foreach ($product->images as $image) {
                $image->url = $image->getImage();
            }
        }

        foreach ($bestSellingProducts as $product) {
            foreach ($product->images as $image) {
                $image->url = $image->getImage();
            }
        }

        return Inertia::render('Home/HomePage', [
            'banners' => [
                asset('/banners/banner_1.jpg'),
                asset('/banners/banner_2.jpg'),
            ],
            'newProducts' => $newProducts,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }

    public function search(Request $request)
    {
        // Method withQueryString still works, but vscode shows error warning
        $products = Product::with('category')
                    ->when($request->input('keyword'), function ($query, $keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    })
                    ->When($request->input('price'), function ($query, $price) {
                        $query->orderBy('price', $price);
                    })
                    ->when($request->input('name'), function ($query, $name) {
                        $query->orderBy('name', $name);
                    })
                    ->paginate(8)->withQueryString();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                $image->url = $image->getImage();
            }
        }

        return Inertia::render('Home/Search/Index', [
            'products' => $products,
            'filters' => $request->only(['keyword', 'price', 'name']),
        ]);
    }
}
