@extends('client.layouts.app')
@section('content')
    <main class="main">
        @include('client.layouts.slider')

        <div class="mb-6"></div><!-- End .mb-6 -->

        <div class="container">
            <div class="heading heading-center mb-3">
                <h2 class="title-lg">Sản phẩm xu hướng</h2><!-- End .title -->
            </div><!-- End .heading -->

            <div class="tab-content tab-content-carousel">
                <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel"
                    aria-labelledby="trendy-all-link">
                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":4,
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
                        @foreach ($getProductTrendy as $value)
                            @php
                                $getImageByIdProClient = $value->getImageByIdProClient($value->id);
                            @endphp
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <a href="product.html">
                                        <img src="{{$getImageByIdProClient->getImage()}}" alt="Product image" class="product-image">

                                    </a>

                                    <div class="product-action-vertical">
                                        @if (!empty(Auth::check()))
                                            <a href="javascript:;"
                                                class=" btn-product-icon btn-wishlist add_to_wishlist btn-wishlist_add{{ $value->id }} {{ !empty($value->checkWishlist($value->id)) ? 'btn-add-wishlist' : '' }}"
                                                title="Wishlist" id="{{ $value->id }}">
                                                <span>Yêu thích</span>
                                            </a>
                                        @else
                                            <a href="#signin-modal" data-toggle="modal"
                                                class="btn-product-icon btn-wishlist" title="Wishlist"><span>Yêu
                                                    thích</span></a>
                                        @endif
                                    </div>
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <h3 class="product-title"><a href="{{ $value->slug}}">{{ $value->title}}</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        {{ number_format($value->price, 0, ',', '.') }}VNĐ
                                    </div><!-- End .product-price -->
                                </div><!-- End .product-body -->
                               
                            </div><!-- End .product -->
                        @endforeach


                       

                    </div><!-- End .owl-carousel -->
                </div>

            </div>
        </div>

        <div class="container categories pt-6">
            <h2 class="title-lg text-center mb-4">Mua sắm theo danh mục</h2><!-- End .title-lg text-center -->

            <div class="row">
                @if (!empty($getRecordActiveHome) && count($getRecordActiveHome) > 0)
                    <div class="col-6 col-lg-4">
                        <div class="banner banner-display banner-link-anim">
                            <a href="{{ $getRecordActiveHome[0]->slug }}">
                                <img src="{{ $getRecordActiveHome[0]->getImage() }}" alt="Banner">
                            </a>

                            <div class="banner-content banner-content-center">
                                <h3 class="banner-title text-white"><a
                                        href="{{ $getRecordActiveHome[0]->slug }}">{{ $getRecordActiveHome[0]->name }}</a>
                                </h3>
                                <!-- End .banner-title -->
                                <a href="{{ $getRecordActiveHome[0]->slug }}"
                                    class="btn btn-outline-white banner-link">{{ $getRecordActiveHome[0]->button_name }}<i
                                        class="icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($getRecordActiveHome) && count($getRecordActiveHome) > 1)
                    <div class="col-6 col-lg-4 order-lg-last">
                        <div class="banner banner-display banner-link-anim">
                            <a href="{{ $getRecordActiveHome[1]->slug }}">
                                <img src="{{ $getRecordActiveHome[1]->getImage() }}" alt="Banner">
                            </a>

                            <div class="banner-content banner-content-center">
                                <h3 class="banner-title text-white"><a
                                        href="{{ $getRecordActiveHome[1]->slug }}">{{ $getRecordActiveHome[1]->name }}</a>
                                </h3>
                                <!-- End .banner-title -->
                                <a href="{{ $getRecordActiveHome[1]->slug }}"
                                    class="btn btn-outline-white banner-link">{{ $getRecordActiveHome[0]->button_name }}<i
                                        class="icon-long-arrow-right"></i></a>
                            </div><!-- End .banner-content -->
                        </div><!-- End .banner -->
                    </div><!-- End .col-sm-6 col-lg-3 -->
                @endif
                <div class="col-sm-12 col-lg-4 banners-sm">
                    <div class="row">
                        @if (!empty($getRecordActiveHome) && count($getRecordActiveHome) > 2)
                            <div class="banner banner-display banner-link-anim col-lg-12 col-6">
                                <a href="{{ $getRecordActiveHome[2]->slug }}">
                                    <img src="{{ $getRecordActiveHome[2]->getImage() }}" alt="Banner">
                                </a>

                                <div class="banner-content banner-content-center">
                                    <h3 class="banner-title text-white"><a
                                            href="{{ $getRecordActiveHome[2]->slug }}">{{ $getRecordActiveHome[2]->name }}</a>
                                    </h3>
                                    <!-- End .banner-title -->
                                    <a href="{{ $getRecordActiveHome[2]->slug }}"
                                        class="btn btn-outline-white banner-link">{{ $getRecordActiveHome[2]->button_name }}<i
                                            class="icon-long-arrow-right"></i></a>
                                </div><!-- End .banner-content -->
                            </div><!-- End .banner -->
                        @endif
                        @if (!empty($getRecordActiveHome) && count($getRecordActiveHome) >= 3)
                            <div class="banner banner-display banner-link-anim col-lg-12 col-6">
                                <a href="{{ $getRecordActiveHome[3]->slug }}">
                                    <img src="{{ $getRecordActiveHome[3]->getImage() }}" alt="Banner">
                                </a>

                                <div class="banner-content banner-content-center">
                                    <h3 class="banner-title text-white"><a
                                            href="{{ $getRecordActiveHome[3]->slug }}">{{ $getRecordActiveHome[3]->name }}</a>
                                    </h3>
                                    <!-- End .banner-title -->
                                    <a href="{{ $getRecordActiveHome[3]->slug }}"
                                        class="btn btn-outline-white banner-link">{{ $getRecordActiveHome[2]->button_name }}<i
                                            class="icon-long-arrow-right"></i></a>
                                </div><!-- End .banner-content -->
                            </div><!-- End .banner -->
                        @endif
                    </div>
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- End .mb-6 -->


        <div class="container">
            <div class="heading heading-center mb-6">
                <h2 class="title">Sản phẩm mới nhất</h2><!-- End .title -->

                <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab"
                            aria-controls="top-all-tab" aria-selected="true">Tất cả</a>
                    </li>
                    @foreach ($getRecordActiveHome as $value)
                        <li class="nav-item">
                            <a class="nav-link getCategoryProduct" data-value="{{ $value->id }}"
                                id="top-{{ $value->slug }}-link" data-toggle="tab" href="#top-{{ $value->slug }}-tab"
                                role="tab" aria-controls="top-fur-tab" aria-selected="false">{{ $value->name }}</a>
                        </li>
                    @endforeach

                </ul>
            </div><!-- End .heading -->

            <div class="tab-content">
                <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel"
                    aria-labelledby="top-all-link">
                    <div class="products">
                        @include('client.product._list', ['columnClass' => 'col-6 col-md-3 col-lg-3'])

                    </div><!-- End .products -->
                    <div class="more-container text-center">
                        <a href="{{ url('search') }}" class="btn btn-outline-darker btn-more"><span>XEM THÊM SẢN
                                PHẨM</span><i class="icon-long-arrow-down"></i></a>
                    </div>
                </div><!-- .End .tab-pane -->
                @foreach ($getRecordActiveHome as $value)
                    <div class="tab-pane p-0 fade listProductRecentByIdCate{{ $value->id }}"
                        id="top-{{ $value->slug }}-tab" role="tabpanel"
                        aria-labelledby="top-{{ $value->slug }}-link">

                    </div><!-- .End .tab-pane -->
                @endforeach


            </div><!-- End .tab-content -->

        </div>

        
      
    </main>
@endsection
@section('script')
    <script type="text/javascript">
        $('body').delegate('.getCategoryProduct', 'click', function() {
            var category_id = $(this).attr('data-value')
            $.ajax({
                type: 'GET',
                url: '{{ url('get-recent-pro-home') }}',
                data: {
                    category_id: category_id
                },
                dataType: 'json',
                success: function(response) {
                    $('.listProductRecentByIdCate' + category_id).html(response.success)
                },
                error: function(data) {

                }
            });
        })
    </script>
@endsection
