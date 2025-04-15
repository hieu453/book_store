<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdminOrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Orders/Index', [
            'orders' => Order::all(),
        ]);
    }

    public function edit($orderId)
    {
        return Inertia::render('Admin/Orders/Edit', [
            'order' => Order::with('orderItems.product')->where('order_id', $orderId)->first(),
        ]);
    }

    public function update($orderId, Request $request)
    {
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'failed'])]
        ]);

        $order = Order::find($orderId);
        $order->status = $validatedData['status'];
        $order->save();

        return back()->with('success', 'Order status update');
    }
}
