@extends('client.layouts.app')
@section('style')
    <style>
        .dashboard label {
            font-weight: 500;
        }

        .table td {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        /* Modal Header */


        .modal-title {
            font-size: 1.25rem;
        }

        .close {
            color: white;
            opacity: 0.8;
        }

        .close:hover {
            opacity: 1;
        }

        /* Modal Body */
        .modal-body {
            padding: 1.5rem;
        }

        /* Star Rating */
        .star-rating {
            display: flex;
        }

        .star {
            font-size: 2.5rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .star:hover,
        .star:hover~.star,
        .star.selected {
            color: #ffcc00;
        }

        /* Form Controls */
        .form-group label {
            font-weight: bold;
        }

        #reviewText {
            resize: none;
        }
    </style>
@endsection
@section('content')
    <main class="main">

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Cửa hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản của tôi</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="row">
                        @include('client.user._sidebar')
                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">



                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Id: </label> {{ $getOrderDetailByUserOrder->id }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Người nhận :
                                        </label> {{ $getOrderDetailByUserOrder->lastName }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Địa chỉ :
                                        </label> {{ $getOrderDetailByUserOrder->address }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email :
                                        </label> {{ $getOrderDetailByUserOrder->email }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Số điện thoại :
                                        </label> {{ $getOrderDetailByUserOrder->phone }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ghi chú :
                                        </label> {{ $getOrderDetailByUserOrder->note }}
                                    </div>
                                    @if (!empty($getOrderDetailByUserOrder->discount_code))
                                        <div class="form-group">
                                            <label for="">Mã giảm giá :
                                            </label> {{ $getOrderDetailByUserOrder->discount_code }}
                                        </div>
                                    @endif
                                    @if (!empty($getOrderDetailByUserOrder->discount_amount))
                                        <div class="form-group">
                                            <label for="">Số tiền giảm giá :
                                            </label>
                                            {{ number_format($getOrderDetailByUserOrder->discount_amount, 0, ',', '.') }}VNĐ
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="">Hình thức vận chuyển :
                                        </label> {{ $getOrderDetailByUserOrder->getShipping->name }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phí vận chuyển :
                                        </label>
                                        {{ number_format($getOrderDetailByUserOrder->shipping_amount, 0, ',', '.') }}VNĐ
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phương thức thanh toán :
                                        </label> {{ $getOrderDetailByUserOrder->payment_method }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tổng tiền :
                                        </label>
                                        {{ number_format($getOrderDetailByUserOrder->total_amount, 0, ',', '.') }}VNĐ
                                    </div>
                                    <div class="form-group">
                                        <label for="">Trạng thái vận chuyển :
                                        </label>
                                        @if ($getOrderDetailByUserOrder->status == 0)
                                            Chờ xác nhận
                                        @elseif($getOrderDetailByUserOrder->status == 1)
                                            Đã xác nhận
                                        @elseif($getOrderDetailByUserOrder->status == 2)
                                            Đang giao
                                        @elseif($getOrderDetailByUserOrder->status == 3)
                                            Hoàn thành
                                        @elseif($getOrderDetailByUserOrder->status == 4)
                                            Đã hủy
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Trạng thái thanh toán :
                                        </label>
                                        {{ $getOrderDetailByUserOrder->is_payment == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ngày đặt :
                                        </label> {{ $getOrderDetailByUserOrder->created_at }}
                                    </div>
                                </div>

                                <div class="card">

                                    <div class="card-body table-responsive p-0" style="height: 300px;">
                                        <table class="table table-head-fixed text-nowrap table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Hình ảnh</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Giá</th>

                                                    <th>Giá size</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($getOrderDetailByUserOrder->getOrderItem as $item)
                                                    @php
                                                        $getImage = $item->getProduct->getImageByIdProClient(
                                                            $item->getProduct->id,
                                                        );
                                                    @endphp
                                                    @php
                                                        $getEvaluate = $item->getEvaluate(
                                                            $item->product_id,
                                                            $getOrderDetailByUserOrder->id,
                                                        );
                                                    @endphp

                                                    <tr>
                                                        {{-- <td><img src="{{ $item->getProduct->name }}" alt=""></td> --}}
                                                        <td><img style="width:100px;" src="{{ $getImage->getImage() }}"
                                                                alt=""></td>
                                                        <td>
                                                            {{ $item->getProduct->title }}<br>
                                                            Size: {{ $item->size_name }}<br>
                                                            Màu: {{ $item->color_name }}<br>
                                                            @if ($getOrderDetailByUserOrder->status == 3)
                                                                @if (empty($getEvaluate))
                                                                    <button class="btn btn-primary evaluateForm"
                                                                        id="{{ $item->product_id }}"
                                                                        data-order="{{ $getOrderDetailByUserOrder->id }}">Đánh
                                                                        giá</button>
                                                                @else
                                                                    <a href="{{ url('product/review/' . $item->product_id) }}"
                                                                        class="btn btn-primary">Xem đánh giá</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price, 0, ',', '.') }}VNĐ</td>

                                                        <td>{{ number_format($item->size_amount, 0, ',', '.') }}VNĐ</td>
                                                        <td>{{ number_format($item->total_price, 0, ',', '.') }}VNĐ</td>


                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div><!-- End .col-lg-9 -->

                    </div><!-- End .row -->


                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
    <!-- Modal -->
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="modalEvaluate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đánh giá sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="padding: 16px" id="evaluationForm">
                        <div class="form-group">
                            <label for="starRating">Chọn số sao</label>
                            <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="reviewText">Nhận xét của bạn</label>
                            <textarea class="form-control reviewText" name="reviewText" rows="3"></textarea>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary submitEvaluate">Gửi</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('body').delegate('.evaluateForm', 'click', function() {
            var product_id = $(this).attr('id');
            console.log(product_id);
            var order_id = $(this).attr('data-order');

            $('#modalEvaluate').modal('show');

            // $('.star').off('click');
            // $('.submitEvaluate').off('click');

            $('.star').on('click', function() {
                $('.star').removeClass('selected');
                var starValue = $(this).attr(
                'data-value'); // Get the value of the star from data-value attribute
                $(this).addClass('selected').prevAll().addClass('selected');

                // Ensure the submitEvaluate button is only processed once per click
                $('.submitEvaluate').on('click', function() {
                    var reviewText = $('.reviewText').val();
                    $('.submitEvaluate').prop('disabled', true);

                    $.ajax({
                        type: 'GET',
                        url: '{{ url('evaluate') }}',
                        data: {
                            product_id: product_id,
                            order_id: order_id,
                            starValue: starValue,
                            reviewText: reviewText
                        },
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                window.location.reload();
                            });
                        },

                    });
                });
            });
        });
    </script>
@endsection
