<?php

namespace App\Http\Controllers;

use App\Models\CancelledOrder;
use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Orders/Index', [
            'orders' => Order::with(['orderItems.product.reviews', 'cancelledOrder'])->where('user_id', Auth::id())->get(),
        ]);
    }

    public function cancel($orderId)
    {
        $order = Order::find($orderId);
        $cancelledOrder = CancelledOrder::where('order_id', $orderId)->first();

        if ($order->status == 'pending' && !$cancelledOrder) {
            $cancelledOrder = new CancelledOrder;
            $cancelledOrder->order_id = $orderId;
            $cancelledOrder->user_id = Auth::id();
            $cancelledOrder->save();

            //Can send email and notification below

            return back()->with('success', 'You sent a cancelled order request');
        }

        return back()->with('error', 'There are some wrong');
    }
}
