@extends('admin.layouts.app')
@section('title')
    Cập nhật màu
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
                                <h5>Cập nhật màu : {{ $data->name }}</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên màu<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="colorName"
                                            value="{{ old('colorName', $data->name) }}" class="form-control"
                                            id="exampleInputEmail1" placeholder="Nhập Tên thương hiệu ...">
                                        <div class="text-danger">{{ $errors->first('colorName') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mã màu<span class="text-danger">*</span>
                                        </label>
                                        <input type="color" name="codeColor"
                                            value="{{ old('codeColor', $data->code) }}" class="form-control"
                                            id="exampleInputEmail1" placeholder="Nhập Tên thương hiệu ...">
                                        <div class="text-danger">{{ $errors->first('codeColor') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Không hoạt
                                                động
                                            </option>
                                        </select>
                                    </div>
                                 
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
