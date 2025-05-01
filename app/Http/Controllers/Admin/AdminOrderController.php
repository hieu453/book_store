<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use App\Helpers\Payment\Momo;
use App\Models\CancelledOrder;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Helpers\Payment\Environment;
use App\Http\Controllers\Controller;
use App\Notifications\UpdateOrderStatusNotification;
use Illuminate\Support\Facades\Mail;

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

        $user = User::find($order->user_id);
        $user->notify(new UpdateOrderStatusNotification($order));

        return back()->with('success', 'Đã cập nhật đơn hàng.');
    }

    public function showCancelledOrder()
    {
        return Inertia::render('Admin/CancelledOrders/Index', [
            'cancelledOrders' => CancelledOrder::with('user')->get(),
        ]);
    }

    public function cancelOrders(Request $request)
    {
        $orders = Order::whereIn('order_id', $request->order_ids)->get();
        foreach ($orders as $order) {
            $order->status = 'cancelled';
            $order->save();

            $order->cancelledOrder()->update(['status' => 'cancelled']);
        }

        return back()->with('success', 'Đã hủy các đơn hàng');
    }
}
