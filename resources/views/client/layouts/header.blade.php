<header class="header">
    @include('client.layouts.header-top')

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ url('assets/images/logo.png') }}" alt="Molla Logo" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="{{ url('') }}" class="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#" class="sf-with-ul">Cửa hàng</a>

                            <div class="megamenu megamenu-md">
                                <div class="row no-gutters">
                                    <div class="col-md-12">
                                        <div class="menu-col">
                                            <div class="row">
                                                @php
                                                    $categories = App\Models\CategoryModel::getRecordActive();
                                                @endphp
                                                @foreach ($categories as $category)
                                                    <div class="col-md-4 mb-2">

                                                        <a href="{{ url($category->slug) }}"
                                                            class="menu-title">{{ $category->name }}</a>
                                                        <!-- End .menu-title -->
                                                        <ul>
                                                            @foreach ($category->getSubCategory as $SubCategory)
                                                                <li><a
                                                                        href="{{ url($category->slug . '/' . $SubCategory->slug) }}">{{ $SubCategory->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div><!-- End .col-md-4 -->
                                                @endforeach


                                            </div><!-- End .row -->
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-8 -->


                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-md -->
                        </li>


                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" title="Search"><i
                            class="icon-search"></i></a>
                    <form action="{{ url('search') }}" method="get">
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Tìm kiếm</label>
                            <input type="search" class="form-control" name="q" id="q"
                                placeholder="Search in..." required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->

                <div class="dropdown cart-dropdown">
                    <a href="{{ url('cart') }}" class="dropdown-toggle" role="button" aria-haspopup="true"
                        aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count">{{ Cart::getContent()->count() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="cartRender">
                            <div class="dropdown-cart-products">
                                @foreach (Cart::getContent() as $value)
                                    @php
                                        $getProductCart = App\Models\ProductModel::find($value->attributes['product_id']);
                                    @endphp
                                    @if (!empty($getProductCart))
                                        @php
                                            $getImageProductCart = $getProductCart->getImageByIdProClient(
                                                $value->attributes['product_id'],
                                            );
                                        @endphp
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a href="{{ url($getProductCart->slug) }}">{{ $getProductCart->title }}</a>
                                                </h4>
                                                @php
                                                    $getProductSize = App\Models\ProductSizeModel::find(
                                                        $value->attributes['size_id'],
                                                    );
                                                @endphp
                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">{{ $value->quantity }}</span>
                                                    x
                                                    @php
                                                        $basePrice = $getProductCart->price;
                                                        $sizePrice = $getProductSize ? $getProductSize->price : 0;
                                                        $quantity = $value->quantity;
                                                        $totalPrice = ($basePrice + $sizePrice) * $quantity;
                                                    @endphp
    
                                                    {{ number_format($totalPrice, 0, ',', '.') }} VNĐ
                                                </span>
                                            </div><!-- End .product-cart-details -->
    
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    @if (!empty($getImageProductCart) && !empty($getImageProductCart->getImage()))
                                                        <img src="{{ $getImageProductCart->getImage() }}" alt="product">
                                                    @endif
    
                                                </a>
                                            </figure>
                                            <a href="{{ url('cart/delete/' . $value->id) }}" class="btn-remove"
                                                title="Remove Product"><i class="icon-close"></i></a>
                                        </div><!-- End .product -->
                                    @endif
                                @endforeach
    
                            </div><!-- End .cart-product -->
    
                            <div class="dropdown-cart-total">
                                <span>Tổng</span>
    
                                <span
                                    class="cart-total-price">{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}VNĐ</span>
                            </div><!-- End .dropdown-cart-total -->
                        </div>
                        

                        <div class="dropdown-cart-action">
                            <a href="{{ url('cart') }}" class="btn btn-primary">Giỏ hàng</a>
                            <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2"><span>Thanh toán</span><i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .dropdown-cart-total -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->
