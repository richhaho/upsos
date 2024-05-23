@extends('layouts.user')

@push('css')
    
@endpush

@section('contents')
<div class="breadcrumb-area">
  <h3 class="title">@lang('Invest')</h3>
  <ul class="breadcrumb">
      <li>
        <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
      </li>

      <li>
          @lang('Invest')
      </li>
  </ul>
</div>

<div class="dashboard--content-item">
  <div class="row g-3">
    <div class="col-12">
      <div class="card p-5 default--card">
          @includeIf('includes.flash')
          <form  method="POST"  action="{{ route('checkout.free.submit') }}">
              @csrf

              <div class="row gy-3 gy-md-4">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="form-label required">{{__('User Email')}}</label>
                    <input name="email" id="accountemail" class="form-control @error('email') is-invalid @enderror" autocomplete="off" placeholder="{{__('doe@gmail.com')}}" type="email" value="{{ auth()->user()->email }}" readonly>
                    @error('email')
                      <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror

                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="form-label required">{{__('User Name')}}</label>
                    <input name="name" id="account_name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" placeholder="{{__('Jhon Doe')}}" type="text" value="{{ auth()->user()->name }}" readonly>
                    @error('name')
                      <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                </div>


                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="currency_sign" value="{{ $defaultCurrency->sign }}">
                <input type="hidden" id="currencyCode" name="currency_code" value="{{ $defaultCurrency->name }}">
                <input type="hidden" name="currency_id" value="{{ $defaultCurrency->id }}">
                <input type="hidden" name="paystackInfo" id="paystackInfo" value="{{ $paystackKey }}">
                <input type="hidden" name="plan_type"  value="{{ $plan->plan_type }}">
                <input type="hidden" name="connect"  value="{{ $plan->connect }}">
                <input type="hidden" name="ref_id" id="ref_id" value="">
                <div class="col-sm-12">
                  <label class="form-label d-none d-sm-block">&nbsp;</label>
                  <button type="submit" class="cmn--btn bg--primary submit-btn w-100 border-0">{{__('Submit')}}</button>
                </div>
              </div>
          </form>
      </div>
  </div>
  </div>
</div>

@endsection

@push('js')


@endpush



