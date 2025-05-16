<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->name, function ($query, $name) {
                                    $query->where('name', 'LIKE', "%{$name}%");
                                })
                                ->when($request->created_at, function ($query, $created_at) {
                                    $query->whereDate('created_at', date($created_at));
                                })
                                ->when($request->updated_at, function ($query, $updated_at) {
                                    $query->whereDate('updated_at', date($updated_at));
                                })
                                ->paginate(2)->withQueryString();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
            'filters' => $request->only(['name', 'created_at', 'updated_at']),
            'selectedIds' => $request->selectedIds ?? [],
            'categoriesLength' => Category::count(),
        ]);
    }

    public function selectAll(Request $request)
    {
        if ($request->selectAll) {
            return response()->json(['selectedIds' => Category::all()->pluck('id')]);
        }

        return response()->json(['selectedIds' => []]);
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
