@extends('admin.layouts.app')
@section('title')
    Danh sách đơn hàng
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">

                <!-- /.row -->

                <div class="alert alert-light mt-3" role="alert">
                    <h3>Danh sách đơn hàng ({{ $data->total() }})</h3>

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="" method="get">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mã đơn hàng</label>
                                                <input type="text" name="id" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Mã đơn hàng ...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Họ</label>
                                                <input type="text" name="firstName" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Họ ...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên</label>
                                                <input type="text" name="lastName" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Tên ...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Địa chỉ:</label>
                                                <input type="text" name="address" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Địa chỉ ...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Nhập email...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Số điện thoại</label>
                                                <input type="text" name="phone" class="form-control"
                                                    id="exampleInputEmail1" placeholder="Số điện thoại ...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Từ ngày</label>
                                                <input type="date" name="startDate" class="form-control"
                                                    id="exampleInputEmail1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Đến ngày</label>
                                                <input type="date" name="endDate" class="form-control"
                                                    id="exampleInputEmail1">
                                            </div>
                                        </div>
                                    </div>





                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    <button type="reset" class="btn btn-primary">Làm mới</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->

                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">

                    <div class="col-12">
                        <div class="row mb-2 mt-2 d-flex justify-between">
                            <div class="col-sm-6">
                                <h5>Danh sách đơn hàng</h5>

                            </div>
                            <div class="col-sm-6 text-right">
                                <form action="{{ url('exportOrderExel') }}" method="post">
                                  @csrf
                                    <button type="submit" class="btn btn-primary">Xuất file</button>
                                </form>
                               
                            </div>
                        </div>
                        @include('admin.layouts._message')
                        <div class="card">

                            <div class="card-body table-responsive p-0" style="height: 300px;">
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
                                        @foreach ($data as $item)
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
                        {{ $data->links() }}
                        <!-- /.card-header -->

                        <!-- /.card-body -->

                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
@section('script')
    <script>
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
        });


    </script>
@endsection
