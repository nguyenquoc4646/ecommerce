@extends('client.layouts.app')
@section('style')
@endsection
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Giỏ hàng<span>Cửa hàng</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="cart">
                <div class="container">
                    @include('client.layouts._message')
                    @if (!empty(Cart::getContent()->count()))
                        <div class="row">
                            <div class="col-lg-9">

                                <form action="{{ url('update_cart') }}" method="post">
                                    {{ csrf_field() }}
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Giá</th>
                                                <th>Cỡ</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th></th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach (Cart::getContent() as $key => $value)
                                                @php
                                                    $getProductCart = App\Models\ProductModel::find(
                                                        $value->attributes['product_id'],
                                                    );

                                                @endphp

                                                @if (!empty($getProductCart))
                                                    @php
                                                        $getImageProductCart = $getProductCart->getImageByIdProClient(
                                                            $value->attributes['product_id'],
                                                        );
                                                    @endphp
                                                    <tr>
                                                        <td class="product-col">
                                                            <div class="product">
                                                                <figure class="product-media">
                                                                    @if (!empty($getImageProductCart) && !empty($getImageProductCart->getImage()))
                                                                        <a href="#">
                                                                            <img src="{{ $getImageProductCart->getImage() }}"
                                                                                alt="Product image">
                                                                        </a>
                                                                    @endif
                                                                </figure>

                                                                <h3 class="product-title">
                                                                    <a href="#">{{ $getProductCart->title }}</a>
                                                                </h3><!-- End .product-title -->
                                                            </div><!-- End .product -->
                                                        </td>
                                                        <td class="price-col">
                                                            {{ number_format($getProductCart->price, 0, ',', '.') }}VNĐ
                                                        </td>
                                                        <td class="product-title">
                                                            @php
                                                                $getProductSize = App\Models\ProductSizeModel::find(
                                                                    $value->attributes['size_id'],
                                                                );

                                                                $getProductColor = App\Models\ColorModel::find(
                                                                    $value->attributes['color_id'],
                                                                );
                                                            @endphp
                                                            {{-- {{ $getProductSize }} --}}
                                                            @if (!empty($getProductSize))
                                                                {{ $getProductSize->name }} + (
                                                                {{ number_format($getProductSize->price, 0, ',', '.') }}VNĐ),
                                                            @endif
                                                            {{ $getProductColor->name }}
                                                        </td>
                                                        <td class="quantity-col">
                                                            <div class="cart-product-quantity">
                                                                <input id="numberInput"
                                                                    data-idPro="{{ $getProductCart->id }}" type="number"
                                                                    class="form-control" value="{{ $value->quantity }}"
                                                                    data-idCart="{{ $value->id }}"
                                                                    name="cart[{{ $key }}][qty]" min="1"
                                                                    max="{{ $getProductSize->amount }}" step="1"
                                                                    data-decimals="0" onkeydown="return false;">



                                                                <input type="hidden" class="form-control"
                                                                    value="{{ $value->id }}"
                                                                    name="cart[{{ $key }}][id]">
                                                            </div><!-- End .cart-product-quantity -->
                                                            {{ $value->amount }}
                                                        </td>

                                                        <td class="total-col unitPrice{{ $value->id }}">
                                                            @php
                                                                $basePrice = $getProductCart->price;
                                                                $sizePrice = $getProductSize
                                                                    ? $getProductSize->price
                                                                    : 0;
                                                                $quantity = $value->quantity;
                                                                $totalPrice = ($basePrice + $sizePrice) * $quantity;
                                                            @endphp
                                                            {{-- <input type="hidden" id="pricePro" data-pricePro ="{{$pricePro}}"> --}}

                                                            {{ number_format($totalPrice, 0, ',', '.') }}VNĐ
                                                        </td>
                                                        <td class="remove-col"><button type="button"
                                                                data-id="{{ $value->id }}"
                                                                class="btn-remove del-item-cart"><i
                                                                    class="icon-close"></i></button></td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table><!-- End .table table-wishlist -->

                                 
                                </form>
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-3">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Tổng cộng</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-subtotal">
                                                <td>Thành tiền:</td>
                                                <td id="subTotal">{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}VNĐ
                                                </td>
                                            </tr><!-- End .summary-subtotal -->



                                            <tr class="summary-total">
                                                <td>Tổng tiền:</td>
                                                <td id="total">{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}VNĐ
                                                </td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->

                                    <a href="{{ url('checkout') }}"
                                        class="btn btn-outline-primary-2 btn-order btn-block">TIẾN HÀNH
                                        KIỂM TRA</a>
                                </div><!-- End .summary -->

                                <a href="{{ url('') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>TIẾP TỤC
                                        MUA
                                        SẮM</span><i class="icon-refresh"></i></a>
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    @else
                        <h4>Giỏ hàng trống !</h4>
                    @endif
                </div><!-- End .container -->

            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main>
@endsection
@section('script')
    <script type="text/javascript">
        $('body').delegate('#numberInput', 'change', function() {
            var quantity = $(this).val();
            var idCart = $(this).attr('data-idCart')
            var unitPrice = $('.unitPrice' + idCart);
            $.ajax({
                type: "POST",
                url: '{{ url('update-cart') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    idCart: idCart,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        unitPrice.html(data.unitPrice + "VNĐ")
                        $('#subTotal').html(data.amountPrice + "VNĐ")
                        $('#total').html(data.amountPrice + "VNĐ")
                    }
                }
            });
        });

        $('body').delegate('.del-item-cart', 'click', function() {
            var id_cart = $('.del-item-cart').attr('data-id')
            var el_tr = $(this).closest('tr')
            el_tr.remove()
            $.ajax({
                type: "POST",
                url: '{{ url('deleteCart') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_cart: id_cart,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // window.location.reload()
                    }
                }
            });
        })
    </script>
@endsection
