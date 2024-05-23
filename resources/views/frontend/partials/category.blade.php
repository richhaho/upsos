<!-- Start creative-services section -->
<section id="category" class="categorys sec-p">
    <div class="container">
        <div class="row">
            <div class="col-12 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="sec-title layout-3">
                    <h2>{{ $ps->category_title }}</h2>
                    <p>
                        @php
                            echo $ps->category_subtitle;
                        @endphp
                    </p>
                </div>
            </div>
        </div>
        <div class="swiper category-slider">
            <div class="swiper-wrapper">

                @foreach ($categories as $data)
                
                <div class="swiper-slide wow animate fadeInLeft" data-wow-delay="{{ 200 * $loop->iteration }}ms" data-wow-duration="1500ms">
                    <div class="category-slide">
                        <div class="thumb" style="background-color:{{ $data->color }}">
                            <img src="{{ asset('assets/images/'.$data->photo) }}" alt="">
                        </div>
                        <div class="category-inner">
                            <h4><a href="{{ route('front.servicecategory',$data->slug) }}">{{ $data->title }}</a></h4>
                        </div>
                    </div>
                </div> 
                @endforeach
                
                
            </div>
            <div class="slider-navigations">
                <div class="swiper-button-prev-c"><i class="bi bi-arrow-left"></i></div>
                <div class="swiper-button-next-c"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
</section>
<!-- End creative-services section -->