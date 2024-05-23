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
                    <h2>@lang('Job Details')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Job Details')</span>
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
                    <div class="service-details-thumbnail">
                        <img src="{{ asset('assets/images/'.$job->image) }}" alt="">
                    </div>
                    <h2>{{ $job->job_title }}</h2>
                    <h4>@lang('Job Description')</h4>
                    <p>
                        @php
                            echo $job->description;
                        @endphp
                        
                    </p>
                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-sidebar">
                    <div class="service-widget wow animate fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="service-pack">
                            <h4>@lang('Offer Price') <span><small>{{ $defaultCurrency->sign }}</small>{{rootAmount($job->budget) }}</span></h4>
                            <div class="package">
                                <h4>@lang('Overview')</h4>
                                <ul class="package-list">
                                    <li><i class="bi bi-check-all"></i>@lang('Job Type: ') 
                                        <b>{{ $job->is_job_online==1 ? 'Online' : 'Offline' }}</b>
                                    </li>
                                    <li><i class="bi bi-check-all"></i>@lang('Location:')
                                   <b> {{ $job->is_job_online==1 ? 'Remote' : $job->country->name }}</b>
                                    </li>
                                    <li><i class="bi bi-check-all"></i>@lang('Deadline:')
                                      <b>  {{ Carbon\Carbon::parse($job->deadline)->format('d M, Y') }} </b>
                                    
                                    </li>
                                    <li><i class="bi bi-check-all"></i>@lang('Category:')
                                       <b> {{ $job->category->title ?? 'None' }} </b></li>
                                </ul>
                            </div>
                            <div class="book-btn apply-btn">
                                @if(auth()->check())
											@if (DB::table('jobrequests')->where('job_id', $job->id)->where('seller_id', auth()->user()->id)->exists())
												<a type="button">@lang('Already Applied')</a>
											@else
											@if (auth()->user()->is_seller == 1)
											<a id="apply" data-val="{{ $job->id }}" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
											@lang('Apply Now')
                                            </a>
											@else
											<a type="button">@lang('Only For Seller')</a>
											@endif
                                            @endif
											@else
											<a href="{{route('user.login')}}">@lang('Login to apply')</a>
											@endif
                            </div>
                        </div>
                    </div>
                    <div class="service-widget wow animate fadeInRight" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="about-seller">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/'. $job->buyer->photo) }}" alt="">
                            </div>
                            <h3>{{ $job->buyer->username }}</h3>

                            <div class="seller-information">
                                <div class="single-info">
                                    <h5>@lang('Buyer Name:')<span>{{ $job->buyer->name }}</span></h5>
                                </div>
                                <div class="single-info">
                                    <h5>@lang('Buyer Email:')<span>{{ $job->buyer->email }}</span></h5>
                                </div>
                                <div class="single-info">
                                    <h5>@lang('Buyer Verification:')<span class="">{{ $job->buyer->email_verified == 'Yes' ? 'Verified' : 'Not Verified' }}</span></h5>
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

<!-- Start other-services section -->

@if ($otherjobs->count() > 0)
<section class="other-services-two sec-m-top">
    <div class="container">
        <div class="other-services">
            <h3>@lang('Similiar Jobs')</h3>
            <div class="row g-4">
                @foreach ($otherjobs as $job)
        <div class="col-md-6 col-lg-4 wow animate fadeInLeft mb-5" data-wow-delay="{{ 200 * $loop->iteration }}ms" data-wow-duration="1500ms">
            <div class="single-service layout-2 layout-3">
                <div class="thumb">
                    <a href="{{ route('front.jobdetails',$job->job_slug) }}"><img src="{{ asset('assets/images/'.$job->image) }}" alt=""></a>
                    <div class="tag">
                        <a href="{{ route('front.jobdetails',$job->job_slug) }}">{{ $job->category->title ?? 'None' }}</a>
                    </div>
                    <div class="wish">
                        @if ($job->is_job_online == 1)
                        <a href="javascript:;">@lang('Online')</a>
                        @else
                        <a href="javascript:;"> <i class="fas fa-map-marker"></i> {{ $job->country->name }}</a> 
                        @endif
                        
                    </div>

                </div>
                <div class="single-inner">
                    <div class="author-info">
                        <div class="author-thumb">
                            <img src="{{ asset('assets/images/'. $job->buyer->photo) }}" alt="">
                        </div>
                        <div class="author-content">
                            <span>{{ $job->buyer->name }}</span>
                            
                        </div>
                    </div>
                    <h4><a href="{{ route('front.jobdetails',$job->job_slug) }}">{{ $job->job_title }}</a></h4>
                    <div class="started">
                        <a href="{{ route('front.jobdetails',$job->job_slug) }}">@lang('View Details')<span><i class="bi bi-arrow-right"></i></span></a>
                        <span><small>{{ $defaultCurrency->sign }}</small> {{rootAmount($job->budget) }} </span>
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
</script>


@endpush