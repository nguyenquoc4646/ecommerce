@extends('client.layouts.app')
@section('style')
    <style>
        .table td {
            padding: 16px;
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
                                @if (!empty($getOrderByUser))
                                    <table class="table table-head-fixed text-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên</th>
                                                <th>Địa chỉ</th>
                                                <th>Số điện thoại</th>
                                                <th>Pttt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>

                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getOrderByUser as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->lastName }}</td>
                                                    <td>{{ $item->address }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->payment_method }}</td>
                                                    <td>{{ $item->total_amount }}</td>
                                                    <td>
                                                        @if ($item->status == 0)
                                                            Chờ xác nhận
                                                        @elseif($item->status == 1)
                                                            Đã xác nhận
                                                        @elseif($item->status == 2)
                                                            Đang giao
                                                        @elseif($item->status == 3)
                                                            Hoàn thành
                                                        @elseif($item->status == 4)
                                                            Đã hủy
                                                        @endif
                                                    </td>
                                                    {{-- <td> {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td> --}}

                                                    <td><a href="{{ url('user/order/detail/' . $item->id) }}"
                                                            class="btn btn-primary">Chi tiết</a>

                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                @else
                                    <h3>Ko cóp jh sdfasfasfsafsda</h3>
                                @endif



                            </div>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->


                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
