@extends('admin.layouts.app')
@section('title')
    Thêm tài khoản
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
                                <h5>Thêm mới tài khoản</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên:</label>
                                        <input type="text" name="username" value="{{ old('username') }}"
                                            class="form-control" id="exampleInputEmail1" placeholder="Nhập họ và tên ...">
                                            <div class="text-danger">{{$errors->first('username')}}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ email:</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email') }}" id="exampleInputEmail1"
                                            placeholder="Nhập email ...">
                                        <div class="text-danger">{{ $errors->first('email') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mật khẩu:</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1" placeholder="Nhập mật khẩu ...">
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="1" {{ old('status') == 1 ? 'checked' : '' }}>Khóa</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Quản trị viên</label>
                                        <br>
                                        <input type="checkbox" name="role" 
                                            id="role" >
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
{{-- @section('script')
    <script src="/assets_admin/dist/js/pages/dashboard3.js"></script>
@endsection --}}
