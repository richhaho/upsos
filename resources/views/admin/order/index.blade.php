@extends('layouts.admin')

@section('content')


<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ __('All Orders') }}</h5>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('All Orders') }}</a></li>
        </ol>
	</div>
</div>


<div class="row mt-3">
  <div class="col-lg-12">
    
	<div class="card mb-4">

	  <div class="table-responsive p-3">
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		  <thead>
        <tr>
                  <th>@lang('No')</th>
                  <th>@lang('Buyer Name')</th>
                  <th>@lang('Service Name')</th>
                  <th>@lang('Service Date')</th>
                  <th>@lang('Schedule')</th>
                  <th>@lang('Price')</th>
                  <th>@lang('Payment Status')</th>
                  <th>@lang('Order Status')</th>
                  <th>@lang('Order Type')</th>
                  <th>@lang('Action')</th>
        </tr>
      </thead>
		</table>
	  </div>
	</div>
  </div>
</div>

@includeIf('partials.admin.status')
@includeIf('partials.admin.delete')
@endsection



@section('scripts')
    <script type="text/javascript">
	    "use strict";

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               searching: true,
               ajax: '{{ route('admin.orders.datatables',6) }}',
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'buyer_name', name: 'buyer_name' },
                        { data: 'service_name', name: 'service_name' },
                        { data: 'service_date', name: 'service_date' },
                        { data: 'schedule', name: 'schedule' },
                        { data: 'price', name: 'price' },
                        { data: 'payment_status', name: 'payment_status' },
                        { data: 'status', name: 'status' },
                        { data: 'order_type', name: 'order_type' },
                        
            			{ data: 'action', searchable: false, orderable: false }

                     ],
               language: {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });


    </script>
@endsection
