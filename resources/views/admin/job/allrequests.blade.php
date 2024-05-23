@extends('layouts.admin')

@section('content')


<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ __('All Request') }}</h5>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.jobs.index') }}">{{ __('Manage Jobs') }}</a></li>
        </ol>
	</div>
</div>


<div class="row mt-3">
  <div class="col-lg-12">
    @include('includes.admin.form-success')
	<div class="card mb-4">
	  <div class="table-responsive p-3">
        
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		  <thead class="thead-light">
			<tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Job ID') }}</th>
                <th>{{ __('Seller Details') }}</th>
                <th>{{ __('Buyer Offer') }}</th>
                <th>{{ __('Seller Offer') }}</th>
                <th>{{ __('Options') }}</th>
			</tr>
		  </thead>
          <tbody>
            @if (count($jobrequests) == 0)

            <tr>
                <td class="text-center" colspan="100%">
                    <h5>{{ __('NO DATA FOUND') }}</h5>
                </td>
            </tr>
            @endif
            
            @foreach ($jobrequests as $data)
            <tr>
              
               <td>{{ $data->id }}</td>
               <td>{{ $data->job_id }}</td>
               <td>{{ $data->seller->name }}</td>
               <td>{{ $data->buyer_offer }}</td>
               <td>{{ $data->seller_offer }}</td>
               <td>
                   
                   <a href="{{ route('admin.job.request.conversation', $data->job_id) }}" class="btn btn-info btn-sm">@lang('View Conversation')</a>
               </td>
            </tr> 
            @endforeach
            
            
          </tbody>
		</table>
        {{ $jobrequests->links() }}
	  </div>
	</div>
  </div>
</div>

@endsection



@section('scripts')

@endsection
