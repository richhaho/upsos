@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('Service Order')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
		</li>
  
		<li>
			@lang('Service Order')
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
					<th>@lang('Service Name')</th>
					<th>@lang('Service Date')</th>
					<th>@lang('Schedule')</th>
					<th>@lang('Price')</th>
                    <th>@lang('Payment Status')</th>
                    <th>@lang('Order Status')</th>
                    <th>@lang('Service Type')</th>
                    <th>@lang('Order Complete Request')</th>
                    <th>@lang('Action')</th>
				  </tr>
			  </thead>
			  <tbody>
				@if (count($serviceorder) == 0)
					<tr>
						<td colspan="12">
							<h4 class="text-center m-0 py-2">{{__('No Data Found')}}</h4>
						</td>
					</tr>
				@else
				@foreach($serviceorder as $key=>$data)
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

                        <td data-label="@lang('Service Name')">
							<div>
                                {{ \Illuminate\Support\Str::limit($data->service->title, 20) }}
							</div>
						</td>


						<td data-label="@lang('Service date')">
							<div>
							{{  $data->date }}
							</div>
						</td>
						<td data-label="@lang('Schedule')">
							<div>
							{{  $data->schedule }}
							</div>
						</td>
						

                        <td data-label="@lang('Price')">
							<div>
                            {{rootAmount($data->total) }} {{ $defaultCurrency->sign }}
							</div>
						</td>

						<td  data-label="@lang('Payment Status')">
                            <span class=" mb-2 badge {{ $data->payment_status=='completed' ? 'badge--success' : 'badge--warning'}}">
                            {{ $data->payment_status}}
                            </span>
							<p>{{ $data->payment_method }}</p>
						</td>

                        

                        <td  data-label="@lang('Order Status')">
                            @if($data->status == 0)
                                <span class="badge badge--warning">@lang('Pending')</span>
                            @elseif($data->status == 1)
                                <span class="badge badge--primary">@lang('Active')</span>
                            @elseif($data->status == 2)
                                <span class="badge badge--success">@lang('Completed')</span>
							@else
								<span class="badge badge--danger">@lang('Cancel')</span>
                            @endif
						</td>

                        <td data-label="@lang('Job Type')">
							<div>
							{{  $data->is_online==0 ? 'offline' : 'online' }}
							</div>
						</td>

                        <td data-label="@lang('Order Complete Request')">
							<div>
								@if ($data->order_complete_request==0)
								
								<button id="completed" type="button"  class="btn btn-primary btn-sm" data-bs-toggle="modal" data-val={{ route('seller.service.order.complete', $data->id) }} data-bs-target="#completemodal">
									@lang('Create Request')
								</button>
								@elseif($data->order_complete_request==1)

								<button type="button" class="btn btn-warning btn-sm" >
									@lang('Request Sent!')
								</button>
								@else

								<button type="button" class="btn btn-success btn-sm" >
									@lang('completed')
								</button>
								@endif
							
							</div>
						</td>


						<td data-label="@lang('Actions')">
							<div>

                            @if ($data->status != 1)
                                <button id="order" type="button" data-val="{{ route('user.service.order.status',$data->id) }}" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderstatus">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                            <a href="{{ route('user.service.order.details',$data->id) }}" class="icon-btn btn btn-primary btn-sm " data-original-title="@lang('View')">
                            <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('user.service.conversation',$data->id) }}" class="icon-btn btn btn-success btn-sm" data-original-title="@lang('conversasion')">
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
	  {{ $serviceorder->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="orderstatus" tabindex="-1" aria-labelledby="completemodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="completemodalLabel">@lang('Change Order Status')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @includeIf('includes.flash')
        <form id="request-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                  <label for="order_status"></label>
                  <select class="form-control" name="status" id="order_status">
                    <option value="0">@lang('Pending')</option>
                    <option value="2">@lang('Active')</option>
                    <option value="1">@lang('Completed')</option>
                    </option>
                  </select>
                </div>
                
            </div>
            <div class="modal-footer">
              <button  type="submit" class="btn btn-primary">@lang('Save')</button>
            </div>
        </form>
      </div>
    </div>
</div>

{{-- Complete Request Modal --}}

<!-- Modal -->
<div class="modal fade" id="completemodal" tabindex="-1" aria-labelledby="completemodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="completemodalLabel">@lang('Order Complete Request')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @includeIf('includes.flash')
        <form id="complete-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body text-center">
                @lang('Are you sure to change status?')
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

		$(document).on('click','#completed',function(){
			var url = $(this).data('val');
			$('#complete-form').attr('action',url);
		});
	

    });
</script>

@endpush
