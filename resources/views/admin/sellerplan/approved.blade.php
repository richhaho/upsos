@extends('layouts.admin')


@section('content')
<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Seller Subscription') }}</h5>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Approved Plan') }}</a></li>
        </ol>
	</div>
</div>


<div class="row mt-3">
  <div class="col-lg-12">
	@include('includes.admin.form-success')

	<div class="card mb-4">
        <div class="row px-3 py-3">
            <div class="bulk-delete-section">
                <div class="select-box-section">
                    <select class="form-control" id="bulk_option" >
                        <option value="">@lang('Bulk Action')</option>
                        <option value="delete">@lang('Delete')</option>
                    </select>

                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-href="{{ route('admin.sellerplans.bulk.delete') }}" data-target="" id="bulk_apply">@lang('Apply')</button>
                </div>
            </div>
        </div>
        <div class="table-responsive p-3">
            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="" id="headercheck">
                        </th>
                        <th>{{ __('User Name') }}</th>
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Method') }}</th>
                        <th>{{ __('Transaction ID') }}</th>
                        <th>{{ __('Purchase Time') }}</th>
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

{{-- Details Modal --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __("Subscription Details") }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body" id="detail-table">
           
        </div>
      </div>
    </div>
  </div>

@endsection



@section('scripts')

    <script type="text/javascript">
	"use strict";

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               searching: true,
               ajax: '{{ route('admin.seller.plans.datatables','1') }}',
               columns: [
                        { data: 'checkbox', name: 'checkbox' },
                        { data: 'user', name: 'user' },
                        { data: 'plan', name: 'plan' },
                        { data: 'price', name: 'price' },
                        { data: 'method', name: 'method' },
                        { data: 'txnid', name: 'txnid' },
                        { data: 'time', name: 'time' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
               language: {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });


   

    </script>

<script>
    $('.bd-example-modal-lg').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget)
         var href = button.data('href')
         $('#detail-table').load(href);
     })
 </script>
@endsection
