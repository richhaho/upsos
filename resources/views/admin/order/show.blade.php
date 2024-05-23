@extends('layouts.admin')

@section('content')

<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between py-3">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ $data->service->title }}</h5>
        <ol class="breadcrumb py-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('User') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">{{ __('Users') }}</a></li>
        </ol>
	</div>
</div>


<div class="row mt-3">
  <div class="col-lg-12">
    @php
      $currency = globalCurrency();
    @endphp
	@include('includes.admin.form-success')

	<div class="card p-2">
        <h3 class="card-title text-center my-5"> <strong>@lang('Service Details')</strong></h3>
            <div class="row my-5">

                <div class="col-md-4 mx-auto my-3">
                    <div class="img-header mb-3">
                        <h4>{{ __('Service Info') }}</h4>
                    </div>
                    <div class="table-responsive show-table">
                        <table class="table">
                        <tr>
                          <th>{{__('ID#')}}</th>
                          <td>{{$data->service->id}}</td>
                        </tr>
                        <tr>
                          <th>{{__('Title')}}</th>
                          <td>{{$data->service->title}}</td>
                        </tr>
                    
                        <tr>
                          <th>{{__('Service Type')}}</th>
                          <td>{{$data->service->is_service_online == 1 ? 'Online' : 'Offline'}}</td>
                        </tr>
                        <tr>
                          <th>{{__('Total Order')}}</th>
                          <td>{{$data->service->sold_count}}</td>
                        </tr>
    
                        <tr>
                          <th>{{__('Total View')}}</th>
                          <td>{{$data->service->view}}</td>
                        </tr>

                        <tr>
                          <th>{{__('Total Price')}}</th>
                          <td>{{showAdminPrice($data->total)}}</td>
                        </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 mx-auto my-3">
                    <div class="img-header mb-3">
                        <h4>{{ __('Service Benefits') }}</h4>
                    </div>
                    <ul class="list-unstyled">
                    @foreach ($data->service->benefits as $benefit)
                        <li class="mb-2">
                            <i class="fas fa-check"></i> {{ $benefit->benefits }}
                        </li>
                    @endforeach
                </ul>
                </div>

                <div class="col-md-3 mx-auto my-3">
                    <div class="img-header mb-3">
                        <h4>{{ __('Service Image') }}</h4>
                    </div>
                    <img src="{{ asset('assets/images/'.$data->service->image) }}" class="img-fluid rounded" alt="">
                </div>
    
            </div>


        
        <div class="row d-flex justify-content-between mt-5">

            <div class="col-md-6 ">
                <h4 class="text-center">@lang('Seller Details')</h4>
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4">
                        <div class="user-image">
                            
                            <img  class="" src="{{ $data->service->seller->photo ? asset('assets/images/'.$data->service->seller->photo):asset('assets/images/noimage.png')}}" alt="No Image">
                            
                            <a  class="mybtn1 btn btn-primary"  data-email="{{ $data->service->seller->email }}" data-toggle="modal" data-target="#vendorform" href="">{{__('Send Message')}}</a>
        
                        </div>
                    </div>
                    <div class="col-md-8 mt-5">
                        <div class="table-responsive show-table">
                            <table class="table">
                            <tr>
                              <th>{{__('ID#')}}</th>
                              <td>{{$data->service->seller->id}}</td>
                            </tr>
                            <tr>
                              <th>{{__('Username')}}</th>
                              <td>{{$data->service->seller->name}}</td>
                            </tr>
                            <tr>
                              <th>{{__('Email')}}</th>
                              <td>{{$data->service->seller->email}}</td>
                            </tr>
                            <tr>
                              <th>{{__('Address')}}</th>
                              <td>{{$data->service->seller->address}}</td>
                            </tr>
        
                            <tr>
                              <th>{{__('City')}}</th>
                              <td>{{$data->service->seller->city}}</td>
                            </tr>
        
                            <tr>
                              <th>{{__('Zip Code')}}</th>
                              <td>{{$data->service->seller->zip}}</td>
                            </tr>
        
        
                            </table>
                        </div>
                    </div>

                </div>
               
            </div>

            <div class="col-md-6">
                <h4 class="text-center">@lang('Buyer Details')</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="user-image">
                            
                            <img  class="" src="{{ $data->buyer->photo ? asset('assets/images/'.$data->buyer->photo):asset('assets/images/noimage.png')}}" alt="No Image">
                            
                            <a  class="mybtn1 btn btn-primary"  data-email="{{ $data->buyer->email }}" data-toggle="modal" data-target="#vendorform" href="">{{__('Send Message')}}</a>
        
                        </div>
                    </div>
                    <div class="col-md-8 mt-5">
                        <div class="table-responsive show-table">
                            <table class="table">
                            <tr>
                              <th>{{__('ID#')}}</th>
                              <td>{{$data->buyer->id}}</td>
                            </tr>
                            <tr>
                              <th>{{__('Username')}}</th>
                              <td>{{$data->buyer->name}}</td>
                            </tr>
                            <tr>
                              <th>{{__('Email')}}</th>
                              <td>{{$data->buyer->email}}</td>
                            </tr>
                            <tr>
                              <th>{{__('Address')}}</th>
                              <td>{{$data->buyer->address}}</td>
                            </tr>
        
                            <tr>
                              <th>{{__('City')}}</th>
                              <td>{{$data->buyer->city}}</td>
                            </tr>
        
                            <tr>
                              <th>{{__('Zip Code')}}</th>
                              <td>{{$data->buyer->zip}}</td>
                            </tr>
        
        
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>


	</div>
  </div>
  <!-- DataTable with Hover -->

</div>

<div class="row mb-3">
    

  </div>
<!--Row-->

{{-- STATUS MODAL --}}

<div class="modal fade confirm-modal" id="statusModal" tabindex="-1" role="dialog"
	aria-labelledby="statusModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title">{{ __("Update Status") }}</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
			<p class="text-center">{{ __("You are about to change the status.") }}</p>
			<p class="text-center">{{ __("Do you want to proceed?") }}</p>
		</div>
		<div class="modal-footer">
		<a href="javascript:;" class="btn btn-secondary" data-dismiss="modal">{{ __("Cancel") }}</a>
		<a href="javascript:;" class="btn btn-success btn-ok">{{ __("Update") }}</a>
		</div>
	</div>
	</div>
</div>

{{-- STATUS MODAL ENDS --}}


{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal fade confirm-modal" id="vendorform" tabindex="-1" role="dialog"
    aria-labelledby="vendorformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="vendorformLabel">{{ __("Send Message") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="contact-form">
                            <form id="emailreply1">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <input type="email" class="form-control" id="eml1" name="to"  placeholder="{{ __('Email') }}" value="{{ $data->service->seller->email }}" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="subj1" name="subject"  placeholder="{{ __('Subject') }}" value="" required="">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="message" id="msg1" cols="20" rows="6" placeholder="{{ __('Your Message') }} "required=""></textarea>
                                </div>
                                <button class="submit-btn btn btn-primary text-center" id="emlsub1" type="submit">{{ __("Send Message") }}</button>
                            </form>
                        </div>
                    </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    {{-- MESSAGE MODAL ENDS --}}

{{-- DELETE MODAL --}}

<div class="modal fade confirm-modal" id="deleteModal" tabindex="-1" role="dialog"
aria-labelledby="deleteModalTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">{{ __("Confirm Delete") }}</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
	<p class="text-center">{{__("You are about to delete this Blog.")}}</p>
	<p class="text-center">{{ __("Do you want to proceed?") }}</p>
</div>
<div class="modal-footer">
	<a href="javascript:;" class="btn btn-secondary" data-dismiss="modal">{{ __("Cancel") }}</a>
	<a href="javascript:;" class="btn btn-danger btn-ok">{{ __("Delete") }}</a>
</div>
</div>
</div>
</div>

{{-- DELETE MODAL ENDS --}}

@endsection



