<div class="products mb-3">
    <div class="row justify-content-center">

        @foreach ($getProduct as $value)
            @php
                $getImageByIdProClient = $value->getImageByIdProClient($value->id);
            @endphp
            <div class="{{ $columnClass ?? 'col-6 col-md-4 col-lg-4' }}">
                <div class="product product-7 text-center">
                    <figure class="product-media">

                        <a href="{{ $value->slug }}">
                            @if (!empty($getImageByIdProClient) && !empty($getImageByIdProClient->getImage()))
                                <img src="{{ $getImageByIdProClient->getImage() }}" alt="Product image"
                                    class="product-image">
                            @endif

                        </a>

                        <div class="product-action-vertical">
                            @if (!empty(Auth::check()))
                                <a href="javascript:;"
                                    class="btn-product-icon btn-wishlist btn-expandable add_to_wishlist btn-wishlist_add{{ $value->id }} {{ !empty($value->checkWishlist($value->id)) ? 'btn-add-wishlist' : '' }}"
                                    title="Wishlist" id="{{ $value->id }}">
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
                                href="{{ url($value->slug_category . '/' . $value->slug_sub_category) }}">{{ $value->name_sub_category }}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{ url($value->slug) }}">{{ $value->title }}</a></h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            {{ number_format($value->price, 0, ',', '.') }}VNĐ
                        </div><!-- End .product-price -->
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: {{ $value->getStarAvg($value->id) }}%;"></div>
                                <!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <span class="ratings-text">({{ $value->totalReview() }} Đánh giá )</span>
                        </div><!-- End .rating-container -->


                    </div><!-- End .product-body -->
                </div><!-- End .product -->
            </div><!-- End .col-sm-6 col-lg-4 -->
        @endforeach

    </div><!-- End .row -->
</div><!-- End .products -->
{{-- {{ $getProByCate->links() }} --}}
{{-- <script>
                           $(document).ready(function() {
                               $("div > p.small.text-muted").parent().remove();
                           });
                       </script> --}}
