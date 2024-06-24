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
        <div class="page-header text-center" style="background-image: url({{ url('assets/images/page-header-bg.jpg') }})">
            <div class="container">
                @if (!empty($subCategory))
                    <h1 class="page-title">{{ $subCategory->name }}</h1>
                @elseif(!empty($category))
                    <h1 class="page-title">{{ $category->name }}</h1>
                @else
                    <h1 class="page-title">Tìm kiếm : {{ Request::get('q') }}</h1>
                @endif

            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>

                    <li class="breadcrumb-item"><a href="javascript:;">Cửa hàng</a></li>
                    @if (!empty($subCategory))
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subCategory->name }}</li>
                        @elseif(!empty($category))
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    @endif

                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    Hiển thị <span>{{ $getProduct->perPage() }} of {{ $getProduct->total() }}</span>
                                    Sản phẩm
                                </div><!-- End .toolbox-info -->
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-right">
                                <div class="toolbox-sort">
                                    <label for="sortby">Sắp xếp:</label>
                                    <div class="select-custom">
                                        <select name="sortby" id="sortby" class="form-control ChangeSortBy">
                                            <option value="">Chọn tiêu chí</option>
                                            <option value="popularity">Phổ biến nhất</option>
                                            <option value="rating">Đánh giá</option>
                                            <option value="date">Ngày tạo</option>
                                        </select>
                                    </div>
                                </div><!-- End .toolbox-sort -->

                            </div><!-- End .toolbox-right -->
                        </div><!-- End .toolbox -->
                        <div id="getProductAjax">
                            @include('client.product._list')
                        </div>
                        <div class="text-center">
                            <a href="javascript:;" @if (empty($page)) style="display:none" @endif
                                data-page="{{ $page }}" class="btn btn-primary loadMore">
                                XEM THÊM
                            </a>
                        </div>

                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3 order-lg-first">
                        <form action="" id="filterForm" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ !empty(Request::get('q')) ? Request::get('q') : '' }}"
                                name="q">
                            <input type="hidden" value="{{ !empty($category->id) ? $category->id : '' }}"
                                name="old_category_id">
                            <input type="hidden" value="{{ !empty($subCategory->id) ? $subCategory->id : '' }}"
                                name="old_sub_category_id">
                            <input type="hidden" name="sub_category_id" id="get_sub_category_id">
                            <input type="hidden" name="brand_id" id="get_brand_id">
                            <input type="hidden" name="color_id" id="get_color_id">
                            <input type="hidden" name="sort_by" id="get_sort_by">

                            <input type="hidden" name="get_start_price" id="get_start_price">
                            <input type="hidden" name="get_end_price" id="get_end_price">
                        </form>
                        <div class="sidebar sidebar-shop">
                            <div class="widget widget-clean">
                                <label>Lọc:</label>
                                <a href="#" class="sidebar-filter-clear">Xóa tất cả</a>
                            </div><!-- End .widget widget-clean -->
                            @if (!empty($getSubCategoryFilter))
                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title">
                                        <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                            aria-controls="widget-1">
                                            Danh mục
                                        </a>
                                    </h3><!-- End .widget-title -->

                                    <div class="collapse show" id="widget-1">
                                        <div class="widget-body">
                                            <div class="filter-items filter-items-count">
                                                @foreach ($getSubCategoryFilter as $value)
                                                    <div class="filter-item">
                                                        <div class="custom-control custom-checkbox">
                                                            <input value="{{ $value->id }}" type="checkbox"
                                                                class="custom-control-input ChangeCategory"
                                                                id="cat-{{ $value->id }}">

                                                            <label class="custom-control-label"
                                                                for="cat-{{ $value->id }}">{{ $value->name }}</label>
                                                        </div><!-- End .custom-checkbox -->
                                                        <span class="item-count">{{ $value->totalProduct() }}</span>
                                                    </div><!-- End .filter-item -->
                                                @endforeach


                                            </div><!-- End .filter-items -->
                                        </div><!-- End .widget-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .widget -->
                            @endif

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true"
                                        aria-controls="widget-3">
                                        Màu sắc
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-3">
                                    <div class="widget-body">
                                        <div class="filter-colors">
                                            @foreach ($getColor as $value)
                                                <a class="ChangeColor" data-val="0" id="{{ $value->id }}"
                                                    style="background: {{ $value->code }};">
                                                    <span class="sr-only"></span></a>
                                            @endforeach


                                        </div><!-- End .filter-colors -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true"
                                        aria-controls="widget-4">
                                        Thương hiệu
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-4">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            @foreach ($getBrand as $value)
                                                <div class="filter-item">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input ChangeBrand"
                                                            id="brand-{{ $value->id }}" value="{{ $value->id }}">
                                                        <label class="custom-control-label"
                                                            for="brand-{{ $value->id }}">{{ $value->name }}</label>
                                                    </div><!-- End .custom-checkbox -->
                                                </div><!-- End .filter-item -->
                                            @endforeach


                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true"
                                        aria-controls="widget-5">
                                        Giá
                                    </a>
                                </h3><!-- End .widget-title -->
                                
                                <div class="collapse show" id="widget-5">
                                    <div class="widget-body">
                                        <div class="filter-price">
                                            <div class="filter-price-text">
                                                Khoảng giá:
                                                <span id="filter-price-range"></span>
                                            </div><!-- End .filter-price-text -->

                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .filter-price -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div><!-- End .sidebar sidebar-shop -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
@section('script')
    <script src="{{ url('assets/js/wNumb.js') }}"></script>
    <script src="{{ url('assets/js/nouislider.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap-input-spinner.js') }}"></script>

    <script type="text/javascript">
        console.log($('#filterForm'))
        $('.ChangeSortBy').change(function() {
            var id = $(this).val()
            $('#get_sort_by').val(id);
        })
        $('.ChangeCategory').change(function() {
            var ids = ''

            $('.ChangeCategory').each(function() {

                if (this.checked) {
                    var id = $(this).val()
                    ids += id + ','

                }

            });
            $('#get_sub_category_id').val(ids);
            filterForm()
        })

        $('.ChangeBrand').change(function() {
            var ids = ''
            $('.ChangeBrand').each(function() {

                if (this.checked) {
                    var id = $(this).val()

                    ids += id + ','

                }

            });

            $('#get_brand_id').val(ids);
            filterForm()
        })
        $('.ChangeColor').click(function() {
            // var id = $(this).attr('id');
            var status = $(this).attr('data-val');
            if (status == 0) {
                $(this).attr('data-val', 1);
                $(this).addClass('active-color');
            } else {
                $(this).attr('data-val', 0);
                $(this).removeClass('active-color');
            }
            var ids = ''
            $('.ChangeColor').each(function() {
                var status = $(this).attr('data-val');
                if (status == 1) {
                    var id = $(this).attr('id')
                    ids += id + ','
                }

            });
            $('#get_color_id').val(ids);
            filterForm()
        })
        var xhr;

        // Kiểm tra xem có request AJAX nào đang chờ xử lý không


        function filterForm() {
            if (xhr && xhr.readyState !== 4) {
                // Nếu có, hủy request đó
                xhr.abort();
            }
            xhr = $.ajax({
                type: 'POST',
                url: '{{ url('get_product_filter_ajax') }}',
                data: $('#filterForm').serialize(),
                dataType: 'json',
                success: function(data) {
                    $('#getProductAjax').html(data.success)
                    $('.loadMore').attr('data-page', data.page)
                    if (data.page == 0) {
                        $('.loadMore').hide()
                    } else {
                        $('.loadMore').show()
                    }
                },
                error: function(data) {

                }
            });
        }
        $('body').delegate('.loadMore', 'click', function() {
            $('.loadMore').html('ĐANG TẢI ...')
            var page = $(this).attr('data-page')
            if (xhr && xhr.readyState !== 4) {
                // Nếu có, hủy request đó
                xhr.abort();
            }
            xhr = $.ajax({
                type: 'POST',
                url: '{{ url('get_product_filter_ajax') }}?page=' + page,
                data: $('#filterForm').serialize(),
                dataType: 'json',
                success: function(data) {
                    $('#getProductAjax').append(data.success)
                    $('.loadMore').attr('data-page', data.page)
                    $('.loadMore').html('XEM THÊM   ')
                    if (data.page == 0) {
                        $('.loadMore').hide()
                    } else {
                        $('.loadMore').show()
                    }
                },
                error: function(data) {

                }
            });
        })
        var i = 0
        if (typeof noUiSlider === 'object') {
            var priceSlider = document.getElementById('price-slider');

            // Check if #price-slider elem is exists if not return
            // to prevent error logs


            noUiSlider.create(priceSlider, {
                start: [0, 15000000],
                connect: true,
                step: 50000,
                margin: 50000,
                range: {
                    'min': 0,
                    'max': 15000000
                },
                tooltips: true,
                format: wNumb({
                    decimals: 0,
                    prefix: 'VNĐ'

                })
            });

            // Update Price Range
            priceSlider.noUiSlider.on('update', function(values, handle) {
                var start_price = values[0]
                var end_price = values[1]
                $('#get_start_price').val(start_price)
                $('#get_end_price').val(end_price)

                $('#filter-price-range').text(values.join(' - '));
                if (i == 0 || i == 1) {
                    i++
                } else {
                    filterForm()
                }

            });
        }
    </script>
@endsection
