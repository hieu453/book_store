<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => Category::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Categories/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['name']);
        $category->save();

        return to_route('admin.categories')->with('success', 'Đã thêm danh mục.');
    }

    public function edit($categoryId)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => Category::find($categoryId),
        ]);
    }

    public function update($categoryId, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $category = Category::find($categoryId);
        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['name']);
        $category->save();

        return back()->with('success', 'Đã cập nhật danh mục.');
    }

    public function destroy($categoryId)
    {
        Category::destroy($categoryId);

        return to_route('admin.categories')->with('success', 'Đã xóa danh mục.');
    }

}
