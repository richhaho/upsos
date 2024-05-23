@extends('layouts.front')

@push('css')

@endpush

@section('content')

<!-- Start breadcrumbs section -->
<section class="breadcrumbs" style="background-image: url({{ asset('assets/images/'.$gs->breadcumb_banner) }})">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <h2>@lang('About Us')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('About Us')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

<!-- Start about-us-area section -->
<section id="down" class="about-us-area sec-m-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 wow animate fadeInLeft" data-wow-delay="1800ms" data-wow-duration="1500ms">
                <div class="about-left">
                    <div class="about-title">
                        <span>@lang('About us')</span>
                        <h2>{{ $ps->about_title }}</h2>
                    </div>
                    <p>
                        @php
                            echo $ps->about_details;
                        @endphp
                        
                    </p>
                    
                    <div class="cmn-btn mt-4">
                        <a href="{{ $ps->about_link }}">@lang('More About')</a>
                    </div>
                    <div class="feature-counts mb-4">
                        @foreach ($counters as $data)
                        <div class="single-count">
                            <span class="counter">{{ $data->count }}</span><span>+</span>
                            <h5>{{ $data->title }}</h5>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow animate fadeInRight" data-wow-delay="1800ms" data-wow-duration="1500ms">
                <div class="about-right">
                    <div class="shape">
                        <img src="{{ asset('assets/front/about-shape.png') }}" alt="">
                    </div>
                    <div class="frame-1">
                        <div class="about-video">
                            <a class="popup-video" href="{{ $ps->about_video_link }}"><i class="bi bi-play-fill"></i></a>
                        </div>
                        <div class="img-1">
                            <img src="{{ asset('assets/images/'.$ps->about_photo1) }}" alt="">
                        </div>
                    </div>
                    <div class="frame-2">
                        <div class="img-1">
                            <img src="{{ asset('assets/images/'.$ps->about_photo2) }}" alt="">
                        </div>
                        <div class="img-2">
                            <img src="{{ asset('assets/images/'.$ps->about_photo3) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about-us-area section -->


<!-- Start team-area section -->

@include('frontend.partials.testimonial')

<!-- End team-area section -->
 <!-- Start how-it-works-two section -->
 @include('frontend.partials.how_it_works')
 <!-- End how-it-works-two section -->

<!-- Start why-choose-two section -->
@include('frontend.partials.why_choose_us')
<!-- End why-choose-two section -->

<!-- Start Blog-area section -->
@include('frontend.partials.blog')
<!-- End Blog-area section -->


   



@endsection

@push('js')

@endpush
