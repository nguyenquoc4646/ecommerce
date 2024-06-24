<div class="intro-section bg-lighter pt-5 pb-6">

    <div class="row">
        <div class="col-lg-12">
            <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside"
                    data-toggle="owl"
                    data-owl-options='{
                            "nav": false, 
                            "responsive": {
                                "768": {
                                    "nav": true
                                }
                            }
                        }'>
                    @foreach ($getSlider as $item)
                        <div class="intro-slide">
                            <figure class="slide-image">
                                <picture>
                                    <source media="(max-width: 480px)" srcset="assets/images/slider/slide-1-480w.jpg">
                                    <img src="{{ $item->getImage() }}" alt="Image Desc">
                                </picture>
                            </figure><!-- End .slide-image -->

                            <div class="intro-content">
                                <h1 class="intro-title">{!! $item->title !!}</h1><!-- End .intro-title -->
                                @if (!empty($item->button_name) && !empty($item->link))
                                    <a href="{{ $item->link }}" class="btn btn-outline-white">
                                        <span>{{ $item->button_name }}</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </a>
                                @endif

                            </div><!-- End .intro-content -->
                        </div><!-- End .intro-slide -->
                    @endforeach



                </div><!-- End .intro-slider owl-carousel owl-simple -->

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->
        </div><!-- End .col-lg-8 -->

    </div>
</div>
