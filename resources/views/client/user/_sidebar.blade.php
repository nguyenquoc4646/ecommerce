<aside class="col-md-4 col-lg-3">
    <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if (Request::segment(2) == 'dashboard') active @endif" href="{{ url('user/dashboard') }}" >Bảng điều khiển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (Request::segment(2) == 'orders') active @endif" href="{{ url('user/orders') }}">Đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (Request::segment(2) == 'edit-profile') active @endif" href="{{ url('user/edit-profile') }}">Chỉnh sửa thông tin</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (Request::segment(2) == 'change-password') active @endif" href="{{ url('user/change-password') }}">Đổi mật khẩu</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('logout') }}">Đăng xuất</a>
        </li>
    </ul>
</aside><!-- End .col-lg-3 -->
