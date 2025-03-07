<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Helpers\Payment\Momo;
use App\Helpers\Payment\Environment;
use App\Models\Product;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $payment
    )
    {

    }

    public function process()
    {
        $jsonResult = Momo::process(
            new Environment(),
            "https://test-payment.momo.vn/v2/gateway/api/create",
            "10000",
            time()."",
            "Thanh toán qua MoMo",
            route('payment.redirect')
        );

        return Inertia::location($jsonResult['payUrl']);
    }

    public function redirectCheckPayment(Request $request)
    {
        if (! $request->all()) {
            return to_route('home');
        }

        $this->deleteCheckedItemsAndUpdateQuantity();

        session()->flash('paymentDetails', $request->all());

        return to_route('payment.check');
    }

    public function deleteCheckedItemsAndUpdateQuantity()
    {
        $itemIds = [];
        foreach (session('checkedItems') as $item) {
            $itemIds[] = $item['id'];

            $product = Product::find($item['id']);
            if ($product->quantity > 0) {
                $product->quantity = $product->quantity - $item['quantity'];
                $product->save();
            }
        }

        session()->forget('checkedItems');
        Cart::destroy($itemIds);
    }

    public function showCheckPage()
    {
        // Order flash data
        if (session('paymentDetails')) {
            // Need to return view check status
            // dd($this->payment->handlePaymentStatusCode(session('paymentDetails')['resultCode']));
            echo 'need to add a status page';
            return;
        }

        return to_route('home');
    }
}
