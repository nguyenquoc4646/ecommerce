@extends('client.layouts.app')
@section('style')
    <style>
        .btn-discount-checkout {
            height: 38px;
        }
    </style>
@endsection
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Thanh toán<span>Cửa hàng</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Cửa hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->
        @include('client.layouts._message')
        <div class="page-content">
            <div class="checkout">
                <div class="container">

                    <form action="" id="submitForm" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Chi tiết thanh toán</h2><!-- End .checkout-title -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Họ <span class="text-danger">*</span></label>
                                        <input type="text" name="firstName"
                                            value="{{ !empty(Auth::user()->firstName) ? Auth::user()->firstName : '' }}"
                                            placeholder="Họ ..." class="form-control" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Tên <span class="text-danger">*</span></label>
                                        <input type="text" name="lastName"
                                            value="{{ !empty(Auth::user()->name) ? Auth::user()->name : '' }}"
                                            placeholder="Tên ..." class="form-control" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->



                                <label>Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ ..."
                                    value="{{ !empty(Auth::user()->address) ? Auth::user()->address : '' }}" required>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Địa chỉ email <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            value="{{ !empty(Auth::user()->email) ? Auth::user()->email : '' }}"
                                            class="form-control" required placeholder="Email ...">
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" placeholder="Số điện thoại ..."
                                            value="{{ !empty(Auth::user()->phone) ? Auth::user()->phone : '' }}"
                                            class="form-control" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                @if (empty(Auth::check()))
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="create_account_checkout" class="custom-control-input"
                                            id="checkout-create-acc">
                                        <label class="custom-control-label" for="checkout-create-acc">Tạo tài khoản
                                            ?</label>
                                    </div><!-- End .custom-checkbox -->

                                    <div class="row" id="password" style="display:none">
                                        <div class="col-sm-12">
                                            <label>Mật khẩu <span class="text-danger">*</span></label>
                                            <input type="text" name="password" class="form-control inputPassword">
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->
                                @endif


                                <label>Ghi chú</label>
                                <textarea class="form-control" name="note" cols="30" rows="4" placeholder="Ghi chú giao hàng ..."></textarea>
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Dơn hàng của bạn</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng:</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::getContent() as $value)
                                                @php
                                                    $getProductCart = App\Models\ProductModel::find(
                                                        $value->attributes['product_id'],
                                                    );
                                                    $getProductSize = App\Models\ProductSizeModel::find(
                                                        $value->attributes['size_id'],
                                                    );

                                                @endphp
                                                <tr>
                                                    <td><a href="#">{{ $getProductCart->title }}
                                                            @if (!empty($getProductSize->name))
                                                                ({{ $getProductSize->name }})
                                                            @endif
                                                        </a></td>
                                                    <td>@php
                                                        $basePrice = $getProductCart->price;
                                                        $sizePrice = $getProductSize ? $getProductSize->price : 0;
                                                        $quantity = $value->quantity;
                                                        $totalPrice = ($basePrice + $sizePrice) * $quantity;
                                                    @endphp

                                                        {{ number_format($totalPrice, 0, ',', '.') }} VNĐ</td>
                                                </tr>
                                            @endforeach
                                            <tr class="summary-subtotal">
                                                <td>Tổng phụ:</td>
                                                <td>{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}VNĐ</td>
                                            </tr><!-- End .summary-subtotal -->
                                            <tr>
                                                <td colspan="2">
                                                    <div class="cart-discount">

                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Mã giảm giá ..." id="discountCode"
                                                                name="discountCode">
                                                            <div class="input-group-append">
                                                                <button
                                                                    class="btn btn-outline-primary-2 btn-discount-checkout"
                                                                    type="button"><i class="icon-long-arrow-right"
                                                                        id="sendDiscountCode"></i></button>
                                                            </div><!-- .End .input-group-append -->
                                                        </div><!-- End .input-group -->

                                                    </div><!-- End .cart-discount -->
                                                </td>

                                            </tr>

                                            <tr id="full-sale-discount">
                                                <td>Giảm giá:</td>
                                                <td><span id="discount_percent"></span><span
                                                        class="discountAmount">0.000</span>VNĐ</td>
                                            </tr>
                                            <tr class="summary-shipping">
                                                <td>Vận chuyển:</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            @foreach ($getShipping as $value)
                                                <tr class="summary-shipping-row">
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input
                                                                data-price="{{ !empty($value->price) ? $value->price : 0 }}"
                                                                type="radio" value="{{ $value->id }}" checked
                                                                id="free-shipping{{ $value->id }}" required
                                                                name="shipping" class="custom-control-input getShipping">
                                                            <label class="custom-control-label"
                                                                for="free-shipping{{ $value->id }}">{{ $value->name }}</label>
                                                        </div><!-- End .custom-control -->
                                                    </td>

                                                    <td>
                                                        @php
                                                            if (!empty($value->price));
                                                        @endphp
                                                        {{ number_format($value->price, 0, ',', '.') }}VNĐ</td>
                                                </tr><!-- End .summary-shipping-row -->
                                            @endforeach

                                            <tr class="summary-total">
                                                <td>Tổng cộng:</td>
                                                <td><span
                                                        class="totalPayment">{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}</span>VNĐ
                                                </td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->
                                    <input id="totalTable" type="hidden" value="{{ Cart::getSubTotal() }}">
                                    <input id="feeShipping" type="hidden" value="0">

                                    <div class="accordion-summary" id="accordion-payment">

                                        <div class="card" style="margin-top: 10px">
                                            <div class="card-header" id="heading-3">
                                                <h2 class="card-title" style="display: flex;align-items:center">
                                                    <input type="radio" id="cashOnDelivery" value="Tiền mặt"
                                                        name="payment_method">
                                                    <label style="margin-left: 8px" for="cashOnDelivery">Thanh toán khi
                                                        nhận hàng</label>
                                                </h2>
                                            </div><!-- End .card-header -->

                                        </div><!-- End .card -->

                                        <div class="card" style="margin-top: 10px">
                                            <div class="card-header" id="heading-3">
                                                <h2 class="card-title" style="display: flex;align-items:center">
                                                    <input type="radio" id="vnpayDelivery" value="Vnpay"
                                                        name="payment_method">
                                                    <label style="margin-left: 8px" for="vnpayDelivery">Thanh toán
                                                        VnPay</label>
                                                </h2>
                                            </div><!-- End .card-header -->

                                        </div><!-- End .card -->

                                        <div class="card" style="margin-top: 10px">
                                            <div class="card-header" id="heading-3">
                                                <h2 class="card-title" style="display: flex;align-items:center">
                                                    <input type="radio" id="momoDelivery" value="Momo"
                                                        name="payment_method">
                                                    <label style="margin-left: 8px" for="momoDelivery">Thanh toán
                                                        momo</label>
                                                </h2>
                                            </div><!-- End .card-header -->

                                        </div><!-- End .card -->
                                    </div><!-- End .accordion -->

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Đặt hàng</span>
                                        <span class="btn-hover-text">Proceed to Checkout</span>
                                    </button>
                                    <div class="card">
                                        <div class="card-header" id="heading-5">
                                            <h2 class="card-title">
                                                <a class="">
                                                    <img src="assets/images/payments-summary.png" alt="payments cards">
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->

                                    </div>
                                </div><!-- End .summary -->
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    </form>
                </div><!-- End .container -->
            </div><!-- End .checkout -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
@section('script')
    <script type="text/javascript">
        $('body').delegate('#submitForm', 'submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: '{{ url('checkout/place_order') }}',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == false) {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi...",
                            text: data.message,
                        });
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        window.location.href = data.redirect;
                    }
                },
                error: function(data) {

                }
            });
        })


        $('body').delegate('#checkout-create-acc', 'change', function() {
            if (this.checked) {
                $(".inputPassword").attr("required", true);
                $('#password').show()
            } else {
                $(".inputPassword").attr("required", false);
                $('#password').hide()
            }
        })
        $(document).ready(function() {
            // Đoạn mã jQuery của bạn
            $('body').delegate('.getShipping', 'change', function() {
                var priceShipping = $(this).attr('data-price');
                $('#feeShipping').val(priceShipping);

                var total = $('#totalTable').val();
                var finalTotal = parseFloat(total) + parseFloat(priceShipping);
                var formattedFinalTotal = finalTotal.toLocaleString('vi-VN');
                $('.totalPayment').html(formattedFinalTotal);
            });

            // Kích hoạt sự kiện change cho input đã được kiểm tra mặc định
            $('.getShipping:checked').change();
        });


        $('body').delegate('#sendDiscountCode', 'click', function(e) {

            var discountCode = $('#discountCode').val(); // Đảm bảo bạn có biến discountCode
           ;
            $.ajax({
                type: 'POST',
                url: '{{ url('checkout/apply_discount') }}',
                data: {
                    discountCode: discountCode,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {

                    $('.discountAmount').html(data.discount_amount)
                    $('#totalTable').val(data.totalPayment) // gán tổng tiền vào ô input ẩn
                    var priceShipping = $('#feeShipping').val() // lấy số tiền vận chuyển
                    var finalTotal = parseFloat(data.totalPayment) + parseFloat(priceShipping)
                    var formattedFinalTotal = finalTotal.toLocaleString('vi-VN');

                    $('.totalPayment').html(formattedFinalTotal)
                    if (data.discount_percent) {
                        $('#discount_percent').html('(' + '-' + data.discount_percent + '%' + ')')
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Áp dụng thành công ",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    if (data.status == false) {
                        $('#discount_percent').html('')
                        $('full-sale-discount').html('')
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi...",
                            text: "Mã giảm giá không tồn tại",

                        });
                    }
                },
                error: function(data) {

                }
            });
        })
    </script>
@endsection
