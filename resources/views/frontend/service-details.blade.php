@extends('layouts.front')

@push('meta')
<meta property="og:url"           content="{{ route('front.servicedetails', $service->slug) }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{ $service->title }}" />
<meta property="og:description"   content="{{ $service->description }}" />
@if($service->image)
<meta property="og:image"         content="{{ asset('assets/images/' . $service->image) }}" />
@endif
@endpush

@push('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/share-buttons.css') }}">
@endpush
@push('js')
<script src="{{ asset('js/share-buttons.jquery.js') }}"></script>
@endpush

@section('content')

<!-- Start breadcrumbs section -->
<section class="breadcrumbs" style="background-image: url({{ asset('assets/images/' . $gs->breadcumb_banner) }})">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <h2>@lang('Service Details')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Service Details')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

 <!-- Start services-details-area section -->
 <section id="down" class="services-details-area sec-m-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="service-details">
				<h2>{{ $service->title }}</h2>
                    <div class="service-details-thumbnail">
					@if ($service->video == '')
 <img src="{{ asset('assets/images/' . $service->image) }}" alt="">
 @else
 	<x-embed url="{{ $service->video }}" />
@endif
                    </div>
                    <div class="service-tabs wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <p>Share to your social media post.</p>
                    {!!ShareButtons::page(route('front.servicedetails', $service->slug), $service->title, [
                        'title' => $service->title,
                        'rel' => 'nofollow noopener noreferrer',
                    ])
                        ->facebook()
                        ->twitter()
                        ->pinterest()
                        ->whatsapp()
                        ->telegram()
                        ->linkedin(['rel' => 'follow'])
                        ->render()!!} 
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">@lang('Overview')</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">@lang('Package Includes')</button>
                            </li> -->

                             <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-addls" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">@lang('Additionals')</button>
                            </li>



                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">@lang('Reviews')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-faq-tab" data-bs-toggle="pill" data-bs-target="#pills-faq" type="button" role="tab" aria-controls="pills-faq" aria-selected="false">@lang('FAQ')</button>
                            </li>
                        </ul>
						<!-- tabs content -->
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="service-overview  wow animate fadeInRight" data-wow-delay="400ms" data-wow-duration="1500ms">
                                    <p>
                                        {{ strip_tags($service->description) }}
                                    </p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="package">
                                    <h4>@lang('Our Packages')</h4>
                                    <ul class="package-list">
                                        @foreach ($service->includes as $include)
                                        <li><i class="bi bi-check-all"></i>{{ $include->include_service_title }}</li>
                                        @endforeach
                                    </ul>
                                </div><br>
                               
                            </div>

                           <div class="tab-pane fade" id="pills-addls" role="tabpanel" aria-labelledby="pills-addls-tab">
                                <div class="package">


									@if (count($service->additionals) < 1) <h5>@lang('No additions provided')</h5> @endif
                                    <ul class="package-list">
                                        @foreach ($service->additionals as $additional)
										
							
                                        <li><i class="bi bi-check-all"></i>{{ $additional->additional_service_title }} - <small>{{ $defaultCurrency->sign }}</small>{{ $additional->additional_service_price }}</li>
                                        @endforeach
                                    </ul>
                                </div><br>
                               
                            </div>

                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="client-review">

                                    @if (count($service->reviews) > 0)
                                    @foreach ($service->reviews as $review)
                                    <div class="tab-review">
                                        <h5>{{ $review->buyer->name }}</h5>
                                        <div class="review-rating">
                                            <ul>
                                                @for($i = $review->rating; $i >= 1; $i--)
                                                <li><i class="bi bi-star-fill"></i></li>
                                                @endfor
                                                @php
        $rest = 5 - $review->rating;
                                                @endphp
                                                @if ($rest > 0)
                                                    @for($i = $rest; $i >= 1; $i--)
                                                    <li><i class="bi bi-star"></i></li>
                                                    @endfor
                                                    
                                                @endif
                                            </ul>
                                        </div>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                    @endforeach

                                    @else

                                    <p >
                                        @lang('No Review Found')
                                    </p>
                                    @endif


                                    <div id="review_form_wrapper">
                                        @if(Auth::check())
                                        <div class="review-area mb-4">
                                            <h4 class="title">@lang('Reviews')</h4>
                                            <div class="star-area">
                                              <ul class="star-list d-flex">
                                                <li class="stars" data-val="1">
                                                    <i class="bi bi-star"></i>
                                                </li>
                                                <li class="stars" data-val="2">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </li>
                                                <li class="stars" data-val="3">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </li>
                                                <li class="stars" data-val="4">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </li>
                                                <li class="stars" data-val="5">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </li>
                                              </ul>
                                            </div>
                                          </div>
                                          <div class="write-comment-area">
                                              <div class="gocover"
                                              style="background: url({{ asset('assets/images/' . $gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                                            </div>
                                            <form action="{{ route('front.servicereview') }}"  method="POST">
                                              @csrf
                                              <input type="hidden" id="rating" name="rating" value="5">
                                              <input type="hidden" name="buyer_id" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="seller_id" value="{{ $service->seller_id }}">
                                              <input type="hidden" name="service_id" value="{{ $service->id }}">
                                              <div class="row">
                                                <div class="col-lg-12">
                                                  <textarea class="form-control" name="review" placeholder="@lang('Write Your Review')" required></textarea>
                                                </div>
                                              </div>
                                              <div class="row mt-3">
                                                <div class="col-lg-12">
                                                  <button class="btn btn-spay w-100 py-3 btn-contact" type="submit">@lang('Submit')</button>
                                                </div>
                                              </div>
                                            </form>
                                          </div>
                                          @else
                                          <div class="row">
                                            <div class="col-lg-12">
                                              <br>
                                              <h5 class="text-center">
                                                <a href="{{ route('user.login') }}" class="btn login-btn mr-1">
                                                  @lang('Login')
                                                </a>
                                                  @lang('To Review')
                                              </h5>
                                              <br>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-faq" role="tabpanel" aria-labelledby="pills-faq-tab">
                                <div class="faqs-content">
                                    <div class="accordion" id="accordionExample">
                                        @foreach ($service->faqs as $item)
                                        <div class="accordion-item">
                                            <span class="accordion-header" id="headingone{{ $loop->iteration }}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseone{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseone">
                                                    {{ $item->faq_title }}?
                                                </button>
                                            </span>
                                            <div id="collapseone{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="headingone{{ $loop->iteration }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{ $item->faq_detail }}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-sidebar">
                    <div class="service-widget wow animate fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="service-pack">
                            <h4>@lang('Basic Package') <span><small>{{ $defaultCurrency->sign }}</small>{{rootAmount(servicePrice($service->id)) }}</span></h4>
                            <div class="package">
                                <h4>@lang('Includes')</h4>
                                <ul class="package-list">
								
@if ($service->is_service_online == 0)
                                    @foreach ($service->includes as $include)
                                    <li><i class="bi bi-plus-circle-dotted"></i>{{ $include->include_service_title }} - <small>{{ $defaultCurrency->sign }}</small>{{ $include->include_service_price }}</li>
							        @endforeach
@endif
									@foreach ($service->benefits as $benefit)
									<li><i class="bi bi-check-all"></i>{{ $benefit->benefits }}</li>
									@endforeach
									@if ($service->is_service_online == 1)
									<li><i class="bi bi-clock"></i>{{ $service->delivery_days }} Days Delivery</li>
									<li><i class="bi bi-arrow-repeat"></i></i>{{ $service->revision }} Revisions</li>
									@endif

                                </ul>
                            </div>
                            <div class="book-btn apply-btn">
                                @if (Auth::check())

                                @if (Auth::user()->id == $service->seller_id)
                                <a href="javascript:;" >@lang('Only for Buyer')</a>
                                @else
                                <a href="{{ route('checkout.index', $service->slug) }}" >@lang('Order Now')</a>
                                @endif
                                @else

                                <a href="{{ route('user.login') }}" >@lang('Login for service')</a>
                                @endif
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="service-widget wow animate fadeInRight" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="about-seller">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/avatars/' . $service->seller->photo) }}" alt="">
                            </div>
                            <h3><a href="{{  url('resume') }}/{{ $service->seller->username }}">{{ $service->seller->username }}</a></h3>
                            
                            <div class="seller-information">
                                <div class="single-info">
                                    <h5>@lang('Order Completed')<span>{{ $service->serviceorders->count() }}</span></h5>
                                </div>

                                @if ($service->reviews)
                                <div class="single-info">
                                    <h5>@lang('Service Rating')
                                        <strong>
                                            @php
    $avg = $service->reviews->avg('rating');
                                                @endphp
                                                @if ($avg == null)
                                                    @for($i = 0; $i < 5; $i++)
                                                    <i class="bi bi-star"></i>
                                                    @endfor
                                                    
                                                @else
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if (floor($avg - $i) >= 1)
                                                        {{--Full Start--}}
                                                        <i class="bi bi-star-fill"></i>
                                                    @elseif ($avg - $i > 0)
                                                        {{--Half Start--}}
                                                        <i class="bi bi-star-half"> </i>
                                                    @else
                                                        {{--Empty Start--}}
                                                        <i class="fa fa-star"> </i>
                                                    @endif
                                                @endfor
                                                @endif
                                            <b>({{ ratings($service->id) != null ? ratings($service->id) : 0 }}/5)</b>
                                        </strong>
                                    </h5>
                                </div>
                                @endif
                                <!-- <div class="single-info">
                                    <h5>@lang('Seller Email'):<span>{{ $service->seller->email }}</span></h5>
                                </div> -->
                                <div class="single-info">
                                    <h5>@lang('Seller Verification'):<span class="">{{ $service->seller->email_verified == 'Yes' ? 'Verified' : 'Not Verified' }}</span></h5>
                                </div>
<div class="cmn-btn mt-4"><a href="{{  url('chatify') }}/{{ $service->seller->id }}">@lang('Contact Me')</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End services-details-area section -->

<!-- Start other-services section -->

@if ($otherservices->count() > 0)
<section class="other-services-two sec-m-top">
    <div class="container">
        <div class="other-services">
            <h3>@lang('Similiar Services')</h3>
            <div class="row g-4">
                @foreach ($otherservices as $service)
        <div class="col-md-6 col-lg-4 wow animate fadeInLeft mb-5" data-wow-delay="{{ 200 * $loop->iteration }}ms" data-wow-duration="1500ms">
            <div class="single-service layout-2 layout-3">
                <div class="thumb">
                    <a href="{{ route('front.servicedetails', $service->slug) }}"><img src="{{ asset('assets/images/' . $service->image) }}" alt=""></a>
                    <div class="tag">
                        <a href="{{ route('front.servicedetails', $service->slug) }}">{{ $service->category->title }}</a>
                    </div>
                    <div class="wish">
                        @if ($service->is_service_online == 1)
                        <a href="javascript:;">@lang('Online')</a>
                        @else
                        <a href="javascript:;"> <i class="fas fa-map-marker"></i> {{ $service->country->name }}</a> 
                        @endif
                        
                    </div>

                </div>
                <div class="single-inner">
                    <div class="author-info">
                        <div class="author-thumb">
                            <img src="{{ asset('assets/images/' . $service->seller->photo) }}" alt="">
                        </div>
                        <div class="author-content">
                            <span>{{ $service->seller->name }}</span>
                            <div class="ratting">
                                <ul class="stars">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                                <strong>(5/5)</strong>
                            </div>
                        </div>
                    </div>
                    <h4><a href="{{ route('front.servicedetails', $service->slug) }}">{{ $service->title }}</a></h4>
                    <div class="started">
                        <a href="{{ route('front.servicedetails', $service->slug) }}">@lang('View Details')<span><i class="bi bi-arrow-right"></i></span></a>
                        <span><small>{{ $defaultCurrency->sign }}</small> {{rootAmount(servicePrice($service->id)) }} </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        </div>
        </div>
    </div>
</section>
<!-- End other-services section -->
@endif


<div class="modal fade job-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Apply This Job')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="geniusform" action="{{route('user.apply.job')}}" method="POST" >
                @include('includes.admin.form-both')
                {{ csrf_field() }}
                <input type="hidden" id="job_id" name="job_id">
                <div class="form-group my-3">
                    <label for="seller_offer">@lang('My Offer')</label>
                    <input type="number" required class="form-control" id="seller_offer" name="seller_offer">
                </div>
                <div class="form-group">
                    <label for="description">@lang('Short Description')</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="cmn-btn my-3">
                    <button class="w-100"  type="submit" id="submit-btn" >@lang('Apply')</button>
                </div>
                
            </form>
        </div>
      </div>
    </div>
  </div>


@endsection

@push('js')
<script type="text/javascript">
    "use strict";
$(document).ready(function(){
    $('#apply').on('click', function(){
        var id = $(this).data('val');
        $('#job_id').val(id);
    });
});

$(document).ready(function(){
    $('.stars').on('click', function(){
        var id = $(this).data('val');
        $('#rating').val(id);
        $('.stars').removeClass('active');
        $(this).addClass('active');

        $('.stars').children('i').each(function(){
            $(this).addClass('bi-star');
            $(this).removeClass('bi-star-fill');
            
        });
        $(this).children('i').each(function(){
            $(this).addClass('bi-star-fill');
            $(this).removeClass('bi-star');
        });
    });
});


</script>


@endpush