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
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Họ <span class="text-danger">*</span></label>
                                                    <input type="text" name="firstName" value="{{ !empty($user->firstName)?$user->firstName:"" }}" placeholder="Họ ..."
                                                        class="form-control">
                                                </div><!-- End .col-sm-6 -->

                                                <div class="col-sm-6">
                                                    <label>Tên <span class="text-danger">*</span></label>
                                                    <input type="text" name="lastName" value="{{ !empty($user->name)?$user->name:"" }}" placeholder="Tên ..."
                                                        class="form-control" required>
                                                </div><!-- End .col-sm-6 -->
                                            </div><!-- End .row -->



                                            <label>Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="Địa chỉ ..." value="{{ !empty($user->address)?$user->address:"" }}">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Địa chỉ email <span class="text-danger">*</span></label>
                                                    <input type="email" value="{{ !empty($user->email)?$user->email:"" }}" name="email" class="form-control" required
                                                        placeholder="Email ..." >
                                                </div><!-- End .col-sm-6 -->

                                                <div class="col-sm-6">
                                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                                    <input type="text" value="{{ !empty($user->phone)?$user->phone:"" }}" name="phone" placeholder="Số điện thoại ..."
                                                        class="form-control">
                                                </div><!-- End .col-sm-6 -->
                                            </div><!-- End .row -->
                                        </div><!-- End .col-lg-9 -->

                                    </div><!-- End .row -->

                                    <button style="width:175px;" type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Cập nhật thông tin</span>
                                        <span class="btn-hover-text">Update Infor User</span>
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
