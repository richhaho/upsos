@extends('layouts.user')

@push('css')

@endpush

@section('contents')
<div class="breadcrumb-area">
    <h3 class="title">@lang('Subscription plans')</h3>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
        </li>
        <li>
            @lang('Subscription plans')
        </li>
    </ul>
</div>
<div class="dashboard--content-item">
    <div class="pricing--wrapper row g-3 g-md-4 g-lg-3 g-xxl-4">
        @if (count($plans) == 0)
            <div class="col-12 text-center">
                    <h3 class="m-0">{{__('No Plan Found')}}</h3>
            </div>
        @else
        <div class="row">
            @foreach ($plans as $data)
            <div class="col-lg-4 col-sm-6 col-md-6">
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
                                @endif</h5>
                            <span>@lang('Return')</span>
                        </div>
                    </div>
                    <div class="plan__item-body">
                        <ul>
                            <li>
                                <span class="name"> <strong>{{ $data->connect }}</strong>  @lang('Connect to get order from buyer, each order will deduct 2 connect from seller account.')</span>
                                
                            </li>
                            <li>
                                <span class="name">@lang('Seller can create services Maximum')<strong> {{ $data->service }}</strong></span>
                            </li>
                            <li>
                                <span class="name">@lang('Seller can apply jobs Maximum')<strong> {{ $data->job }}</strong></span>
                            </li>
                        </ul>
                        <h6 class="text-center amount-range">{{ showPrice($data->price) }}</h6>
                        <div class="cmn-btn plan-btn">
                            @if (Auth::user() && Auth::user()->is_seller == 1 )

                            @if (Auth::user()->planid == $data->id && Auth::user()->plan_expiredate > Carbon\Carbon::now())
                            <div class="d-flex justify-content-between">
                                <a class="cmn--btn  invest-plan" href="javascript:void(0)" disabled>@lang('Current Plan')</a>
                            <a class="cmn--btn  invest-plan" href="{{ route('user.subscription',$data->subtitle) }}" >@lang('Renew Plan')</a>

                            </div>
                            <br>
                            <p>@lang('Expired On'): {{ Carbon\Carbon::parse(auth()->user()->plan_expiredate )->format('d/m/Y')}}</p>
                            
                            @else
                            <a class="cmn--btn w-100 invest-plan" href="{{ route('user.subscription',$data->subtitle) }}" >@lang('Activate Now')</a>
                            @endif
                            
                            @else
                            <a class="cmn--btn w-100 invest-plan" href="{{ route('user.login') }}">@lang('Register as Seller')</a>
                            @endif
                           </div>
                           <br>
                           
                    </div>
                </div>
            </div>



            @endforeach
           </div>
        @endif
    </div>
</div>


@endsection

@push('js')
<script>
    var theValue = document.getElementById('you').getElementsByClassName('username')[0].innerHTML;
</script>
@endpush
