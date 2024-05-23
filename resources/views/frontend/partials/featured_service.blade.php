   <!-- Start regular-services section -->
   <section class="regular-services sec-m-top">
    <div class="container">
        <div class="row">
            <div class="col-12 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="sec-title layout-3 left">
                    <h2>{{ $ps->featured_title }}</h2>
                    <p>
                        @php
                            echo $ps->featured_text
                        @endphp
                    </p>
                    <div class="slider-navigations">
                        <div class="swiper-button-prev-c"><i class="bi bi-arrow-left"></i></div>
                        <div class="swiper-button-next-c"><i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper regular-service-slider">
            <div class="swiper-wrapper">
                @foreach ($featured_services as $service)

                <div class="swiper-slide wow animate fadeInLeft" data-wow-delay="{{ $loop->iteration * 200}}ms" data-wow-duration="1500ms">
                    <div class="single-service layout-2 layout-3">
                        <div class="thumb">
                            <a href="{{ route('front.servicedetails',$service->slug) }}"><img src="{{ asset('assets/images/'.$service->image) }}" alt=""></a>
                            <div class="tag">
                                <a href="{{ route('front.servicedetails',$service->slug) }}">{{ $service->category->title }}</a>
                            </div>
    
                        </div>
                        <div class="single-inner">
                            <div class="author-info">
                                <div class="author-thumb">
                                    <img src="{{ asset('assets/images/avatars/'. $service->seller->photo) }}" alt="">
                                </div>
                                <div class="author-content">
                                    <span><a href="{{  url('resume') }}/{{ $service->seller->username }}">{{ $service->seller->name }}</a></span>
                                    <div class="ratting">
                                        <ul class="stars">
                                            <strong>
                                                @php
                                                    $avg=$service->reviews->avg('rating');
                                                    @endphp
                                                    @if ($avg == null)
                                                        @for($i = 0; $i < 5; $i++)
                                                        <i class="fas fa-star"></i>
                                                        @endfor
                                                        
                                                    @else
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if (floor($avg - $i) >= 1)
                                                            {{--Full Start--}}
                                                            <i class="fa fa-star filled"></i>
                                                        @elseif ($avg - $i > 0)
                                                            {{--Half Start--}}
                                                            <i class="fa fa-star-half-alt filled"> </i>
                                                        @else
                                                            {{--Empty Start--}}
                                                            <i class="fa fa-star"> </i>
                                                        @endif
                                                    @endfor
                                                    @endif
                                                <b>({{ ratings($service->id) != null ? ratings($service->id) : 0 }}/5)</b>
                                            </strong>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            <h4><a href="{{ route('front.servicedetails',$service->slug) }}">{{ $service->title }}</a></h4>
                            <div class="started">
                                <a href="{{ route('front.servicedetails',$service->slug) }}">@lang('View Details')<span><i class="bi bi-arrow-right"></i></span></a>
                                <span><small>{{  $defaultCurrency->sign }}</small> {{rootAmount(servicePrice($service->id)) }} </span>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
                
            </div>
        </div>
    </div>
</section>
<!-- End regular-services section -->
