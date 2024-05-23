@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('Job Offer Details')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
		</li>
		<li>
			@lang('Job Offer Details')
		</li>
	</ul>
</div>


<div class="dashboard--content-item">

<!-- Button trigger modal -->

@if(DB::table('job_orders')->where('job_request_id', $jobrequest->id)->exists())
<button type="button" class="btn btn-danger" >
@lang('Already Hired')
</button>
@else
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  @lang('Hire Now')
</button>
@endif


</div>



@endsection

@push('js')


@endpush
