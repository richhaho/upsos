@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('All Request')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
		</li>
  
		<li>
			@lang('All request')
		</li>
	</ul>
</div>

<div class="dashboard--content-item">
	  <div class="table-responsive table--mobile-lg">
		  <table class="table bg--body">
			  <thead>
				  <tr>
                    <th>@lang('No')</th>
					<th>@lang('Buyer Name')</th>
					<th>@lang('Job Title')</th>
					<th>@lang('Apply date')</th>
					<th>@lang('Buyer Offer')</th>
					<th>@lang('Your Offer')</th>
                    <th>@lang('Job Type')</th>
                    <th>@lang('status')</th>
                    <th>@lang('Action')</th>
				  </tr>
			  </thead>
			  <tbody>
				@if (count($jobrequests) == 0)
					<tr>
						<td colspan="12">
							<h4 class="text-center m-0 py-2">{{__('No Data Found')}}</h4>
						</td>
					</tr>
				@else
				@foreach($jobrequests as $key=>$data)
				  @php
					  $from = App\Models\User::where('id',$data->user_id)->first();
				  @endphp
					<tr>
						<td data-label="@lang('No')">
							<div>

							<span class="text-muted">{{ $loop->iteration }}</span>
							</div>
						</td>
                        <td data-label="@lang('Seller Name')">
							<div>
							{{ $data->buyer->name }}
							</div>
						</td>

                        <td data-label="@lang('Job Title')">
							<div>
                                {{ \Illuminate\Support\Str::limit($data->job->job_title, 20) }}
							</div>
						</td>


						<td data-label="@lang('Order date')">
							<div>
							{{  $data->created_at->format('d M, Y') }}
							</div>
						</td>

                        <td data-label="@lang('Buyer Offer')">
							<div>
								{{ showAmount ($data->buyer_offer)}}
                           
							</div>
						</td>

						<td data-label="@lang('Your Offer')">
							<div>
                            {{showAmount($data->seller_offer) }} 
							</div>
						</td>

                       

                        <td data-label="@lang('Job Type')">
							<div>
							{{  $data->job_type==0 ? 'offline' : 'online' }}
							</div>
						</td>

						<td data-label="@lang('status')">
							<div class="btn {{ $data->hired_status==0 ? "btn-warning" : "btn-danger"}}">
							{{  $data->hired_status==0 ? 'pending' : 'Already Hired' }}
							</div>
						</td>

						<td data-label="@lang('Actions')">
							<div>
							
                            <a href="{{ route('user.job.order.details',$data->job_id) }}" class="icon-btn btn btn-primary" data-original-title="@lang('View')">
                            <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('user.job.conversation',$data->job_id) }}" class="icon-btn btn btn-success" data-original-title="@lang('conversasion')">
                            <i class="fas fa-comments"></i>
                            </a>

							</div>
						</td>
					</tr>
			 	 @endforeach
				@endif
			  </tbody>
		  </table>
	  </div>
	  {{ $jobrequests->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="completemodal" tabindex="-1" aria-labelledby="completemodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="completemodalLabel">@lang('Create Order Complete Request')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @includeIf('includes.flash')
        <form id="request-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <label for="">@lang('Select Status')</label>
                <select name="order_complete_request" id="" class="form-control">
                    <option value="">@lang('Select Status')</option>
                    <option value="pending">@lang('Completed')</option>
                </select>
            </div>
            <div class="modal-footer">
              <button  type="submit" class="btn btn-primary">@lang('Save')</button>
            </div>
        </form>
      </div>
    </div>
</div>

@endsection

@push('js')

<script type="text/javascript">
	"use strict";

    $(document).ready(function(){
        $('#order').click(function(){
            var href = $(this).data('val');
            $('#request-form').attr('action', href);
        });
    });

</script>

@endpush
