<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return to_route('admin.users')->with('success', "Đã tạo người dùng có tên {$request->name}");
    }

    public function edit(int $userId)
    {
        $user = User::where('id', $userId)->first();
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(int $userId, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        User::find($userId)->update($validatedData);

        return back();
    }

    public function delete(int $userId)
    {
        User::find($userId)->delete();

        return to_route('admin.users')->with('success', 'Đã xóa người dùng.');
    }
}
