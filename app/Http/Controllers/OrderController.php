<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\CancelledOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CancelOrderNotification;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Orders/Index', [
            'orders' => Order::with(['orderItems.product.reviews', 'cancelledOrder', 'orderItems.product.images'])->where('user_id', Auth::id())->get(),
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
            $admins = User::where('is_admin', 1)->get();
            Notification::send($admins, new CancelOrderNotification($cancelledOrder));

            return back()->with('success', 'Bạn đã gửi yêu cầu hủy đơn hàng.');
        }

        return back()->with('error', 'There are some wrong');
    }
}
