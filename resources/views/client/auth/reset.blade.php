
@extends('client.layouts.app')
@section('style')
@endsection
@section('content')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đặt lại mật khẩu</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('{{'assets/images/backgrounds/login-bg.jpg'}}')">
        <div class="container">
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">ĐẶT LẠI MẬT KHẨU</a>
                        </li>
                       
                    </ul>
                    <div class="tab-content">
                        @include('client.layouts._message')
                        <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                            
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="register-email-2">Mật khẩu mới <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Nhập mật khẩu ..." id="register-email-2" name="password" required>
                                </div><!-- End .form-group -->
                                <div class="form-group">
                                    <label for="register-email-2">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Xác nhận mật khẩu ..." id="register-email-2" name="re_password" required>
                                </div><!-- End .form-group -->

                              

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>ĐẶT LẠI MẬT KHẨU</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>

                                    <div class="custom-control custom-checkbox">
                                        
                                    </div>
                                </div>
                            </form>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
@endsection
