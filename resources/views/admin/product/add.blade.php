@extends('admin.layouts.app')
@section('title')
    Thêm sản phẩm
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
                                <h5>Thêm sản phẩm</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tiêu đề <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            class="form-control" id="exampleInputEmail1"
                                            placeholder="Nhập sản phẩm ...">
                                        <div class="text-danger">{{ $errors->first('title') }}</div>
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
