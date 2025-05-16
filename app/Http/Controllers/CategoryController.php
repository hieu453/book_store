<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
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
            ->when($request->input('name'), function ($query, $name) {
                $query->orderBy('name', $name);
            })
            ->paginate(9)
            ->withQueryString();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                $image->url = $image->getImage();
            }
        }

        return Inertia::render('Home/Categories/Show', [
            'category_slug' => $slug,
            'products' => $products,
            'category_name' => Category::where('slug', $slug)->first('name'),
            'filters' => $request->only(['price', 'name'])
        ]);
    }
}
