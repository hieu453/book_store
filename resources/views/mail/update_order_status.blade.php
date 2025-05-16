<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="max-width: 50%;margin: 0 auto;text-align: center;">
        <h1>Đã cập nhật trạng thái đơn hàng {{ $order->order_id }}</h1>
        <a
            target="_blank"
            href="http://localhost:8000/orders"
            style="padding: 8px;background-color: rgb(144, 80, 144);color: white;text-decoration: none;border-radius: 6px;"
        >
            Xem ngay
        </a>
    </div>
</body>
</html>
