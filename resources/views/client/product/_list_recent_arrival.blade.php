<div class="products">
    @include('client.product._list', ['columnClass' => 'col-6 col-md-3 col-lg-3'])

</div><!-- End .products -->
<div class="more-container text-center">
    <a href="{{ url($getCategory->slug)}}" class="btn btn-outline-darker btn-more"><span>XEM THÊM SẢN PHẨM</span><i
            class="icon-long-arrow-down"></i></a>
</div>