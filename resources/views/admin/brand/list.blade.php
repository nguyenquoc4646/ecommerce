@extends('admin.layouts.app')
@section('title')
    Danh sách thương hiệu
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
                                <h5>Danh sách thương hiệu</h5>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href=" {{ url('admin/brand/add') }}" class="btn btn-primary ">Thêm thương hiệu</a>
                            </div>
                        </div>
                        @include('admin.layouts._message')
                        <div class="card">

                            <div class="card-body table-responsive p-0" style="height: 400px;">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên thương hiệu</th>
                                            <th>Trạng thái</th>
                                            <th>meta_title</th>
                                            <th>meta_description</th>
                                            <th>meta_keywords</th>
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
                                                <td>{{ $item->status == 0 ? 'Hoạt động' : 'Không hoạt động' }}</td>
                                                <td>{{ $item->meta_title }}</td>
                                                <td>{{ $item->meta_description }}</td>
                                                <td>{{ $item->meta_keywords }}</td>
                                                <td> {{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ $item->create_by_name }}</td>
                                                <td><a href="{{ url('admin/brand/delete/' . $item->id) }}"
                                                        class="btn btn-danger">Xóa</a>
                                                    <a href="{{ url('admin/brand/edit/' . $item->id) }}"
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
