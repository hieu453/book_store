<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="text-align: center;">
        <h2>Bạn có yêu cầu hủy hàng từ khách hàng: {{ $cancelled_order->user->name }}</h2>
        <h3>Mã đơn hàng: {{ $cancelled_order->order_id }}</h3>
        <a
            href="{{ route('admin.orders.cancelled') }}"
            target="_blank"
            style="padding: 8px;background-color: rgb(144, 80, 144);color: white;text-decoration: none;border-radius: 6px;"
        >
            Xem ngay
        </a>
    </div>
</body>
</html>
