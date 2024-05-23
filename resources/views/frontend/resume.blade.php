
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
                    <h2>@lang('User Profile')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('User Profile')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

 <!-- Start user-profile section -->
 <section id="down" class="public-user-profile sec-m-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="outer-user-page">

<div id="outer-user-card">
             <div id="outer-user-photo">
			  <div class="thumb">

                      @if($user->is_provider == 1)
                       <img src="{{ $user->photo ? asset($user->photo):asset('assets/images/avatars/avatar.png')}}" alt="">
                        @else
                          <img src="{{ $user->photo ? asset('assets/images/avatars/'.$user->photo):asset('assets/images/avatars/avatar.png')}}" alt="">
                        @endif
               </div>
			  </div>
<div id="outer-user-card-content">
                            <h3>{{ $user->name }}</h3>
							<small><span>@</span>{{ $user->username }}</small>

  <div class="user-country"><i class="bi bi-globe2"></i> {{ $user->ucountry }}</div>
   </div>
 </div>

<div class="user-about-me">
<h6>@lang('About me')</h6>
<hr style="width:15%;text-align:left;margin:0">

<div class="user-work-experience"> <p>{{ $user->aboutme }}</p> </div>

</div>
<div class="user-skills">
<h6>@lang('My Skills')</h6>
<hr style="width:15%;text-align:left;margin:0">
    <div class="d-flex" id="with_show_more">
        @foreach($user->tags as $key=>$tag)
            <div class="mr-1 p-1">
                &#x2022; <a href="{{ route('front.allservices', ['tag' => $tag->slug]) }}" style="color:#787878;">{{$tag->slug}}</a>
            </div>
            @if($key==4)
                @break
            @endif
        @endforeach
        @if(sizeof($user->tags) > 5)
            <div class="mr-1 p-1">
                &#x2022; <span style="cursor: pointer" id="show_more"><u>Show more ({{sizeof($user->tags) - 5}})</u></span>
            </div>
        @endif
    </div>
    <div class="d-flex d-none" id="without_show_more">
        @foreach($user->tags as $key=>$tag)
            <div class="mr-1 p-1">
                &#x2022; <a href="{{ route('front.allservices', ['tag' => $tag->slug]) }}" style="color:#787878;">{{$tag->slug}}</a>
            </div>
        @endforeach
    </div>

</div>
</div>
 </div>
            <div class="col-lg-4">
                <div class="outer-user-page-sidebar">
                    <div class="service-widget wow animate fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="user-more-info">
                            <h4>@lang('More about the Member') </h4>
<div class="user-more-info-content">
							<div class="user-country"><i class="bi bi-calendar2-date"></i> Joined in {{ \Carbon\Carbon::parse($user->created_at)->format('d F, Y') }}</div>
@if ($user->email_verified == 'Yes')
<div class="user-identity"><i class="bi bi-mailbox"></i> @lang('Email:')<span class=""> <strong>@lang('Verified')</strong></span>
@else <i class="bi bi-mailbox"></i> @lang('Email:') <strong>@lang('Not Verified')</strong> @endif</div>
<div class="user-completed-orders"><i class="bi bi-check-square"></i> <strong>{{ $user->serviceorders->count() }}</strong> @lang('Orders Completed')</div>
<p>&nbsp;</p>
<div class="book-btn apply-btn"><a href="{{  url('chatify') }}/{{ $user->id }}">@lang('Contact to Seller')</a></div>

                        </div>
                    </div>

                        </div>
                    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End services-details-area section -->

<!-- Start My-services section -->
<section class="other-services-two sec-m-top">
    <div class="container">
        <div class="other-services">
            <h3>@lang('My Services')</h3>
            <div class="row g-4">
			@if ($user->services->count() > 0)
                @foreach ($user->services as $service)
        <div class="col-md-6 col-lg-4 wow animate fadeInLeft mb-5" data-wow-delay="{{ 200 * $loop->iteration }}ms" data-wow-duration="1500ms">
            <div class="single-service layout-2 layout-3">
                <div class="thumb">
                    <a href="{{ route('front.servicedetails',$service->slug) }}"><img src="{{ asset('assets/images/'.$service->image) }}" alt=""></a>
                    <div class="tag">
                        <a href="{{ route('front.servicedetails',$service->slug) }}">{{ $service->category->title }}</a>
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
                            <img src="{{ asset('assets/images/'. $service->seller->photo) }}" alt="">
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
                    <h4><a href="{{ route('front.servicedetails',$service->slug) }}">{{ $service->title }}</a></h4>
                    <div class="started">
                        <a href="{{ route('front.servicedetails',$service->slug) }}">@lang('View Details')<span><i class="bi bi-arrow-right"></i></span></a>
                        <span><small>{{ $defaultCurrency->sign }}</small> {{rootAmount(servicePrice($service->id)) }} </span>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
        </div>
        </div>
    </div>
	@else
		<div>No service found</div>
 @endif
</section>
<!-- End other-services section -->



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

$("#show_more").click(function (){
    console.log("asdf");
    $("#with_show_more").addClass('d-none');
    $("#without_show_more").removeClass('d-none');
});


</script>


@endpush
