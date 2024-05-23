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
                    <h2>@lang('Service Order')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Service Order')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

<!-- Start checkout section -->
<section class="sec-p checkout">

    <div class="container">
       <div id="checkoutForm" class="form">
        <form  id="" class="checkoutform" action="" method="POST">
            @csrf
            <!-- start step indicators -->
            <div class="form-header d-flex mb-4">
                @if ($service->is_service_online == 0)
                <span class="stepIndicator">@lang('Location')</span>
                @endif
                <span class="stepIndicator">@lang('Service')</span>
                @if ($service->is_service_online == 0)
                <span class="stepIndicator">@lang('Date & Time')</span>
                @endif
                <span class="stepIndicator">@lang('Conformation')</span>
            </div>
            <!-- end step indicators -->
        
            <!-- step one -->
            @if ($service->is_service_online == 0)
            <div class="step">
                <p class="text-center mb-4">@lang('Where do you need the service?')</p>

                <div class="row">
                    <div class="col-md-4">
                        <select class="form-select form-select-lg" aria-label="Default select example" name="country_id" id="">
                            <option value="{{ $service->country->id }}">{{ $service->country->name }}</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select form-select-lg" aria-label="Default select example" name="city_id" id="city_id">
                            <option value="{{ $service->city->id }}">{{ $service->city->title }}</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select form-select-lg" aria-label="Default select example" name="area_id" id="area_id">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            @endif
            <!-- step two -->
            <div class="step">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-8">

                        {{-- Product Details strat from here --}}
                        <div class="product-details">
                            <div class="image">
                                <img class="img-fluid" src="{{ asset('assets/images/'.$service->image) }}" alt="">
                            </div>

                            <div class="content my-3">
                                <h3>{{ $service->title }}</h3>
                            </div>

                            <div class="include-benefit d-flex justify-content-between my-5">
                                <div class="include">
                                    <h5>@lang('What included:')</h5>
                                    <ul class="package-list">
                                        @foreach ($service->includes as $include)
                                        <li><i class="bi bi-check-all"></i>{{ $include->include_service_title }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="benefit">
                                    <h5>@lang('Benefits of the package:')</h5>

                                    <ul class="package-list">
                                        @foreach ($service->benefits as $benefit)
                                        <li><i class="bi bi-check-all"></i>{{ $benefit->benefits }}</li>
                                        @endforeach
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>

                        {{-- Product Details end here --}}

                        {{-- Additional Service Table Start from here --}}

                        <div class="additional-table">
                            <h5>@lang('Additional Services')</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Select')</th>
                                        <th scope="col">@lang('Service')</th>
                                        <th scope="col">@lang('Unit Price')</th>
                                        <th scope="col">@lang('Quantity')</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service->additionals as $additionalService)
                                    <tr>
                                        <td><input  value="{{ $additionalService->id }}" id="check{{ $loop->iteration }}"  type="checkbox"  class="checkbox" data-title="{{ $additionalService->additional_service_title }}" data-currency="{{ $defaultCurrency->sign }}" data-price="{{ rootAmount($additionalService->additional_service_price) }}"></td>
                                        <td>{{ $additionalService->additional_service_title }}</td>
                                        <td> {{ $defaultCurrency->sign }}  {{ rootAmount($additionalService->additional_service_price)  }}</td>
                                        <td>
                                            <input value="1" class="qty" id="qty{{ $loop->iteration }}" class="form-control" type="number" min="1" name="">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- Product Details end here --}}

                    {{-- Booking Summary Start from here--}}
                    <div class="col-md-4">
                        <div class="booking-box border border-2 rounded p-5">
                            <div class="title border-bottom mb-4">
                                <h4>@lang('Booking Summary')</h4>
                            </div>

                            <div class="pricing-section">
                                <div class="pricing-title">
                                    <h5>@lang('Package Fee')</h5>
                                </div>
                                 
                                <div class="border-bottom border-3 ">
                                    @foreach ($service->includes as $item)
                                        <div class="pricing-content d-flex justify-content-between ">
                                            <p>{{ $item->include_service_title }}</p>
                                            
                                            <p>{{ $defaultCurrency->sign }} {{ rootAmount($item->include_service_price) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="total-package-fee my-3">
                                    <div class="pricing-content d-flex justify-content-between text-dark">
                                        <h6>@lang('Total Package Fee'):</h6>
                                        <h6>{{ $defaultCurrency->sign }} <span id="packagefee">
                                            {{rootAmount(servicePrice($service->id)) }}
                                        </span> </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="pricing-title">
                                <h5>@lang('Extra Service'):</h5>
                            </div>

                            <div class="border-bottom border-3 ">
                                
                                    <div id="extra" >
                                                                               
                                    </div>
                            </div>
                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 ">
                                <p>@lang('Extra Service Total')</p>
                                <p >{{ $defaultCurrency->sign }} <span class="extra-fee">0</span> </p>
                                
                            </div>

                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 my-3">
                                <h6>@lang('Subtotal')</h6>
                                <h6 >{{ $defaultCurrency->sign }}<span class="subtotal">0</span> </h6>
                                
                            </div>

                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 ">
                                <p>@lang('Tax'):{{ $tax }} %</p>
                                <p >{{ $defaultCurrency->sign }} <span class="tax-fee">0</span> </p>
                                
                            </div>


                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 my-3">
                                <h6>@lang('Total')</h6>
                                <h6 >{{ $defaultCurrency->sign }}<span class="total">0</span> </h6>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- step three -->
            @if ($service->is_service_online == 0)
            <div class="step">
                <p class="text-center mb-4">@lang('Select Schedule')</p>
                <div class="row">
                    <div class="col-md-4">

                        <input name="date" id="date" type="date" class="form-control" >

                    </div>

                    <div class="col-md-8">
                        <div class="all-schedule d-flex ">

                        </div>
                    </div>
                </div>
            </div>
            @endif 
            {{-- Buyer Information --}}
            <div class="step">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>@lang('Billing Details')</h3>
                            </div>

                            <div class="col-md-6 my-3">
                                <div class="form-group">
                                    <label for="buyer">@lang('Buyer Name')</label>
                                    <input required id="buyer" class="form-control" name="name" type="text" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-md-6 my-3">
                                <div class="form-group">
                                    <label for="email">@lang('Buyer Email')</label>
                                    <input required id="email" class="form-control" name="email" type="email" value="{{ Auth::user()->email }}">
                                </div>
                            </div>

                            <div class="col-md-6 my-3">
                                <div class="form-group">
                                    <label for="phone">@lang('Buyer Phone')</label>
                                    <input required id="phone" class="form-control" name="phone" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-6 my-3">
                                <div class="form-group">
                                    <label for="zip">@lang('Post Code')</label>
                                    <input required id="zip" class="form-control" name="post_code" type="text" value=" ">
                                </div>
                            </div>
                            <div class="col-md-12 my-3">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <input required id="address" class="form-control" name="address" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-12 my-3">
                                <div class="form-group">
                                    <label for="details">@lang('Order Details')</label>
                                    <textarea class="form-control" name="details" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- price Details --}}
                        <div class="booking-box border border-2 rounded p-5">
                            <div class="title border-bottom mb-4">
                                <h4>@lang('Order Amount')</h4>
                            </div>

                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 ">
                                <p>@lang('Total Package Fee')</p>
                                <p >{{ $defaultCurrency->sign }} <span class="final-package-fee">{{ rootAmount(servicePrice($service->id)) }}</span> </p>
                            </div>

                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 ">
                                <p>@lang('Total Extra Service Fee')</p>
                                <p >{{ $defaultCurrency->sign }} <span class="final-extra-fee">0</span> </p>
                            </div>

                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 ">
                                <p>@lang('Total Tax')</p>
                                <p >{{ $defaultCurrency->sign }} <span class="final-tax-fee">0</span> </p>
                            </div>

                            <div class="pricing-content d-flex justify-content-between  border-bottom border-3 my-3">
                                <h6>@lang('Total Amount')</h6>
                                <h6 >{{ $defaultCurrency->sign }}<span class="final-total-fee"></span> </h6>
                            </div>
                        </div>
                         {{-- Price Details End  --}}

                            {{-- Payment Method --}}
                            <div class="booking-box border border-2 rounded p-5 mt-3">
                                <div class="title border-bottom mb-4">
                                    <h4>@lang('Payment Method')</h4>
                                </div>
                                @foreach ($gateways as $gt)
                                <div class="form-check mb-2">
                                    <input  form="checkout-form" class="form-check-input method" type="radio" name="payment_method" id="gateway{{$gt->id}}" value="{{ $gt->keyword }}" data-val="{{ $gt->keyword }}" data-show="{{$gt->showForm()}}" data-form="{{ $gt->showCheckoutLink() }}"
                                    data-href="{{ route('service.load.payment',['slug1' => $gt->showKeyword(),'slug2' => $gt->id]) }}" {{$loop->first ? 'checked' : ''}}>
                                    <label class="form-check-label linked-radio" for="gateway{{$gt->id}}">
                                        {{ $gt->name }}
                                    </label>
                                  </div>
                                  @if($gt->information != null)
										<p class="pm-text ed_credits" style="display: block;">{{ $gt->getAutoDataText() }}</p>
									@endif
                                @endforeach
                                <div class="pay-area" style="display: none;">
                                </div>
                            </div>
                            {{-- Payment Method End --}}
                    </div>
                </div>
            </div>

            
        
            <!-- start previous / next buttons -->
            <div class="form-footer d-flex w-25">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">@lang('Previous')</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">@lang('Next')</button>
            </div>
            <!-- end previous / next buttons -->

            <div class="allinput">
                <input type="hidden" name="include[]" id="includeservice" value="">
                <input type="hidden" name="quantity[]" id="quantity" value="" >
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="additional_service_cost" value="" id="additional-cost">
                <input type="hidden" name="package_fee" value="{{ rootAmount($service->price) }}">
                <input type="hidden" name="tax" value="" id="service-tax">
                <input type="hidden" name="total" value="" id="service-total">
                <input type="hidden" name="schedule" value="" id="schedule">
                <input type="hidden" name="currency_sign" value="{{ $defaultCurrency->sign }}">
                <input type="hidden" name="currency_value" value="{{ $defaultCurrency->value }}">
                <input type="hidden" name="currency_code" id="currencyCode" value="{{ $defaultCurrency->name }}">
                <input type="hidden" name="paystackInfo" id="paystackInfo" value="{{ $paystackKey }}">
                <input type="hidden" name="currency_id" value="{{ $defaultCurrency->id }}">
                <input type="hidden" name="ref_id" id="ref_id" value="">
                
               
            </div>
        </form>
    </div>
    </div>
</section>

@endsection

@push('js')
<script type="text/javascript">
    "use strict";
    var tax = {{ $tax }};
    $(document).ready(function() {
        
        var city_id = $('#city_id').val();
        var url = '{{ route("city.getAreaList", ":id") }}';
        url = url.replace(':id', city_id);
       
        if(city_id) {
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="area_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="area_id"]').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                    });
                }
            });
        }else{
            $('select[name="area_id"]').empty();
        }
    
    });
</script>

<script src="{{ asset('assets/front/js/checkout.js') }}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>


<script type="text/javascript">
    "use strict";

var mindate = new Date().toISOString().slice(0,10);
$('#date').attr('min', mindate);

// Date Picker 
$('#date').change(function(){
    var date = new Date($(this).val());
    var mydate = $(this).val();
   
    
    var day = date.getDay();
    var daylist = ["Sunday","Monday","Tuesday","Wednesday ","Thursday","Friday","Saturday"];
    var dayname = daylist[day];
    var url =  '{{ route("service.getSchedule", [":id", ":id2"]) }}';
    url = url.replace(':id', dayname);
    url = url.replace(':id2', mydate);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success:function(data) {
            $('.all-schedule').empty();
            $.each(data, function(key, value) {
                $('.all-schedule').append('<div class="card mx-2"><div class="card-body"><div class="d-flex justify-content-between"> <a href="javascript:;" class="rangeschedule mx-auto">'+ value +'</a></div></div></div></div>');
            });
        }
    });
});

    $(document).on('click','#nextBtn',function(){
        $('.checkbox').each(function(){
            if($(this).is(':checked')){

            var quantity = [];
           // Quantity input get
            $('.myqty').each(function(){
            quantity.push($(this).text());
            });
            $('#quantity').val(quantity);

            // Include service get id
            var includeservice = [];
            $('.checkbox:checked').each(function(){
            includeservice.push($(this).val());
            });
            $('#includeservice').val(includeservice);
            
            }
        });

        $('#date').on('change', function(){
            $('#nextBtn').attr('disabled', 'disabled');
        })

        // Schedule get

        // Include service get total price
            var additionalfee = $('.extra-fee').text();
            $('#additional-cost').val(additionalfee);
            $('.final-extra-fee').text(additionalfee);

            // Tax Fee
            var taxfee = $('.tax-fee').text();
            $('#service-tax').val(taxfee);
            $('.final-tax-fee').text(taxfee);

            // Total Fee
            var totalfee = $('.total').text();
            $('#service-total').val(totalfee);
            $('.final-total-fee').text(totalfee);
        
    })


    "use strict";
	$(document).ready(function() {
		$(".checkoutform").attr('action', $("input.method:checked").data('form'));


		$('.method').on('change',function(){
			$('.checkoutform').prop('action',$(this).data('form'));
			var show = $(this).data('show');
            if($(this).val() == 'paystack'){
                $('.checkoutform').prop('id','paystack');

            }
            else{
                $('.checkoutform').prop('id','');
            }
			if(show != 'no') {
				$('.pay-area').show();
				$('.pay-area').load($(this).data('href'));
			}
			else {
				$('.pay-area').hide();
			}
		});

	});

</script>


<script type="text/javascript">
    "use strict";

    $(document).on('submit','#paystack',function(e){
      e.preventDefault();

        var total = parseFloat( $('#service-total').val());
        var paystackInfo = $("#paystackInfo").val();
        var curr = $('#currencyCode').val();
        
        total = Math.round(total);
          
            var handler = PaystackPop.setup({
              key: paystackInfo,
              email: '{{ Auth::user()->email }}',
              amount: total * 100,
              currency: curr,
              ref: ''+Math.floor((Math.random() * 1000000000) + 1),
              callback: function(response){
                $('#ref_id').val(response.reference);
                $('#paystack').prop('id','');
                $('.checkoutform').submit();
              },
              onClose: function(){
                window.location.reload();
              }
            });
            handler.openIframe();
                return false;                    
            
          
    });



  </script>


@endpush
