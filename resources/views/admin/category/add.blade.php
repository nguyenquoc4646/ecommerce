@extends('admin.layouts.app')
@section('title')
    Tạo mới danh mục
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
                                <h5>Tạo mới danh mục</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên danh mục <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="categoryName" value="{{ old('categoryName') }}"
                                            class="form-control" id="exampleInputEmail1"
                                            placeholder="Nhập Tên danh mục ...">
                                        <div class="text-danger">{{ $errors->first('categoryName') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hình ảnh <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="image" value="{{ old('image') }}"
                                            class="form-control" id="exampleInputEmail1">
                                           
                                        <div class="text-danger">{{ $errors->first('image') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên nút: <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="button_name" value="{{ old('button_name') }}"
                                            class="form-control" id="exampleInputEmail1"
                                            placeholder="Nhập...">
                                        <div class="text-danger">{{ $errors->first('button_name') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hiển thị trang chủ <span class="text-danger">*</span>
                                        </label>
                                        <input  type="checkbox" name="is_home">
                                            
                                           
                                        <div class="text-danger">{{ $errors->first('is_home') }}</div>
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
