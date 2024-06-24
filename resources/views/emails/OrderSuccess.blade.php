@component('mail::message')
    Chào bạn, {{ $orders->fistName . '' . $orders->lastName }},

    Bạn vừa đặt hàng thành công. Dưới đây là chi tiết đơn hàng của bạn:

    <h3>Chi tiết đơn hàng</h3>
    <ul>
        <li>Mã đơn hàng: {{ $orders->id }}</li>
        <li>Ngày đặt: {{ $orders->created_at }}</li>
        <li>Trạng thái đơn hàng: Chờ xác nhận</li>
    </ul>

    <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">

        <thead>
            <tr>
                <th style="border-bottom: 1px solid #ddd;padding:8px;text-align:left;">Sản phẩm</th>
                <th style="border-bottom: 1px solid #ddd;padding:8px;text-align:left;">Kích cỡ</th>
                <th style="border-bottom: 1px solid #ddd;padding:8px;text-align:left;">Số lượng</th>
                <th style="border-bottom: 1px solid #ddd;padding:8px;text-align:left;">Giá</th>
            </tr>


        </thead>
        <tbody>
            @foreach ($orders->getOrderItem as $order)
                <tr>
                    <td style="padding:8px;border-bottom:1px solid #ddd">{{ $order->getProduct->title }}</td>
                    <td style="padding:8px;border-bottom:1px solid #ddd">{{ $order->size_name }}</td>
                    <td style="padding:8px;border-bottom:1px solid #ddd">{{ $order->quantity }}</td>
                    <td style="padding:8px;border-bottom:1px solid #ddd">
                        {{ number_format($order->total_price, 0, ',', '.') }}VNĐ</td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <p>Tổng cộng: {{ number_format($orders->total_amount, 0, ',', '.') }}VNĐ </p>
    <p>Phương thức thanh toán: {{ $orders->payment_method }} </p>
    @component('mail::button', ['url' => url('http://127.0.0.1:8000/user/order/detail/' . $orders->id)])
        Xem đơn hàng
    @endcomponent

    Cảm ơn bạn đã mua hàng của chúng tôi!

    From: {{ config('mail.from.address') }} ({{ config('mail.from.name') }})
@endcomponent
