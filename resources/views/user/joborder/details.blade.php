@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('Job Order Details')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
		</li>
  
		<li>
			@lang('Job Order Details')
		</li>
	</ul>
</div>

<div class="dashboard--content-item">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header p-3">
					<h5 class="text-dark">@lang('Buyer Details')</h5>
				</div>
				<div class="card-body text-dark">
					<div class="line-box">
						<label for=""> <strong>@lang('Name:')</strong> {{ $order->buyer->name }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Email:')</strong> {{ $order->buyer->email }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Phone:')</strong> {{ $order->buyer->phone }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Address:')</strong> {{ $order->buyer->address }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Country:')</strong> {{ $order->buyer->city }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Post Code:')</strong> {{ $order->buyer->zip }} </label>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-header p-3">
					<h5 class="text-dark">@lang('Order Details')</h5>
				</div>
				<div class="card-body text-dark">
					<div class="line-box">
						<label for=""> <strong>@lang('Order ID:')</strong> {{ $order->id }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Order Status:')</strong> {{ $order->order_status }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Amount:')</strong> {{ $order->price }} {{ $order->currency_sign }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Payment Method:')</strong> {{ $order->payment_method }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Payment Status:')</strong> {{ $order->payment_status }} </label>
					</div>
					<div class="line-box">
						<label for=""> <strong>@lang('Admin Commission:')</strong> {{ $order->admin_commission_price }} {{ $order->currency_sign }} </label>
					</div>
					
				</div>
			</div>
		</div>
	</div>
 
</div>



@endsection

@push('js')



@endpush
