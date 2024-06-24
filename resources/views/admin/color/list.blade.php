@extends('admin.layouts.app')
@section('title')
    Các loại màu
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">

                <!-- /.row -->
                <div class="row">

                    <div class="col-12">
                        <div class="row mb-2 mt-2 d-flex justify-between">
                            <div class="col-sm-6">
                                <h5>Các loại màu</h5>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href=" {{ url('admin/color/add') }}" class="btn btn-primary ">Thêm màu mới</a>
                            </div>
                        </div>
                        @include('admin.layouts._message')
                        <div class="card">

                            <div class="card-body table-responsive p-0" style="height: 400px;">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Màu</th>
                                            <th>Mã màu</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Người tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->status == 0 ? 'Hoạt động' : 'Không hoạt động' }}</td>
                                                <td> {{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ $item->create_by_name }}</td>
                                                <td><a href="{{ url('admin/color/delete/' . $item->id) }}"
                                                        class="btn btn-danger">Xóa</a>
                                                    <a href="{{ url('admin/color/edit/' . $item->id) }}"
                                                        class="btn btn-primary">Sửa</a>
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
