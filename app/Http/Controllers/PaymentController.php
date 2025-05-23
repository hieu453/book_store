<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Mail\TestMail;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Helpers\Payment\Momo;
use Illuminate\Validation\Rule;
use App\Services\PaymentService;
use App\Services\ProvinceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\Payment\Environment;
use App\Mail\NewOrder;
use App\Mail\OrderSuccess;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $payment,
        protected ProvinceService $province,
    )
    {}

    public function processCod(Request $request)
    {
        $provincesData = $this->province->getProvinces();
        $validatedData = $request->validate([
            'city' => ['required', Rule::in($provincesData['cities'])],
            'district' => ['required', Rule::in($provincesData['districts'])],
            'ward' => ['required', Rule::in($provincesData['wards'])],
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required', 'regex:/^(0|\+84|84)(\d{9,10})$/'],
        ]);

        $totalPrice = 0;
        $totalQuantity = 0;
        $checkedItems = session('checkedItems');

        foreach ($checkedItems as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['quantity'] * $item['product']['price'];
        }

        $order = new Order;
        $order->order_id = time()."";
        $order->user_id = Auth::id();
        $order->name = $validatedData['name'];
        $order->email = $validatedData['email'];
        $order->phone_number = $validatedData['phone_number'];
        $order->city = $validatedData['city'];
        $order->district = $validatedData['district'];
        $order->ward = $validatedData['ward'];
        $order->quantity = $totalQuantity;
        $order->total_price = $totalPrice + 15;
        $order->payment_mode = 'cod';
        $order->save();

        foreach ($checkedItems as $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->order_id;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['product']['price'];
            $orderItem->save();
        }

        $this->updateQuantity();
        session()->forget('checkedItems');

        session()->flash('orderId', $order->order_id);

        Mail::to(Auth::user())->queue(new OrderSuccess($order));
        $admins = User::where('is_admin', 1)->get();
        Notification::send($admins, new NewOrderNotification($order));

        return to_route('payment.cod.success');
    }

    public function showSuccessCodPage()
    {
        session()->keep(['orderId']);

        if (session('orderId')) {
            return Inertia::render('Home/Payment/Cod', [
                'message' => 'Bạn đã đặt hàng',
                'icon_url' => asset('status_icons/success_icon.svg'),
                'order' => Order::where('order_id', session('orderId'))->with('orderItems.product')->first(),
            ]);
        }

        return to_route('home');
    }

    public function process(Request $request)
    {
        $provincesData = $this->province->getProvinces();

        $validatedData = $request->validate([
            'city' => ['required', Rule::in($provincesData['cities'])],
            'district' => ['required', Rule::in($provincesData['districts'])],
            'ward' => ['required', Rule::in($provincesData['wards'])],
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required', 'regex:/^(0|\+84|84)(\d{9,10})$/'],
        ]);

        session()->put('userInfo', $validatedData);
        $totalPrice = 0;
        foreach (session('checkedItems') as $item) {
            $totalPrice += $item['quantity'] * $item['product']['price'];
        }

        $jsonResult = Momo::process(
            new Environment(),
            "https://test-payment.momo.vn/v2/gateway/api/create",
            (string)$totalPrice,
            time()."",
            "Thanh toán qua MoMo",
            route('payment.redirect')
        );
        if ($jsonResult['resultCode'] != 0) {
            return redirect()->back()->with('payment_status', $jsonResult['message']);
        }

        $redirect = $this->updateQuantity();
        if ($redirect) {
            return $redirect;
        }

        return Inertia::location($jsonResult['payUrl']);
    }

    public function redirectCheckPayment(Request $request)
    {
        if (! $request->all()) {
            return to_route('home');
        }

        session()->flash('paymentDetails', $request->all());
        session()->flash('flashCheckedItems', session('checkedItems'));

        // neu forget o showcheckpage se gay ra loi khong tim thay session checkedItems
        session()->forget('checkedItems');

        return to_route('payment.check');
    }

    public function updateQuantity()
    {
        DB::beginTransaction();

        try {
            $itemIds = [];
            foreach (session('checkedItems') as $item) {
                $itemIds[] = $item['id'];
                $product = Product::find($item['product_id']);
                if ($product->quantity < 1 || $product->quantity < $item['quantity']) {
                    DB::rollBack();
                    return to_route('cart')->with('update_quantity_error', 'Không đủ số lượng trong kho!');
                }

                $product->quantity = $product->quantity - $item['quantity'];
                $product->save();
            }

            Cart::destroy($itemIds);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Some error: ' . $e->getMessage());

            return to_route('cart')->with('update_quantity_error', 'Không đủ số lượng trong kho!');
        }
    }

    public function showCheckPage(Request $request)
    {
        session()->keep(['paymentDetails', 'flashCheckedItems']);
        //dd(session('paymentDetails'));
        // Order flash data
        if (session()->has('paymentDetails')) {
            $paymentDetails = session('paymentDetails');
            $checkedItems = session('flashCheckedItems');
            $isOrderExisted = Order::where('order_id', $paymentDetails['orderId'])->first();


            if ($paymentDetails['resultCode'] == 0 && !$isOrderExisted) {
                $totalQuantity = 0;
                $totalPrice = 0;
                foreach ($checkedItems as $item) {
                    $totalQuantity += $item['quantity'];
                    $totalPrice += $item['quantity'] * $item['product']['price'];
                }

                $order = new Order;
                $order->order_id = $paymentDetails['orderId'];
                $order->user_id = Auth::id();
                $order->name = session('userInfo')['name'];
                $order->email = session('userInfo')['email'];
                $order->phone_number = session('userInfo')['phone_number'];
                $order->city = session('userInfo')['city'];
                $order->district = session('userInfo')['district'];
                $order->ward = session('userInfo')['ward'];
                $order->trans_id = $paymentDetails['transId'];
                $order->request_id = $paymentDetails['requestId'];
                $order->quantity = $totalQuantity;
                $order->total_price = $totalPrice;
                $order->payment_mode = 'online';
                $order->save();

                foreach ($checkedItems as $item) {
                    $orderItem = new OrderItem;
                    $orderItem->order_id = $order->order_id;
                    $orderItem->product_id = $item['product_id'];
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['product']['price'];
                    $orderItem->save();
                }

                $admins = User::where('is_admin', 1)->get();
                // gui email va thong bao cho admins
                Notification::send($admins, new NewOrderNotification($order));

                // gui email cho user mua hang
                Mail::to($request->user())->queue(new OrderSuccess($order));
            }
            $handledResult = $this->payment->handlePaymentStatusCode($paymentDetails['resultCode']);

            if (! is_array($handledResult)) {
                return $handledResult;
            }

            return Inertia::render('Home/Payment/Online', [
                'message' => $handledResult['message'],
                'icon_url' => $handledResult['icon'],
                'code' => $handledResult['code'],
                'order' => Order::where('order_id', $paymentDetails['orderId'])->with('orderItems.product')->first(),
            ]);
        }
        return to_route('home');
    }
}
