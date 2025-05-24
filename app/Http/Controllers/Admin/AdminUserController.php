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
    public function index(Request $request)
    {
        $users = User::when($request->name, function ($query, $name) {
                        $query->where('name', 'LIKE', "%{$name}%");
                    })
                    ->when($request->email, function ($query, $email) {
                        $query->where('email', 'LIKE', "%{$email}%");
                    })
                    ->when($request->has('role'), function ($query) use ($request) {
                        $query->where('is_admin', $request->role);
                    })
                    ->paginate(3)->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only([
                'name',
                'email',
                'role',
            ])
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
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->role,
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
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'role' => ['required'],
        ]);

        $user = User::find($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->role;
        $user->save();

        return back();
    }

    public function delete(int $userId)
    {
        User::find($userId)->delete();

        return to_route('admin.users')->with('success', 'Đã xóa người dùng.');
    }
}
