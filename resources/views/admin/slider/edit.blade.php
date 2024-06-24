@extends('admin.layouts.app')
@section('title')
    Chỉnh sửa slider
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
                                <h5>Chỉnh sửa slider : {{ $data->title }}</h5>
                            </div>

                        </div>
                        <div class="card card-primary">

                            <div class="card card-primary">
                                <form action="" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tiêu đề: <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="title" value="{{ old('title', $data->title) }}"
                                                class="form-control" id="exampleInputEmail1" placeholder="Nhập ...">
                                            <div class="text-danger">{{ $errors->first('title') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Hình ảnh: <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" name="image" class="form-control"
                                                id="exampleInputEmail1">
                                            <img style="width:300px" src="{{ $data->getImage() }}" alt="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên nút: <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="button_name"
                                                value="{{ old('button_name', $data->button_name) }}" class="form-control"
                                                id="exampleInputEmail1" placeholder="Nhập ...">
                                            <div class="text-danger">{{ $errors->first('button_name') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Đường dẫn: <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="link" value="{{ old('link', $data->link) }}"
                                                class="form-control" id="exampleInputEmail1" placeholder="Nhập ...">
                                            <div class="text-danger">{{ $errors->first('link') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Trạng thái</label>
                                            <select name="status" class="form-control">
                                                <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hoạt động
                                                </option>
                                                <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Không
                                                    hoạt
                                                    động
                                                </option>
                                            </select>
                                            <div class="text-danger">{{ $errors->first('status') }}</div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>

                        </div>
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
