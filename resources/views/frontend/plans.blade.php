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
                    <h2>@lang('Subscription Plan')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Subscription Plan')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->


<!-- Start pricing section -->

<section id="category" class="categorys sec-p">
    <div class="container">
        <div class="row">
            @foreach ($plans as $data)
            <div class="col-lg-4 col-sm-12 col-md-6 mb-4">
                <div class="plan__item">
                    <div class="plan__item-header">
                       <div class="left">
                          <h5 class="title">{{ $data->title }}</h5>
                          <div class="{{ $data->title }}"><span></span></div>
                       </div>
                       <div class="right">
                          <h5 class="title">
                            @if ($data->plan_type == 'yearly')
                            @lang('Yearly')
                            @elseif($data->plan_type == 'monthly')
                            @lang('Monthly')
                            @else
                            @lang('Lifetime') 
                            @endif
                          </h5>
                          <span>@lang('Return')</span>
                       </div>
                    </div>
                    <div class="plan__item-body">

                        <ul>
                            <li>
                              <strong>{{ $data->connect }}</strong>  @lang('Connect to get order from buyer, each order will deduct 2 connect from seller account.')
                            </li>
                            <li>@lang('Seller can create services Maximum')<strong> {{ $data->service }}</strong></li>
                            <li>@lang('Seller can apply jobs maximum')<strong> {{ $data->job }}</strong> </li>
                        </ul>

                       <h6 class="text-center amount-range">{{ showPrice($data->price) }}</h6>
                       <div class="cmn-btn plan-btn">
                        @if (Auth::user() && Auth::user()->is_seller == 1 )


                        @if (Auth::user()->planid == $data->id && Auth::user()->plan_expiredate > Carbon\Carbon::now())
                          <a href="{{ route('front.plan',$data->subtitle) }}" >@lang('Renew Plan')</a>
                          <div class="d-flex justify-content-between">
                            <p>@lang('Current Plan')</p>
                            <p>@lang('Expired At'): {{ Carbon\Carbon::parse(auth()->user()->plan_expiredate )->format('d/m/Y')}}</p>

                          </div>

                        @else
                        <a href="{{ route('front.plan',$data->subtitle) }}" >@lang('Activate Now')</a>
                        @endif
                        
                        @else
                        <a href="{{ route('user.login') }}">@lang('Register as Seller')</a>
                        @endif

                        
                       </div>
                    </div>
                 </div>
            </div>
            @endforeach
            
        </div>
        
    </div>
</section>

<!-- End pricing section -->

<!--Pricing Modal -->
<div class="modal fade pricingplan" id="pricing" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pricingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="pricingLabel">@lang('Subscription Payment')</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="payment-info text-center">
                <p>***@lang('Make sure your Wallet balance is greater than Plan price. If not, Deposit Amount to your wallet.')***</p>
            </div>
            <div class="p-md-4">
                <h5 class="mb-2">@lang('Payment Method')</h5>
                <ul class="nav nav-pills plan-nav mb-3" id="pills-tab" role="tablist">

                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"  role="tab" aria-controls="pills-home" aria-selected="true">@lang('Payment Gateway')</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"  role="tab" aria-controls="pills-profile" aria-selected="false">@lang('Wallet')</a>
                    </li>
                  </ul>

                  <div class="tab-content" id="pills-tabContent">
                    {{-- tab panel one start --}}
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="payment">
                            <span class="notic"><b>@lang('Note'):</b>
                                {{ __('Your Previous Plan will be deactivated!') }}</span>
                        </div>
                      @includeIf('includes.flash')   
                    
                        @csrf

                    </div>

                    {{-- Tab panel one end --}}

                    {{-- tab panel two start --}}

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    </div>

                    {{-- Tab panel two end --}}
                  </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
          <button type="button" class="btn btn-primary">@lang('Save')</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')

@endpush
