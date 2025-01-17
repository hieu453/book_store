<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request)
    {
        return Inertia::render('Home/Categories/Show', [
            'category_name' => $request->category_name,
            'products' => Product::with('category')->where('category_id', $request->id)->get(),
        ]);
    }
}
