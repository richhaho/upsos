@extends('layouts.admin')

@section('content')


<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Manage City') }}</h5>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">{{ __('Category') }}</a></li>
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
                
                <th>{{ __('Country') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Tax') }}</th>
                <th>{{ __('Options') }}</th>
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
               ajax: '{{ route('admin.cities.datatables') }}',
               columns: [
                        
                        { data: 'country_id', name: 'country_id' },
                        { data: 'title', name: 'title' },
                        { data: 'status', name: 'status' },
                        { data: 'tax', name: 'tax' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
               language: {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });
			$(function() {
                $(".btn-area").append('<div class="col-sm-12 col-md-4 pr-3 text-right">'+
                    '<a class="btn btn-primary" href="{{route('admin.cities.create')}}">'+
                        '<i class="fas fa-plus"></i> {{__('Add New')}}'+
                    '</a>'+
                '</div>');
            });

    </script>
@endsection
