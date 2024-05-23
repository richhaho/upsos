@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('Service Order Details')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('buyer.dashboard') }}">@lang('Dashboard')</a>
		</li>
  
		<li>
			@lang('Service Order Details')
		</li>
	</ul>
</div>

<div class="dashboard--content-item">

    <div class="row">
        <div class="col-md-4">
            <div class="card text--dark">
                <div class="card-body p-4">
                    <h5 class="card-title text--dark">@lang('Buyer Details')</h5>

                    <div class="details text-secondary my-3">
                        <div class="details__item mb-2">
                           <strong><span class="details__name">@lang('Name:')</span></strong> 
                            <span class="details__value">{{ $serviceorder->buyer->name }}</span>
                        </div>
                        <div class="details__item mb-2">
                            <strong><span class="details__name">@lang('Email:')</span></strong>
                            <span class="details__value">{{ $serviceorder->buyer->email }}</span>
                        </div>
                        <div class="details__item mb-2">
                           <strong> <span class="details__name">@lang('Phone:')</span></strong>
                            <span class="details__value">{{ $serviceorder->buyer->mobile }}</span>
                        </div>
                    </div>

                    <h5 class="card-title text--dark mt-4">@lang('Amount Details')</h5>
                    <div class="details text-secondary my-3">
                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Package Fee:')</span></strong>
                            <span class="details__value"> {{ rootAmount($serviceorder->package_fee) }} {{ $defaultCurrency->sign }} </span>
                        </div>
                   
                   
                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Extra Service Cost:')</span></strong>
                            <span class="details__value"> {{ rootAmount($serviceorder->additional_service_cost) }} {{ $defaultCurrency->sign }} </span>
                        </div>

                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Tax:')</span></strong>
                            <span class="details__value"> {{ rootAmount($serviceorder->tax) }} {{ $defaultCurrency->sign }} </span>
                        </div>
                   

                   
                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Total:')</span></strong>
                            <span class="details__value"> {{ rootAmount($serviceorder->total) }} {{ $defaultCurrency->sign }} </span>
                        </div>
                   
                    
                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Admin Commission:')</span></strong>
                            <span class="details__value"> {{ rootAmount($serviceorder->commission_amount) }} {{ $defaultCurrency->sign }} </span>
                        </div>
                    
                    
                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Payment Gateway:')</span></strong>
                            <span class="details__value"> {{ $serviceorder->payment_method}} </span>
                        </div>

                        <div class="details__item mb-2">
                            <strong> <span class="details__name">@lang('Payment Status:')</span></strong>
                            <span class="details__value"> {{ $serviceorder->payment_status}} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 my-2">
          
                
                    <h5 class="card-title text--light">@lang('Service Includes')</h5>

                    <div class="table-responsive table--mobile-lg">
                        <table class="table bg--body">
                            <thead>
                                <tr>
                                    <th>@lang('Service Name')</th>
                                    <th>@lang('Service Price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serviceincludes as $serviceinclude)
                                <tr>
                                    <td data-label="@lang('Service Name')">{{ $serviceinclude->include_service_title }}</td>
                                    <td data-label="@lang('Service Price')">{{ rootAmount($serviceinclude->include_service_price) }} {{ $defaultCurrency->sign }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
    </div>
</div>



@endsection

@push('js')

@endpush
