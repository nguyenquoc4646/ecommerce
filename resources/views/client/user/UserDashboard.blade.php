@extends('client.layouts.app')
@section('style')
    <style>
        .box {
            padding: 10px;
            text-align: center;
            border: 1px solid #b8b8b8;
            border-radius: 5px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
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
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $getTotalOrderUser}}</div>
                                            <div style="font-size: 16px;">Tổng số đơn hàng</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $getTotalTodayOrderUser}}</div>
                                            <div style="font-size: 16px;">Đơn hàng hôm nay</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ number_format($getTotalAmountOrderUser, 0, ',', '.') }}VNĐ</div>
                                            <div style="font-size: 16px;">Tổng tiền đã mua</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ number_format($getTotalTodayAmountOrderUser, 0, ',', '.') }}VNĐ</div>
                                            <div style="font-size: 16px;">Tổng tiền hôm nay</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $pending}}</div>
                                            <div style="font-size: 16px;">Chờ xác nhận</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $processing}}</div>
                                            <div style="font-size: 16px;">Đã xác nhận</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $delivering }}</div>
                                            <div style="font-size: 16px;">Đang vận chuyển</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $completed}}</div>
                                            <div style="font-size: 16px;">Hoàn thành</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box">
                                            <div style="font-size: 16px;font-weight:bold">{{ $cancelled}}</div>
                                            <div style="font-size: 16px;">Đã hủy</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
