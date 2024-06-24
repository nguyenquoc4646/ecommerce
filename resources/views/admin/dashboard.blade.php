@extends('admin.layouts.app')
@section('title')
    Dashboard
@endsection
@section('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <style>
        #ui-datepicker-div {
            top: 367px !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Bảng điều khiển</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tổng đơn hàng</span>
                                <span class="info-box-number">
                                    {{ $totalOrder }}

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Đơn hàng hôm nay</span>
                                <span class="info-box-number">
                                    {{ $totalTodayOrder }}

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tổng doanh thu</span>
                                <span class="info-box-number">
                                    {{ number_format($totalAmount, 0, ',', '.') }}VNĐ

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Doanh thu hôm nay</span>
                                <span class="info-box-number">
                                    {{ number_format($totalTodayAmount, 0, ',', '.') }}VNĐ

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Khách hàng</span>
                                <span class="info-box-number">
                                    {{ $totalUser }}

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Khách hàng hôm nay</span>
                                <span class="info-box-number">
                                    {{ $totalTodayUser }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Đánh giá sản phẩm</span>
                                <span class="info-box-number">
                                    {{ $totalEvaluate }}

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Đánh giá hôm nay</span>
                                <span class="info-box-number">
                                    {{ $totalTodayEvaluate }}

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->


                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12 d-flex">
                        <form id="filterForm" action="" method="post" class="w-100">
                            @csrf
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="datepicker1">Từ ngày</label>
                                        <input class="form-control" type="text" id="datepicker1" name="startDate">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="datepicker2">Đến ngày</label>
                                        <input class="form-control" type="text" id="datepicker2" name="endDate">
                                    </div>
                                </div>
                                <div class="col-3" style="position: relative">
                                <button type="reset">làm mới</button>
                                    <button type="button" id="filter-dashboard" style="position: absolute;top:31px;"
                                        class="btn btn-primary">Lọc</button>
                                </div>
                            </div>
                        </form>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="filterSelectOption">Lọc theo</label>
                                <select class="form-control" name="filterSelectOption" id="filterSelectOption">
                                    <option>Chọn một giá trị -----</option>
                                    <option value="sevenDays">7 Ngày trước</option>
                                    <option value="twoWeeks">2 tuần trước</option>
                                    <option value="currentMonth">Tháng này</option>
                                    <option value="oneMonth">1 tháng trước</option>
                                    <option value="oneYear">365 ngày</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div id="myfirstchart" style="height: 250px;"></div>
                        </div>
                    </div>
                    <!-- /.card -->


                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Sản phẩm xem nhiều
                        </div>
                        <div class="card-body">
                            <ul>
                            @foreach ($top10MostViewed as $value)
                            <li><span style="color: red"><a style="color: red" href="{{ url($value->slug) }}">{{ $value->title}}</a>:</span> {{ $value->view}}</li>
                            @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <p id="pie-chart">
                    </p>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body table-responsive p-0">
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
                                        <th>Ngày đặt</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->lastName }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->payment_method }}</td>
                                            <td>{{ $item->total_amount }}</td>
                                            <td>
                                                <select id="{{ $item->id }}" class="form-select changeStatus"
                                                    {{ in_array($item->status, [3, 4]) ? 'disabled' : '' }}>
                                                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>
                                                        Chờ xác nhận
                                                    </option>
                                                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>
                                                        Đã xác nhận
                                                    </option>
                                                    <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>
                                                        Đang giao
                                                    </option>
                                                    <option value="3" {{ $item->status == 3 ? 'selected' : '' }}>
                                                        Hoàn thành
                                                    </option>
                                                    <option value="4" {{ $item->status == 4 ? 'selected' : '' }}>
                                                        Đã hủy
                                                    </option>
                                                </select>

                                            </td>
                                            <td> {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>

                                            <td><a href="{{ url('admin/order/detail/' . $item->id) }}"
                                                    class="btn btn-primary">Chi tiết</a>

                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


    <script>
        $(function() {
            $("#datepicker1").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
                duration: "slow"
            });
            $("#datepicker2").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
                duration: "slow"
            });

        });
        $(document).ready(function() {
            dataDefault()
            var chart = new Morris.Bar({
                element: 'myfirstchart',
                lineColors: ['#ff3700', '#1eff00','#ff00ea', '#ffffff'],

                xkey: 'period',
                hideHover: 'auto',
                ykeys: ['order', 'sales', 'quantity'],
                parseTime: false,
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Đơn hàng', 'Doanh số', 'Số lượng'],
            });


            $('#filter-dashboard').click(function() {

                var datepicker1 = $('#datepicker1').val();
                var datepicker2 = $('#datepicker2').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ url('filter_revenue_dashboard') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        startDate: datepicker1,
                        endDate: datepicker2
                    },
                    dataType: 'json',
                    success: function(data) {
                        chart.setData(data)
                    },
                    error: function(data) {

                    }
                });
            });
            $('#filterSelectOption').change(function() {
                var optionValue = $(this).val()

                $.ajax({
                    type: 'GET',
                    url: '{{ url('filterOptionDate') }}',
                    data: {
                        optionValue: optionValue,
                    },
                    dataType: 'json',
                    success: function(data) {
                        chart.setData(data)
                    },
                    error: function(data) {

                    }
                });
            });

            function dataDefault() {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('filterRevenueDashboardDefault') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(data) {
                        chart.setData(data)
                    },
                    error: function(error) {}
                });
            }




        })

        $('body').delegate('.changeStatus', 'change', function() {
            var id_order = $(this).attr('id');
            var status_order = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{ url('admin/order_status') }}',
                data: {
                    id_order: id_order,
                    status_order: status_order,
                },
                dataType: 'json',
                success: function(data) {

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                },
                error: function(data) {

                }
            });
            if (status_order == 3 || status_order == 4) {
                $(this).attr('disabled', true)
            } else {
                $(this).attr('disabled', false)
            }

        })
    </script>
    <script>
        $(document).ready(function() {
            Morris.Donut({
                element: 'pie-chart',
                resize: true,

                data: [{
                        label: "Sản phẩm",
                        value: {{ $productAll }}
                    },
                    {
                        label: "Danh mục",
                        value: {{ $categoryAll }}
                    },
                    {
                        label: "Đánh giá",
                        value: {{ $totalEvaluate }}
                    },

                ]
            });
        })
    </script>
    <script>
        $(function() {
            $("#datepicker3").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
                duration: "slow"
            });
            $("#datepicker4").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
                duration: "slow"
            });

        });
    </script>
    {{-- <script src="/assets_admin/dist/js/demo.js"></script> --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@endsection
