<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .my-10 {
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .border {
            border: 1px black solid;
        }

        .p-4 {
            padding: 1rem;
        }

        .flex {
            display: flex;
        }

        .gap-4 {
            gap: 1rem;
        }

        .w-32 {
            width: 8rem;
        }

        .h-32 {
            height: 8rem;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        hr:last-child {
            display: none;
        }

        .my-2 {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .w-1\/2 {
            width: 50%;
        }

        .w-full {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mx-auto max-w-md my-10">
        <div class="text-center">
            <h1 class="font-bold">Chi tiết hóa đơn</h1>
            <h2 class="">Mã hóa đơn: {{ $order->order_id }}</h2>
        </div>

        <div class="mt-4 border p-4">
            @foreach ($order->orderItems as $item)
                <div class="flex gap-4 items-center">
                    @if ($item->product->images->count() > 0)
                        <img src="{{ $item->product->images[0]->getImage() }}" class="w-32 h-32 rounded-lg" alt="product image">
                    @else
                        <img src="" alt="product image" class="w-32 h-32 rounded-lg">
                    @endif
                    <div class="w-full">
                        <h3>Tên sản phẩm: <strong>{{ $item->product->name }}</strong></h3>
                        <h3>Tác giả: <strong>{{ $item->product->author }}</strong></h3>
                        <div class="flex justify-between items-center">
                            <h3>Số lượng: <strong>{{ $item->quantity }}</strong></h3>
                            <h3>Giá: <strong>{{ $item->quantity * $item->price }}đ</strong></h3>
                        </div>
                    </div>
                </div>

                <hr class="mb-2 last:hidden">
            @endforeach
        </div>
        <div class="mt-2">
            <div>
                <h3 class="font-bold">Địa chỉ giao hàng:</h3>
                <p>{{ $order->ward }}, {{ $order->district }}, {{ $order->city }}</p>
            </div>
            <hr class="my-2">
            <div class="flex items-center">
                <div class="w-1/2">
                    <h3 class="font-bold">Tên người nhận:</h3>
                    <p>{{ $order->name }}</p>
                </div>
                <div class="w-1/2">
                    <h3 class="font-bold">Email:</h3>
                    <p>{{ $order->email }}</p>
                </div>
            </div>
            <hr class="my-2">
            <div class="flex items-center">
                <div class="w-1/2">
                    <h3 class="font-bold">SĐT:</h3>
                    <p>{{ $order->phone_number }}</p>
                </div>
                <div class="w-1/2">
                    <h3 class="font-bold">Phương thức thanh toán</h3>
                    <p>{{ $order->payment_mode }}</p>
                </div>
            </div>
        </div>

        <div class="border p-4 rounded-lg mt-2">
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Phí ship:</h3>
                <h3 class="font-bold">
                    {{ $order->payment_mode === 'cod' ? '15đ' : '0đ' }}
                </h3>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Tổng ({{ $order->quantity }}):</h3>
                <h3 class="font-bold">{{ $order->total_price }}đ</h3>
            </div>
        </div>
    </div>
</body>
</html>
