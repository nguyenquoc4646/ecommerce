<!DOCTYPE html>
<html lang="en">


<!-- molla/index-2.html  22 Nov 2019 09:55:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($meta_title) ? $meta_title : '' }}
    </title>
    @if (!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif
    @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif

    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/images/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/images/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('assets/images/icons/site.html') }}">
    <link rel="mask-icon" href="{{ url('assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
    <link rel="shortcut icon" href="{{ url('assets/images/icons/favicon.ico') }}">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{ url('assets/images/icons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('assets/sweet-alert/sweetalert2.min.css') }}">
    <!-- Main CSS File -->
    @yield('style')
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .btn-add-wishlist:before {
            content: '\f233' !important;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        @include('client.layouts.header')
        @yield('content')
        @include('client.layouts.footer')
        @include('client.layouts.mobile-menu')
        <!-- Sign in / Register Modal -->
        <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="icon-close"></i></span>
                        </button>

                        <div class="form-box">
                            <div class="form-tab">
                                <ul class="nav nav-pills nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                            role="tab" aria-controls="signin" aria-selected="true">Đăng nhập</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                            role="tab" aria-controls="register" aria-selected="false">Đăng kí</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="tab-content-5">
                                    <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                        aria-labelledby="signin-tab">
                                        <form action="" id="formLogin">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="singin-email">Địa chỉ Email: <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="email"
                                                    name="email" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="singin-password">Mật khẩu <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-footer">
                                                <button type="submit" class="btn btn-outline-primary-2 btn-login">
                                                    <span>ĐĂNG NHẬP</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="signin-remember" name="remember">
                                                    <label class="custom-control-label" for="signin-remember">Ghi
                                                        nhớ</label>
                                                </div><!-- End .custom-checkbox -->

                                                <a href="{{ url('forgot_password') }}" class="forgot-link">Bạn đã
                                                    quên mật khẩu ?</a>
                                            </div><!-- End .form-footer -->
                                        </form>
                                        {{-- <div class="form-choice">
                                    <p class="text-center">or sign in with</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login btn-g">
                                                <i class="icon-google"></i>
                                                Login With Google
                                            </a>
                                        </div><!-- End .col-6 -->
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login btn-f">
                                                <i class="icon-facebook-f"></i>
                                                Login With Facebook
                                            </a>
                                        </div><!-- End .col-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .form-choice --> --}}
                                    </div><!-- .End .tab-pane -->
                                    <div class="tab-pane fade" id="register" role="tabpanel"
                                        aria-labelledby="register-tab">
                                        <form action="#" id="formRegister">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="email">Họ và tên: <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="email"
                                                    name="username" required>
                                            </div><!-- End .form-group -->
                                            <div class="form-group">
                                                <label for="email">Địa chỉ Email: <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email"
                                                    name="email" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="password">Mật khẩu: <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-footer">
                                                <button type="submit" class="btn btn-outline-primary-2">
                                                    <span>ĐĂNG KÍ</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="register-policy" required>
                                                    <label class="custom-control-label" for="register-policy">Tôi đồng
                                                        ý với chính sách bảo mật <span
                                                            class="text-danger">*</span></label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .form-footer -->
                                        </form>
                                        {{-- <div class="form-choice">
                                    <p class="text-center">or sign in with</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login btn-g">
                                                <i class="icon-google"></i>
                                                Login With Google
                                            </a>
                                        </div><!-- End .col-6 -->
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login  btn-f">
                                                <i class="icon-facebook-f"></i>
                                                Login With Facebook
                                            </a>
                                        </div><!-- End .col-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .form-choice --> --}}
                                    </div><!-- .End .tab-pane -->
                                </div><!-- End .tab-content -->
                            </div><!-- End .form-tab -->
                        </div><!-- End .form-box -->
                    </div><!-- End .modal-body -->
                </div><!-- End .modal-content -->
            </div><!-- End .modal-dialog -->
        </div><!-- End .modal -->
        {{-- @include('client.layouts.newsletter-popup') --}}
        <!-- Plugins JS File -->
        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('assets/js/jquery.hoverIntent.min.js') }}"></script>
        <script src="{{ url('assets/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ url('assets/js/superfish.min.js') }}"></script>
        <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ url('assets/sweet-alert/sweetalert2.all.min.js') }}"></script>
        <!-- Main JS File -->
        @yield('script')
        <script src="{{ url('assets/js/main.js') }}"></script>
        <script type="text/javascript">
            $('body').delegate('#formLogin', 'submit', function(e) {
                e.preventDefault()
                $.ajax({
                    type: 'POST',
                    url: '{{ url('auth_login_client') }}',
                    data: $('#formLogin').serialize(),
                    dataType: 'json',
                    success: function(data) {

                        Swal.fire({
                            icon: "error",
                            title: "Lỗi rồi ...",
                            text: data.failEmailOrPass
                        });

                        if (data.status == true) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                setTimeout(() => {
                                    location.reload();
                                });
                            });

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Lỗi rồi ...",
                                text: data.message,
                            });
                        }
                    },
                    error: function(data) {

                    }
                });
            })

            // đăng nhập

            $('body').delegate('#formRegister', 'submit', function(e) {
                e.preventDefault()
                $.ajax({
                    type: 'POST',
                    url: '{{ url('auth_register_client') }}',
                    data: $('#formRegister').serialize(),
                    dataType: 'json',
                    success: function(data) {

                        if (data.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Thành công",
                                text: data.message,
                            }).then(result => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Lỗi rồi ...",
                                text: data.message,
                            });
                        }

                    },
                    error: function(data) {

                    }
                });
            })
            $('body').delegate('.add_to_wishlist', 'click', function() {
                var product_id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: '{{ url('add_wishlist') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        product_id: product_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == true) {

                            $('.btn-wishlist_add' + product_id).addClass('btn-add-wishlist')
                        } else {
                            $('.btn-wishlist_add' + product_id).removeClass('btn-add-wishlist')
                        }
                    }
                })
            })
        </script>
</body>


<!-- molla/index-2.html  22 Nov 2019 09:55:42 GMT -->

</html>
