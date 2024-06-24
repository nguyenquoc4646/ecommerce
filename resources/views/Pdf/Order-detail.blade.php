<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hóa đơn</title>
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
        }

        body {
            color: #333;
            margin: 0;
            padding: 20px;

        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .order{
            font-size: 40px;
            font-weight: medium;
        }

        .invoice-details {
            margin-bottom: 40px;
        }

        .invoice-details,
        .items,
        .total,
        .bank-details {
            width: 100%;
        }

        .invoice-details td,
        .items th,
        .items td,
        .total td {
            padding: 10px;
        }

        .items th {
            background: #eee;
            border-bottom: 1px solid #ddd;
        }

        .items td {
            border-bottom: 1px solid #eee;
        }

        .items tr:last-child td {
            border-bottom: none;
        }

        .total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .bank-details td {
            padding: 5px;
        }

        .thank-you {
            text-align: right;
            margin-top: 30px;
            font-size: 20px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="header">
            <img style="width:120px" src="http://ecommerce111.test/assets/images/logo.png" alt="Logo">
            <p class="order">Hóa đơn</p>
        </div>

        <table class="invoice-details">
            <tr>
                <td>
                    <strong>Thông tin người nhận:</strong><br>
                    <ul>
                        <li>{{ $order->firstName }} {{ $order->lastName }} </li>
                        <li> {{ $order->address }}</li>
                        <li> {{ $order->email }}</li>
                    </ul>

                </td>
                <td class="text-right">
                    <strong>Mã đơn hàng:</strong> #{{ $order->id }}<br>
                    <strong>Ngày đặt:</strong> {{ $order->created_at }}
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Đơn giá</th>
                    <th class="text-right">Số lượng</th>
                    <th class="text-right">Tổng đơn</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->getOrderItem as $item)
                    <tr>
                        <td>{{ $item->getProduct->title }}</td>
                        <td class="text-right">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->total_price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="total">
            <tr>
                <td class="text-right" colspan="3">Tổng cộng:</td>
                <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
            </tr>
            <!-- If tax or additional charges are needed, include them here -->
            <!-- <tr>
                    <td class="text-right" colspan="3">Tax:</td>
                    <td class="text-right">{{ number_format($order->tax_amount, 0, ',', '.') }} VNĐ</td>
                </tr> -->
            <tr>
                <td class="text-right" colspan="3">Total:</td>
                <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ
                </td>
            </tr>
        </table>

        <div class="bank-details">
            <table>
                <tr>
                    <td><strong>Ngân hàng:</strong></td>
                </tr>
                <tr>
                    <td>Ngân hàng TMCP Quân đội</td>
                </tr>
                <tr>
                    <td>Chủ tài khoản: {{ $order->lastName }} {{ $order->firstName }}</td>
                </tr>
                <tr>
                    <td>Số tài khoản : 0383701271</td>
                </tr>
            </table>
        </div>

        <div class="thank-you">
            <p>Cảm ơn vì đã tin tưởng !</p>
        </div>


    </div>


</body>

</html>
