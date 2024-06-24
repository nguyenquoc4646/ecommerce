@extends('admin.layouts.app')
@section('title')
    Thêm thương hiệu
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
                                <h5>Thêm thương hiệu</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thương hiệu <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="brandName" value="{{ old('brandName') }}"
                                            class="form-control" id="exampleInputEmail1"
                                            placeholder="Nhập Tên thương hiệu ...">
                                        <div class="text-danger">{{ $errors->first('brandName') }}</div>
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
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta title <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="metaTitle" value="{{ old('metaTitle') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Meta title">
                                        <div class="text-danger">{{ $errors->first('metaTitle') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="metaDescription" placeholder="Meta Description" id="" cols="30" rows="10"
                                            class="form-control">
                                            {{ old('metaDescription') }} 
                                        </textarea>

                                        <div class="text-danger">{{ $errors->first('metaDescription') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Keywords <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="metaKeywords" value="{{ old('metaKeywords') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Meta Keywords">
                                        <div class="text-danger">{{ $errors->first('metaKeywords') }}</div>
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
