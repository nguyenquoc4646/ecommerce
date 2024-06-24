@extends('admin.layouts.app')
@section('title')
    Danh sách danh mục
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
                                <h5>Danh sách danh mục</h5>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href=" {{ url('admin/category/add') }}" class="btn btn-primary ">Thêm danh mục</a>
                            </div>
                        </div>
                        @include('admin.layouts._message')
                        <div class="card">

                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-head-fixed text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên danh mục</th>
                                            <th>Trạng thái</th>
                                            <th>meta_title</th>
                                            <th>meta_description</th>
                                            <th>meta_keywords</th>
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
                                                <td><a href="{{url('admin/category/delete/'.$item->id)}}" class="btn btn-danger">Xóa</a>
                                                    <a href="{{url('admin/category/edit/'.$item->id)}}" class="btn btn-primary">Sửa</a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- {{$data->links()}} --}}
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
