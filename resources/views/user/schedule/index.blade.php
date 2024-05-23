@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('Schedule')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
		</li>
		<li>
			@lang('Schedule')
		</li>
	</ul>
</div>

<div class="text-right mr-0">
  <button type="button" class="btn add-btn float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
    @lang('Add Schedule')
  </button>
</div>

<div class="dashboard--content-item">
	  <div class="table-responsive table--mobile-lg">
		  <table class="table bg--body table-bordered">
			  <thead>
				  <tr>
					<th>@lang('No')</th>
					<th>@lang('Day')</th>
					<th>@lang('Schedule')</th>
					<th>@lang('Action')</th>
				  </tr>
			  </thead>
			  <tbody>
          @foreach($schedules as $key => $value)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $value->day }}</td>
            <td>{{ $value->schedule }}</td>
            <td>
              <button id="edit" data-schedule="{{ $value->schedule }}" data-day="{{ $value->day}}" data-href="{{ route('user.update.schedule', $value->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></button>
              <button  id="delete"  data-href="{{ route('user.delete.schedule', $value->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
          @endforeach 
			  </tbody>
		  </table>
	  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">@lang('Add Schedule')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @includeIf('includes.flash')
        <form id="request-form" action="{{ route('user.store.schedule') }}" method="POST">
            @csrf
        <div class="modal-body">
                <label for="days">@lang('Select Days')</label>
                <div class="input-group">
                <select class="form-control" name="day" id="day">
                    <option value="monday">@lang('Monday')</option>
                    <option value="tuesday">@lang('Tuesday')</option>
                    <option value="wednesday">@lang('Wednesday')</option>
                    <option value="thursday">@lang('Thursday')</option>
                    <option value="friday">@lang('Friday')</option>
                    <option value="saturday">@lang('Saturday')</option>
                    <option value="sunday">@lang('Sunday')</option>
                </select>
                </div>
                <br>
                <label for="schedule">@lang('Select Time')</label>
                <div class="input-group">
                    <input type="text" class="form-control"  name="schedule" id="time">
                </div>
                <p class="my-5">eg: 10:00Am - 11:00PM, @lang('this schedule time will show in frontend, when anyone want to book your service, they will select this schedule time made by you')</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
          <button type="submit" class="cmn--btn">@lang('Submit')</button>
        </div>
      </form>
        
      </div>
    </div>
  </div>

  @include('partials.front.delete')

@endsection

@push('js')

<script type="text/javascript">
  "use strict";
    $(document).ready(function(){
        $('#edit').click(function(){
          $('#exampleModal').modal('show');
          $('#request-form').attr('action', $(this).data('href'));
          $('#day').val($(this).data('day'));
          $('#time').val($(this).data('schedule'));
   
    })


    $('#delete').click(function(){
      $('#deleteModal').modal('show');
      $('#modaldelete').attr('href', $(this).data('href'));
    })


    })
        
</script>

@endpush
