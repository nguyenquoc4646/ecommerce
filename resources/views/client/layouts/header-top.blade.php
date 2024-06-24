<div class="header-top">
    <div class="container">
        <div class="header-left">
            <div class="header-dropdown">
                <a href="#">VNĐ</a>
            </div><!-- End .header-dropdown -->

            <div class="header-dropdown">
                <a href="#">Vietnamese</a>
            </div><!-- End .header-dropdown -->
        </div><!-- End .header-left -->

        <div class="header-right">
            <ul class="top-menu">
                <li>
                    <a href="#">Links</a>
                    <ul>
                        <li><a href="tel:#"><i class="icon-phone"></i>HOTLINE: 0383701271</a></li>
                        <li>
                            @if (!empty(Auth::check()))
                                <a href="{{ url('wishlist') }}"><i class="icon-heart-o"></i>Yêu thích
                                   </a>
                            @else
                                <a href="#signin-modal" data-toggle="modal"><i class="icon-heart-o"></i>Yêu thích
                                   </a>
                            @endif

                        </li>
                        <li><a href="about.html">CHÚNG TÔI</a></li>
                        <li><a href="contact.html">LIÊN HỆ</a></li>
                        @if (!empty(Auth::check()))
                            <li><a href="{{ url('user/dashboard') }}"><i
                                        class="icon-user"></i>{{ Auth::user()->name }}</a></li>
                        @else
                            <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>ĐĂNG NHẬP</a></li>
                        @endif
                    </ul>
                </li>
            </ul><!-- End .top-menu -->
        </div><!-- End .header-right -->
    </div><!-- End .container -->
</div><!-- End .header-top -->
