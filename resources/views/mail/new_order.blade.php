<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="margin: 0 auto; max-width: 800px; text-align: center;">
        <h2>Bạn có đơn hàng mới. Mã đơn hàng là {{ $order->order_id }}</h2>
        <a
            target="_blank"
            style="background-color: rgb(155, 88, 155);padding: 8px;text-decoration: none;border-radius: 6px;color: white;"
            href="{{ 'http://localhost:8000/admin/orders/'.$order->order_id.'/edit' }}"
        >
            Xem ngay
        </a>
    </div>
</body>
</html>
