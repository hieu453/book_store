<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Orders/Index', [
            'ordersPending' => Order::with('orderItems.product')->where('status', 'pending')->where('user_id', Auth::id())->get(),
            'ordersProcessing' => Order::with('orderItems.product')->where('status', 'processing')->where('user_id', Auth::id())->get(),
            'ordersCompleted' => Order::with('orderItems.product')->where('status', 'completed')->where('user_id', Auth::id())->get(),
        ]);
    }
}
