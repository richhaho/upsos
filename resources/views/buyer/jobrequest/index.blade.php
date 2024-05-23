@extends('layouts.user')

@section('contents')
<div class="breadcrumb-area">
	<h3 class="title">@lang('Job Requests')</h3>
	<ul class="breadcrumb">
		<li>
		  <a href="{{ route('buyer.dashboard') }}">@lang('Dashboard')</a>
		</li>
  
		<li>
			@lang('Job Requests')
		</li>
	</ul>
</div>


<div class="dashboard--content-item">
	  <div class="table-responsive table--mobile-lg">
		  <table class="table bg--body">
			  <thead>
				  <tr>
                    <th>@lang('No')</th>
					<th>@lang('Job Type')</th>
					<th>@lang('Job Title')</th>
					<th>@lang('Seller Name')</th>
					<th>@lang('Seller Offer')</th>
                    <th>@lang('Your Offer')</th>
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

						<td data-label="@lang('Job Type')">
							<div>
							{{  $data->job_type==0 ? 'offline' : 'online' }}
							</div>
						</td>

						<td data-label="@lang('Job Title')">
							<div>
							{{ \Illuminate\Support\Str::limit($data->job_title, 20) }}
							</div>
						</td>

						<td data-label="@lang('Seller Name')">
							<div>
							{{ $data->seller->name }}
							</div>
						</td>

                        <td data-label="@lang('Seller Offer')">
							<div>
								{{ showAmount($data->seller_offer) }}
							
							</div>
						</td>
                        <td data-label="@lang('Your Offer')">
							<div>
								{{ showAmount($data->buyer_offer) }}
							
							</div>
						</td>

						<td data-label="@lang('Actions')">
							<div>
							
                            

                            <a href="{{ route('buyer.job.conversation',$data->job_id) }}" class="icon-btn btn btn-success" data-original-title="@lang('conversasion')">
                            <i class="fas fa-comments"></i>
                            </a>

                            <a href="javascript:;" data-href="{{ route('buyer.jobrequest.delete',$data->id) }}" data-bs-toggle="modal" data-bs-target="#exampleModal" class="icon-btn delete btn btn-danger" id="delete" data-original-title="@lang('Delete')">
                            <i class="fas fa-trash"></i>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Delete Modal')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				
			   <h4 class="text-center">@lang('Are You Sure Want to Delete This?')</h4>
                
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
				<a href="" id="modalbtn" class="btn btn-danger">@lang('Delete')</a>
			</div>
        </div>
    </div>
</div>

@endsection

@push('js')

<script type="text/javascript">
	"use strict";
	$('#delete').on('click', function(){
		var modal = $('#exampleModal');
		var url = $(this).data('href');
		modal.find('#modalbtn').attr("href", url);
	})
</script>

@endpush
