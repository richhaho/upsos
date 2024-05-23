@php

$pay_data = $gateway->convertAutoData();
// dd($pay_data);
@endphp

@if($payment == 'paypal')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'flutterwave')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'paystack')


<input type="hidden" name="sub" id="sub" value="0">
<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'paytm')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'stripe')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

  <div class="row">

    <div class="col-lg-12">
      <input class="form-control card-elements mb-2" name="cardNumber" type="text" placeholder="{{ __('Card Number') }}" autocomplete="off"  autofocus oninput="validateCard(this.value);" />
      @if ($errors->has('cardNumber'))
        <p>{{$errors->first('cardNumber')}}</p>
      @endif
    </div>

    <div class="col-lg-12">
      <input class="form-control card-elements mb-2" name="cardCVC" type="text" placeholder="{{ __('Cvv') }}" autocomplete="off"  oninput="validateCVC(this.value);" />
      @if ($errors->has('cardCVC'))
        <p>{{$errors->first('cardCVC')}}</p>
      @endif
    </div>

    <div class="col-lg-6">
       <input class="form-control card-elements" name="month" type="text" placeholder="{{ __('Month') }}"  />
       @if ($errors->has('month'))
         <p>{{$errors->first('month')}}</p>
       @endif
    </div>

    <div class="col-lg-6">
      <input class="form-control card-elements" name="year" type="text" placeholder="{{ __('Year')}}"  />
      @if ($errors->has('year'))
        <p>{{$errors->first('year')}}</p>
      @endif
    </div>

  </div>

@endif

@if ($payment == 'authorize.net')
<div class="row gy-3 mt-2">
  <div class="col-md-6">
     <input type="text" class="form-control card-elements" name="cardautho" placeholder="{{ __('Card Number') }}" autocomplete="off"  autofocus oninput="validateCard(this.value);"/>
     <span id="errCard"></span>
  </div>
  <div class="col-lg-6 cardRow">
     <input type="text" class="form-control card-elements" placeholder="{{ ('Card CVC') }}" name="cardCVC" oninput="validateCVC(this.value);">
     <span id="errCVC"></span>
  </div>
  <div class="col-lg-6">
     <input type="text" class="form-control card-elements" placeholder="{{ __('Month') }}" name="month" >
  </div>
  <div class="col-lg-6">
     <input type="text" class="form-control card-elements" placeholder="{{ __('Year') }}" name="year">
  </div>
</div>
    
@endif

@if ($payment == 'manual')
    <div class="col-sm-12 mt-4 manual-payment">
      <div class="card default--card">
        <div class="card-body">
          <div class="row">
              <div class="col-sm-12 pb-2 manual-payment-details">
              </div>
              <div class="col-sm-12">
                <label class="form-label required">@lang('Transaction ID')#</label>
                <input class="form-control" required name="txn_id4" type="text" placeholder="Transaction ID" id="manual_transaction_id">
              </div>
          </div>
        </div>
    </div>
    </div>
                              
    
@endif



