<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/HomePage');
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
                    ->paginate(8)->withQueryString();

        return Inertia::render('Home/Search/Index', [
            'products' => $products,
            'filters' => $request->only(['keyword', 'price']),
        ]);
    }
}
