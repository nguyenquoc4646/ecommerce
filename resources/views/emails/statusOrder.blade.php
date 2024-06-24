@component('mail::message')
Chào bạn, {{ $orders->fistName .''.$orders->lastName }},

<p>Trạng thái đơn hàng : 
@if ($orders->status == 0)
    Chờ xác nhận
@elseif($orders->status == 1)
Đã xác nhận
@elseif($orders->status == 2)
Đang giao
@elseif($orders->status == 3)
Hoàn thành
@elseif($orders->status == 4)
Đã hủy
@endif
</p>
<h3>Chi tiết đơn hàng</h3>

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
            <td style="padding:8px;border-bottom:1px solid #ddd">{{$order->getProduct->title}}</td>
            <td style="padding:8px;border-bottom:1px solid #ddd">{{$order->size_name}}</td>
            <td style="padding:8px;border-bottom:1px solid #ddd">{{$order->quantity}}</td>
            <td style="padding:8px;border-bottom:1px solid #ddd">{{ number_format($order->total_price, 0, ',', '.')}}VNĐ</td>
        </tr>
    @endforeach
</tbody>

</table>
<p>Tổng cộng: {{ number_format($orders->total_amount, 0, ',', '.')}}VNĐ </p>
<p>Phương thức thanh toán: {{ $orders->payment_method}} </p>
@component('mail::button', ['url' => url('http://127.0.0.1:8000/'.$orders->id)])
Xem đơn hàng
@endcomponent

Cảm ơn bạn đã mua hàng của chúng tôi!

From: {{ config('mail.from.address') }} ({{ config('mail.from.name') }})
@endcomponent
