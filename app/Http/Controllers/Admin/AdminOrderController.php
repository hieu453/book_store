<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Payment\Environment;
use App\Helpers\Payment\Momo;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CancelledOrder;
use App\Mail\UpdateOrderStatus;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UpdateOrderStatusNotification;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::when($request->orderId, function ($query, $orderId) {
                            $query->where('order_id', 'LIKE', "%{$orderId}%");
                        })
                        ->when($request->transId, function ($query, $transId) {
                            $query->where('trans_id', 'LIKE', "%{$transId}%");
                        })
                        ->when($request->name, function ($query, $name) {
                            $query->where('name', 'LIKE', "%{$name}%");
                        })
                        ->when($request->email, function ($query, $email) {
                            $query->where('email', 'LIKE', "%{$email}%");
                        })
                        ->when($request->phoneNumber, function ($query, $phoneNumber) {
                            $query->where('phone_number', 'LIKE', "%{$phoneNumber}%");
                        })
                        ->when($request->status, function ($query, $status) {
                            $query->where('status', $status);
                        })
                        ->when($request->city, function ($query, $city) {
                            $query->where('city', 'LIKE', "%{$city}%");
                        })
                        ->when($request->district, function ($query, $district) {
                            $query->where('district', 'LIKE', "%{$district}%");
                        })
                        ->when($request->ward, function ($query, $ward) {
                            $query->where('ward', 'LIKE', "%{$ward}%");
                        })
                        ->when($request->paymentMode, function ($query, $paymentMode) {
                            $query->where('payment_mode', 'LIKE', "%{$paymentMode}%");
                        })
                        ->paginate(5)->withQueryString();

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
            'filters' => $request->only([
                'orderId',
                'transId',
                'status',
                'name',
                'email',
                'phoneNumber',
                'city',
                'district',
                'ward',
                'quantity',
                'totalPrice',
                'paymentMethod'
            ])
        ]);
    }

    public function edit($orderId, Request $request)
    {
        $order = Order::where('order_id', $orderId)->first();
        $orderProducts = OrderItem::with('product')->where('order_id', $order->order_id)
                        ->when($request->productName, function ($query, $productName) {
                            $query->whereRelation('product', 'name', 'LIKE', "%{$productName}%");
                        })
                        ->paginate(2);

        return Inertia::render('Admin/Orders/Edit', [
            'order' => $order,
            'orderProducts' => $orderProducts,
            'filters' => $request->only([
                'name',
            ])
        ]);
    }

    public function update($orderId, Request $request)
    {
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'failed'])]
        ]);

        $order = Order::find($orderId);

        if ($order->status === $validatedData['status']) {
            return back()->with('success', 'Không có thay đổi.');
        }

        $order->status = $validatedData['status'];
        $order->save();

        // gui thong bao va email, email dua vao queue
        $user = User::find($order->user_id);
        $user->notify(new UpdateOrderStatusNotification($order));
        Mail::to($user)->queue(new UpdateOrderStatus($order));

        return back()->with('success', 'Đã cập nhật đơn hàng.');
    }

    public function delete($orderId)
    {
        Order::destroy($orderId);

        return to_route('admin.orders')->with('success', 'Đã xóa đơn hàng.');
    }

    public function showCancelledOrder(Request $request)
    {
        $cancelledOrders = CancelledOrder::with('user')
                            ->when($request->orderId, function ($query, $orderId) {
                                $query->where('order_id', 'LIKE', "%{$orderId}%");
                            })
                            ->when($request->name, function ($query, $name) {
                                $query->whereRelation('user', 'name', 'LIKE', "%{$name}%");
                            })
                            ->paginate(5);

        return Inertia::render('Admin/CancelledOrders/Index', [
            'cancelledOrders' => $cancelledOrders,
            'filters' => $request->only([
                'name',
                'orderId',
            ]),
            'cancelledOrdersLength' => CancelledOrder::count(),
        ]);
    }

    public function checkAll(Request $request)
    {
        if ($request->selectAll) {
            return response()->json(['selectedOrderIds' => CancelledOrder::all()->pluck('order_id')]);
        }

        return response()->json(['selectedOrderIds' => []]);
    }

    public function cancelOrders(Request $request)
    {
        $orders = Order::whereIn('order_id', $request->orderIds)->get();
        foreach ($orders as $order) {
            if ($order->payment_mode === 'cod') {
                $order->status = 'cancelled';
                $order->save();
                CancelledOrder::where('order_id', $order->order_id)->delete();
            }

            if ($order->payment_mode === 'online') {
                Momo::refund(new Environment, $order->order_id, $order->request_id, $order->total_price, $order->trans_id);

                $order->status = 'cancelled';
                $order->save();
                CancelledOrder::where('order_id', $order->order_id)->delete();
            }
        }

        return back()->with('success', 'Đã hủy các đơn hàng');
    }
}
