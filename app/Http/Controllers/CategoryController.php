<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, $slug)
    {
        $products = Product::with('category')
            ->whereRelation('category', 'slug', $slug)
            ->when($request->input('price'), function ($query, $price) {
                $query->orderBy('price', $price);
            })
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Home/Categories/Show', [
            'category_slug' => $slug,
            'products' => $products,
            'filters' => $request->only(['price'])
        ]);
    }
}
