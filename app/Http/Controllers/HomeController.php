<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('keyword')) {
            $products = Product::where('name', 'LIKE', "%{$request->input('keyword')}%")
                ->with('category')
                ->paginate(8)
                ->withQueryString();

            return Inertia::render('Home/Search/Index', [
                'products' => $products,
                'keyword' => $request->input('keyword'),
            ]);
        }

        return Inertia::render('Home/HomePage');
    }
}
