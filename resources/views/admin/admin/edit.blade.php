@extends('admin.layouts.app')
@section('title')
    Cập nhật tài khoản
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
                                <h5>Cập nhật tài khoản : {{ $data['name'] }}</h5>
                            </div>

                        </div>
                        <div class="card card-primary">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên:</label>
                                        <input type="text" name="username" class="form-control" required
                                            id="exampleInputEmail1" placeholder="Nhập họ và tên ..."
                                            value="{{ old('username', $data['name']) }}">
                                        <div class="text-danger">{{ $errors->first('username') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ email:</label>
                                        <input type="email" name="email" class="form-control" required
                                            id="exampleInputEmail1" placeholder="Nhập email ..."
                                            value="{{ old('email', $data['email']) }}">
                                        <div class="text-danger">{{ $errors->first('email') }}</div>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mật khẩu:</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1" placeholder="Nhập mật khẩu ...">
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                        <p>Bạn có muốn thay đổi mật khẩu, hãy tạo mật khẩu mới</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Trạng thái</label>
                                        <select name="status" class="form-control" required>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Khóa
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Quản trị viên</label>
                                        <br>
                                        <input type="checkbox" name="role"  {{$data->is_admin == 1 ? 'checked' : ''}}
                                            id="role" >
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
