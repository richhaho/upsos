<!-- Start testimonial-three section -->
<section class="testimonial-three" style="background-image: url({{ asset('assets/images/'.$ps->testimonial_banner) }})">
    <div class="container">
        <div class="row">
            <div class="col-12 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="sec-title layout-3 white">
                    <h2>{{ $ps->testimonial_title }}</h2>
                    <p>
                        @php
                            echo $ps->testimonial_text
                        @endphp
                    </p>
                </div>
            </div>
        </div>
        <div class="swiper testimonial-slider-three">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                <div class="swiper-slide wow animate fadeInLeft" data-wow-delay="{{ $loop->iteration *200 }}ms" data-wow-duration="1500ms">
                    <div class="testimonial-slide-three">
                        <div class="testimonial-thumb">
                            <img src="{{ asset('assets/images/'.$testimonial->photo) }}" alt="">
                            <div class="video">
                                <div class="play">
                                    <a class="popup-video" href="{{ $testimonial->video_url }}"><i class="bi bi-play-fill"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-cnt">
                            <i class="fas fa-quote-left"></i>
                            <p>
                                @php
                                    echo $testimonial->details
                                @endphp
                            </p>
                            <h4>{{ $testimonial->title }}</h4>
                            <span>{{ $testimonial->subtitle }}</span>
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
<!-- End testimonial-three section -->