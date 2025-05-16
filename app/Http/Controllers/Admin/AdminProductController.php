<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AdminProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::paginate(5),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'language' => ['required', 'max:255'],
            'width' => ['required', 'min:1'],
            'height' => ['required', 'min:1'],
            'category_id' => ['required'],
            'weight' => ['required', 'min:1'],
            'price' => ['required', 'min:1'],
            'description' => ['required'],
            'quantity' => ['required', 'min:0'],
            'images' => ['required'],
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
        $product->category_id = $validatedData['category_id'];
        $product->description = $validatedData['description'];
        $product->new_price = $request->new_price;
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->publisher = $validatedData['publisher'];
        $product->published_date = $validatedData['published_date'];
        $product->save();

        foreach ($request->images as $image) {
            $image_name = $image->hashName();
            $image_path = $image->getRealPath();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($image_path);
            $image->resize(640, 640);
            $encoded = $image->encode();
            $encoded->save($image_path);

            $product_images = new ProductImage;
            $product_images->product_id = $product->id;
            $product_images->image_name = $image_name;
            $product_images->save();

            Storage::disk('public')->putFileAs("/product_images/product_{$product->id}", new File($image_path), $image_name);
        }

        return to_route('admin.products')->with('success', 'Đã thêm sản phẩm.');
    }

    public function edit($productId)
    {
        $product = Product::with('images')->where('id', $productId)->first();

        foreach ($product->images as $image) {
            $image->url = $image->getImage();
        }

        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => Category::all(),
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
            'description' => ['required'],
            'quantity' => ['required', 'min:0'],
            'category_id' => ['required'],
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
        $product->description = $validatedData['description'];
        $product->category_id = $validatedData['category_id'];
        $product->weight = $validatedData['weight'];
        $product->new_price = $request->new_price;
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->publisher = $validatedData['publisher'];
        $product->published_date = $validatedData['published_date'];
        $product->save();

        if ($request->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete("/product_images/product_{$product->id}/$image->image_name");
                $image->delete();
            }

            foreach ($request->images as $image) {
                $image_name = $image->hashName();
                $image_path = $image->getRealPath();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($image_path);
                $image->resize(640, 640);
                $encoded = $image->encode();
                $encoded->save($image_path);

                $product_images = new ProductImage;
                $product_images->product_id = $product->id;
                $product_images->image_name = $image_name;
                $product_images->save();


                Storage::disk('public')->putFileAs("/product_images/product_{$product->id}", new File($image_path), $image_name);
            }
        }

        return back()->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy($productId)
    {
        Product::destroy($productId);

        return to_route('admin.products')->with('success', 'Đã xóa sản phẩm.');
    }
}
