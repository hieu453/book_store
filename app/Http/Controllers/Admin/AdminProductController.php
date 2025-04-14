<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'language' => ['required', 'max:255'],
            'width' => ['required', 'min:1'],
            'height' => ['required', 'min:1'],
            'weight' => ['required', 'min:1'],
            'price' => ['required', 'min:1'],
            'quantity' => ['required', 'min:0'],
            'publisher' => ['required', 'max:255'],
            'published_date' => ['required'],
        ]);

        $product = new Product;
        $product->name = $validatedData['name'];
        $product->slug = Str::slug($validatedData['name']);
        $product->author = $validatedData['author'];
        $product->language = $validatedData['language'];
        $product->width = $validatedData['width'];
        $product->height = $validatedData['height'];
        $product->weight = $validatedData['weight'];
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->publisher = $validatedData['publisher'];
        $product->published_date = $validatedData['published_date'];
        $product->save();

        return to_route('admin.products')->with('success', 'Product added');
    }

    public function edit($productId)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => Product::find($productId),
        ]);
    }

    public function update($productId, Request $request) {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'language' => ['required', 'max:255'],
            'width' => ['required', 'min:1'],
            'height' => ['required', 'min:1'],
            'weight' => ['required', 'min:1'],
            'price' => ['required', 'min:1'],
            'quantity' => ['required', 'min:0'],
            'publisher' => ['required', 'max:255'],
            'published_date' => ['required'],
        ]);

        $product = Product::find($productId);
        $product->name = $validatedData['name'];
        $product->slug = Str::slug($validatedData['name']);
        $product->author = $validatedData['author'];
        $product->language = $validatedData['language'];
        $product->width = $validatedData['width'];
        $product->height = $validatedData['height'];
        $product->weight = $validatedData['weight'];
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->publisher = $validatedData['publisher'];
        $product->published_date = $validatedData['published_date'];
        $product->save();

        return back()->with('success', 'Product updated');
    }

    public function destroy($productId)
    {
        Product::destroy($productId);

        return to_route('admin.products')->with('success', 'Product deleted');
    }
}
