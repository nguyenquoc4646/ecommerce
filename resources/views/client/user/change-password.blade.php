@extends('client.layouts.app')
@section('content')
    <main class="main">

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Cửa hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản của tôi</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="row">
                        @include('client.user._sidebar')

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                @include('client.layouts._message')
                                <form action="" id="submitForm" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>mật khẩu cũ <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="old_password"
                                                placeholder="mật khẩu cũ ..." required>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Mậ khẩu mới : <span class="text-danger">*</span></label>
                                                    <input type="text" name="password" placeholder="Mật khẩu mới"
                                                        class="form-control" required>
                                                </div><!-- End .col-sm-6 -->

                                                <div class="col-sm-6">
                                                    <label>Xác nhận mật khẩu : <span class="text-danger">*</span></label>
                                                    <input type="text" name="confirmPassword"
                                                        placeholder="Xác nhận mật khẩu ..." class="form-control" required>
                                                </div><!-- End .col-sm-6 -->
                                            </div><!-- End .row -->
                                        </div><!-- End .col-lg-9 -->

                                    </div><!-- End .row -->

                                    <button style="width:175px;" type="submit"
                                        class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Đổi mật khẩu</span>
                                        <span class="btn-hover-text">Cập nhật mật khẩu</span>
                                    </button>
                                </form>



                            </div>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
