@extends('client.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        /* .product-details-quantity .input-spinner{
                                    display: none;
                                } */
        .product-details-quantity #numberInput {
            display: block;
        }
    </style>
@endsection
@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url($getProduct->getCategory->slug) }}">{{ $getProduct->getCategory->name }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url($getProduct->getCategory->slug . '/' . $getProduct->getSubCategory->slug) }}">{{ $getProduct->getSubCategory->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $getProduct->title }}</li>
                </ol>

                <nav class="product-pager ml-auto" aria-label="Product">
                    <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                        <i class="icon-angle-left"></i>
                        <span>Prev</span>
                    </a>

                    <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                        <span>Next</span>
                        <i class="icon-angle-right"></i>
                    </a>
                </nav><!-- End .pager-nav -->
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <div class="product-details-top mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <figure class="product-main-image">
                                    @php
                                        $getImageByIdProClient = $getProduct->getImageByIdProClient($getProduct->id);
                                    @endphp
                                    @if (!empty($getImageByIdProClient) && !empty($getImageByIdProClient->getImage()))
                                        <img id="product-zoom" src="{{ $getImageByIdProClient->getImage() }}"
                                            data-zoom-image="{{ $getImageByIdProClient->getImage() }}" alt="product image">
                                    @endif


                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    @foreach ($getProduct->getImageByIdPro as $image)
                                        @if (!empty($image->getImage()))
                                            <a class="product-gallery-item" href="#"
                                                data-image="{{ $image->getImage() }}"
                                                data-zoom-image="{{ $image->getImage() }}">
                                                <img src="{{ $image->getImage() }}">
                                            </a>
                                        @endif
                                    @endforeach



                                </div><!-- End .product-image-gallery -->
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title">{{ $getProduct->title }}</h1>
                                <!-- End .product-title -->

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val"
                                            style="width:  {{ $getProduct->getStarAvg($getProduct->id) }}%;"></div>
                                        <!-- End .ratings-val -->

                                    </div><!-- End .ratings -->
                                    <a class="ratings-text" href="#product-review-link"
                                        id="review-link">({{ $getProduct->totalReview() }} Đánh giá )</a>
                                </div><!-- End .rating-container -->

                                <div class="product-price">
                                    {{ number_format($getProduct->price, 0, ',', '.') }}VNĐ
                                </div><!-- End .product-price -->

                                <div class="product-content">
                                    <p>{!! $getProduct->short_description !!}</p>
                                </div><!-- End .product-content -->
                                <form method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="product_id" name="product_id" value="{{ $getProduct->id }}">
                                    @if (!empty($getProduct->checkedColor->count()))
                                        <div class="details-filter-row details-row-size">
                                            <label for="size">Màu sắc:</label>
                                            <div class="select-custom">
                                                <select name="color_id" id="color_id" class="form-control">
                                                    <option value="">Chọn màu----</option>
                                                    @foreach ($getProduct->checkedColor as $color)
                                                        <option value="{{ $color->getColor->id }}">
                                                            {{ $color->getColor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="hiddenColorId"> <span id="requireColor"
                                                    style="color:red"></span>
                                            </div>
                                        </div>
                                    @endif


                                    @if (!empty($getProduct->checkedSize->count()))
                                        <div class="details-filter-row details-row-size">
                                            <label for="size">Kích cỡ:</label>
                                            <div class="select-custom">
                                                <select name="size_id" id="size_id" class="form-control getSizePrice">
                                                    <option value="" data-price="0">Chọn kích cỡ---</option>
                                                    @foreach ($getProduct->checkedSize as $size)
                                                        <option data-price="{{ $size->price }}"
                                                            value="{{ $size->id }}">
                                                            {{ $size->name }}
                                                            ({{ number_format($size->price, 0, ',', '.') }}VNĐ)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="hiddenSizeId"> <span id="requireSize"
                                                    style="color:red"></span>
                                            </div><!-- End .select-custom -->
                                    @endif

                            </div><!-- End .details-filter-row -->

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="numberInput" class="form-control" value="1"
                                        min="1" step="1" max="{{ $size->amount }}" name="qty"
                                        data-decimals="0" onkeydown="return false;">

                                </div><!-- End .product-details-quantity -->


                            </div><!-- End .details-filter-row -->

                            <div class="product-details-action">

                                <button class="btn-product btn-cart" id="submitFormAddToCart" type="button">Thêm giỏ
                                    hàng</button>

                                <div class="details-action-wrapper">

                                    @if (!empty(Auth::check()))
                                        <a href="javascript:;"
                                            class="add_to_wishlist btn-wishlist_add{{ $getProduct->id }} {{ !empty($getProduct->checkWishlist($getProduct->id)) ? 'btn-add-wishlist' : '' }} btn-product btn-wishlist"
                                            title="Wishlist" id="{{ $getProduct->id }}">
                                            <span>Yêu thích</span>
                                        </a>
                                    @else
                                        <a href="#signin-modal" data-toggle="modal" class="btn-product btn-wishlist"
                                            title="Wishlist"><span>Yêu thích</span></a>
                                    @endif

                                </div><!-- End .details-action-wrapper -->
                            </div><!-- End .product-details-action -->
                            </form>
                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Danh mục:</span>
                                    <a
                                        href="{{ url($getProduct->getCategory->slug) }}">{{ $getProduct->getCategory->name }}</a>,
                                    <a href="{{ url($getProduct->getSubCategory->slug) }}">{{ $getProduct->getSubCategory->name }}
                                    </a>

                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                            class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                            class="icon-pinterest"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->
        </div><!-- End .container -->

        <div class="product-details-tab product-details-extended">
            <div class="container">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                            role="tab" aria-controls="product-info-tab" aria-selected="false">Additional
                            information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab"
                            role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping &
                            Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                            role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews
                            ({{ $getProduct->totalReview() }})</a>
                    </li>
                </ul>
            </div><!-- End .container -->

            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                    aria-labelledby="product-desc-link">
                    <div class="product-desc-content">
                        <div class="container">
                            {!! $getProduct->description !!}
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        <div class="container">
                            {!! $getProduct->additional_description !!}
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                    aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                        <div class="container">
                            {!! $getProduct->shipping_return !!}
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                    aria-labelledby="product-review-link">
                    <div class="reviews">
                        <div class="container">
                            <h3>Đánh giá ({{ $getProduct->totalReview() }})</h3>
                            @foreach ($evaluate as $value)
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a href="#">{{ $value->name }}.</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val"
                                                        style="width: {{ $value->getPercentStar() }}%;"></div>
                                                    <!-- End .ratings-val -->
                                                </div><!-- End .ratings -->
                                            </div><!-- End .rating-container -->
                                            <span class="review-date">

                                                {{ Carbon\Carbon::parse($value->created_at)->diffForHumans() }}
                                            </span>
                                        </div><!-- End .col -->
                                        <div class="col">
                                            <div class="review-content">
                                                <p>{{ $value->review }}</p>
                                            </div><!-- End .review-content -->


                                        </div><!-- End .col-auto -->
                                    </div><!-- End .row -->
                                </div><!-- End .review -->
                            @endforeach
                            {{ $evaluate->links() }}


                        </div><!-- End .container -->
                    </div><!-- End .reviews -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .product-details-tab -->

        <div class="container">
            <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
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
                @foreach ($getProRelated as $value)
                    @php
                        $getImageByIdProClient = $value->getImageByIdProClient($value->id);
                    @endphp



                    <div class="product product-7">
                        <figure class="product-media">

                            @if (!empty($getImageByIdProClient) && !empty($getImageByIdProClient->getImage()))
                                <a href="product.html">
                                    <img src="{{ $getImageByIdProClient->getImage() }}" alt="Product image"
                                        class="product-image">
                                </a>
                            @endif

                            {{-- 
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>Yêu
                                        thích</span></a>
                            </div> --}}
                            <div class="product-action-vertical">
                                @if (!empty(Auth::check()))
                                    <a href="javascript:;"
                                        class="btn-product-icon btn-wishlist btn-expandable add_to_wishlist btn-wishlist_add{{ $getProduct->id }} {{ !empty($getProduct->checkWishlist($getProduct->id)) ? 'btn-add-wishlist' : '' }}"
                                        title="Wishlist" id="{{ $getProduct->id }}">
                                        <span>Yêu thích</span>
                                    </a>
                                @else
                                    <a href="#signin-modal" data-toggle="modal"
                                        class="btn-product-icon btn-wishlist btn-expandable" title="Wishlist"><span>Yêu
                                            thích</span></a>
                                @endif
                            </div>

                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a
                                    href=" {{ url($value->slug_category . '/' . $value->slug_sub_category) }} ">{{ $value->name_sub_category }}</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">{{ $value->title }}
                            </h3><!-- End .product-title -->
                            <div class="product-price">
                                {{ number_format($getProduct->price, 0, ',', '.') }}VNĐ
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: {{ $getProduct->getStarAvg($value->id) }}%;">
                                    </div><!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">({{ $value->totalReview() }} Đánh giá )</span>
                            </div><!-- End .rating-container -->


                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                @endforeach

            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
@section('script')
    {{-- <script src="{{ url('assets/js/bootstrap-input-spinner.js') }}"></script> --}}
    <script src="{{ url('assets/js/jquery.elevateZoom.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/bootstrap-input-spinner.js') }}"></script> --}}
    <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        // action="{{ url('product/add-to-cart') }}"

        $('#color_id').change(function() {
            var color_id = $(this).val()
            $('#hiddenColorId').val(color_id);
        })
        $('#size_id').change(function() {
            var size_id = $(this).val()
            $('#hiddenSizeId').val(size_id);
        })

        $('body').delegate('#submitFormAddToCart', 'click', function(e) {
            var product_id = $('#product_id').val();
            var quantity = $('#numberInput').val();
            var color_id = $('#hiddenColorId').val();
            var size_id = $('#hiddenSizeId').val();

            var valid = true;

            if (color_id == '') {
                $('#requireColor').html('Chọn ít nhất một màu');
                valid = false;
            } else {
                $('#requireColor').html(''); // Clear any previous error message
            }

            if (size_id == '') {
                $('#requireSize').html('Chọn ít nhất một kích thước');
                valid = false;
            } else {
                $('#requireSize').html(''); // Clear any previous error message
            }

            if (!valid) {
                e.preventDefault();
                return; // Stop execution if validation fails
            }
            $.ajax({
                type: "POST",
                url: '{{ url('product/add-to-cart') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    product_id: product_id,
                    quantity: quantity,
                    color_id: color_id,
                    size_id: size_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $.ajax({
                            type: "GET",
                            url: '{{ url('cart') }}',
                            dataType: 'html',
                            success: function(response) {
                                // Cập nhật nội dung của trang hiện tại với dữ liệu mới từ trang giỏ hàng
                                window.location.reload()
                            }
                        });
                    }
                }
            });


        });
    </script>
@endsection
