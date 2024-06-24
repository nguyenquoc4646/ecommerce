@extends('admin.layouts.app')
@section('title')
    Thêm màu mới
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
                                <h5>Thêm màu mới</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Màu <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="colorName" value="{{ old('colorName') }}"
                                            class="form-control" id="exampleInputEmail1"
                                            placeholder="Nhập màu ...">
                                        <div class="text-danger">{{ $errors->first('colorName') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mã màu <span class="text-danger">*</span>
                                        </label>
                                        <input type="color" name="codeColor" value="{{ old('codeColor') }}"
                                            class="form-control" id="exampleInputEmail1">
                                        <div class="text-danger">{{ $errors->first('codeColor') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Không hoạt động
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
