@extends('layouts.admin')

@section('content')


<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Declined Services') }}</h5>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.services.declined') }}">{{ __('Manage Services') }}</a></li>
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
                <th>{{ __('User Email') }}</th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Created At') }}</th>
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
               ajax: '{{ route('admin.services.datatables','declined') }}',
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'email', name: 'email'},
                        { data: 'title', name: 'title' },
                        { data: 'price', name: 'price' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
               language: {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });


    </script>
@endsection
