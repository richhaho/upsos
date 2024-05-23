@extends('layouts.admin')

@section('content')

<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between">
		<h5 class=" mb-0 text-gray-800 pl-3">{{ __('Choose Us') }}</h5>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">{{ __('Home Page Manage') }}</a></li>
			<li class="breadcrumb-item"><a href="{{ route('admin.feature.index') }}">{{ __('Choose Us Section') }}</a></li>
		</ol>
	</div>
</div>


<div class="row mt-3">

	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
			  <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
			  <form class="geniusform" action="{{route('admin.ps.update')}}" method="POST" enctype="multipart/form-data">

				  @include('includes.admin.form-both')

				  {{ csrf_field() }}
				  <div class="form-group">
					<label>{{ __('Set Background Image') }}</label>
					<div class="wrapper-image-preview">
						<div class="box full-width">
							<div class="back-preview-image" style="background-image: url({{ $ps->choose_us_photo ? asset('assets/images/'.$ps->choose_us_photo) : asset('assets/images/placeholder.jpg') }});"></div>
							<div class="upload-options">
								<label class="img-upload-label full-width" for="img-upload"> <i class="fas fa-camera"></i> {{ __('Upload Picture') }} </label>
								<input id="img-upload" type="file" class="image-upload" name="choose_us_photo" accept="image/*">
							</div>
						</div>
					</div>
				</div>
				  <button type="submit" id="submit-btn" class="btn btn-primary mt-2 w-100">{{ __('Submit') }}</button>

			  </form>
			</div>
		  </div>
	  </div>


  <div class="col-lg-12">
	@include('includes.admin.form-success')

	<div class="card mb-4">
	  <div class="table-responsive p-3">
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		  <thead class="thead-light">
			<tr>
                <th>{{ __('Icon') }}</th>
                <th>{{ __('Title') }}</th>
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
               ajax: '{{ route('admin.feature.datatables') }}',
               columns: [
                        { data: 'icon', name: 'icon' , searchable: false, orderable: false},
                        { data: 'title', name: 'title' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
                language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });

			$(function() {
            $(".btn-area").append('<div class="col-sm-12 col-md-4 pr-3 text-right">'+
                '<a class="btn btn-primary" href="{{route('admin.feature.create')}}">'+
					'<i class="fas fa-plus"></i> Add New'+
				'</a>'+
            '</div>');
        });

	</script>

@endsection
