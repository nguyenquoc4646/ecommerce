@extends('admin.layouts.app')
@section('title')
    Thêm mã giảm giá
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
                                <h5>Thêm mã giảm giá</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mã giảm giá: <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="discountName" value="{{ old('discountName') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Nhập mã giảm ...">
                                        <div class="text-danger">{{ $errors->first('discountName') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Loại (%/VNĐ) : <span class="text-danger">*</span>
                                        </label>
                                        <select name="type" class="form-control">
                                            <option value="Amount" {{ old('type') == 'Amount' ? 'selected' : '' }}>Số tiền
                                            </option>
                                            <option value="Percent" {{ old('type') == 'Percent' ? 'selected' : '' }}>Phần
                                                trăm
                                            </option>
                                        </select>
                                        <div class="text-danger">{{ $errors->first('type') }}</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số tiền / Phần trăm <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="percen_amount" value="{{ old('percen_amount') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Nhập ...">
                                        <div class="text-danger">{{ $errors->first('percen_amount') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày hết hạn : <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="expire_date" value="{{ old('expire_date') }}"
                                            class="form-control">
                                        <div class="text-danger">{{ $errors->first('expire_date') }}</div>
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
