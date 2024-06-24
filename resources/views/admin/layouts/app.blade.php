<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Ecommerce</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/assets_admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets_admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ url('assets_admin/sweet-alert/sweetalert2.min.css') }}">
    @yield('style')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('admin.layouts.header')

                @yield('content')

        @include('admin.layouts.footer')
    </div>
    <script src="/assets_admin/plugins/jquery/jquery.min.js"></script>
    <script src="/assets_admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets_admin/dist/js/adminlte.js"></script>
    <script src="{{ url('assets_admin/sweet-alert/sweetalert2.all.min.js') }}"></script>


    @yield('script')
</body>

</html>
