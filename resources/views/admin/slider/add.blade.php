@extends('admin.layouts.app')
@section('title')
    Thêm slider
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">

                <!-- /.row -->
                <div class="row">
                    <div class="col-12">


                        <!-- /.card-header -->
                        <div class="row mb-2 mt-2 d-flex justify-between">
                            <div class="col-sm-6">
                                <h5>Thêm slider</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tiêu đề: <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Nhập ...">
                                        <div class="text-danger">{{ $errors->first('title') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hình ảnh: <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="image"
                                            class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên nút: <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="button_name" value="{{ old('button_name') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Nhập ...">
                                        <div class="text-danger">{{ $errors->first('button_name') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Đường dẫn: <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="link" value="{{ old('link') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Nhập ...">
                                        <div class="text-danger">{{ $errors->first('link') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Không hoạt
                                                động
                                            </option>
                                        </select>
                                        <div class="text-danger">{{ $errors->first('status') }}</div>
                                    </div> 

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </form>
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
