@extends('client.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        .active-color {
            border: 2px solid !important;
        }
    </style>
@endsection
@section('content')
    <main class="main">

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>

                    <li class="breadcrumb-item"><a href="javascript:;">Sản phẩm yêu thích</a></li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    Hiển thị <span>{{ $getProduct->perPage() }} của {{ $getProduct->total() }}</span>
                                    Sản phẩm
                                </div><!-- End .toolbox-info -->
                            </div><!-- End .toolbox-left -->

                        </div><!-- End .toolbox -->
                        <div id="getProductAjax">
                            @include('client.product._list', ['columnClass' => 'col-6 col-md-3 col-lg-3']);
                        </div>
                    </div><!-- End .col-lg-9 -->

                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
