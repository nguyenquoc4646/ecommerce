@extends('admin.layouts.app')
@section('title')
    Cập nhật danh mục phụ
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
                                <h5>Cập nhật danh mục phụ : {{ $data->name }}</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên danh mục <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="categoryName"
                                            value="{{ old('categoryName', $data->name) }}" class="form-control"
                                            id="exampleInputEmail1" placeholder="Nhập Tên danh mục ...">
                                        <div class="text-danger">{{ $errors->first('categoryName') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Chọn danh mục <span class="text-danger">*</span>
                                        </label>
                                        <select name="category_id" class="form-control">
                                            @foreach ($categories as $item)
                                            <option value="{{$item->id}}" {{$item->id == $data->id_category?"selected":""}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>

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
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta title <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="metaTitle" class="form-control" id="exampleInputEmail1"
                                            value="{{ $data->meta_title }}" placeholder="Meta title">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="metaDescription" placeholder="Meta Description" id="" cols="30" rows="10"
                                            class="form-control">
                                            {{ $data->meta_description }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Keywords <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="metaKeywords" value="{{ $data->meta_keywords }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Meta Keywords">
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
