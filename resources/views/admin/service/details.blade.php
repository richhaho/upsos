@extends('layouts.admin')

@section('content')

<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between py-3">
        <h5 class=" mb-0 text-gray-800 pl-3">{{ $service->title }}</h5>
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
                          <td>{{$service->id}}</td>
                        </tr>
                        <tr>
                          <th>{{__('Title')}}</th>
                          <td>{{$service->title}}</td>
                        </tr>
                    
                        <tr>
                          <th>{{__('Service Type')}}</th>
                          <td>{{$service->is_service_online == 1 ? 'Online' : 'Offline'}}</td>
						  <td>{{ $service->service_country_id }}>{{$service->service_city_id}}>{{$service->service_area_id}}</td>
 


                        </tr>
                        <tr>
                          <th>{{__('Total Order')}}</th>
                          <td>{{$service->sold_count}}</td>
                        </tr>
    
                        <tr>
                          <th>{{__('Total View')}}</th>
                          <td>{{$service->view}}</td>
                        </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 mx-auto my-3">
                    <div class="img-header mb-3">
                        <h4>{{ __('Service Benefits') }}</h4>
                    </div>
                    <ul class="list-unstyled">
                    @foreach ($service->benefits as $benefit)
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
                    <img src="{{ asset('assets/images/'.$service->image) }}" class="img-fluid rounded" alt="">
                </div>
    
            </div>


            <div class="row">
                <div class="col-md-6 mx-auto my-3">
                    <div class="img-header mb-3">
                        <h4>{{ __('Service Includes') }}</h4>
                    </div>
                    <div class="table-responsive p-3">
                        <table  class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($service->includes as $include)
                                <tr>
                                    <td>{{ $include->include_service_title }}</td>
                                    <td>{{ $include->include_service_price }}</td>
                                    <td>{{ $include->include_service_quantity }}</td>
                                    <td>{{ $include->include_service_price * $include->include_service_quantity }}</td>

                                    @php
                                        $total += $include->include_service_price * $include->include_service_quantity;
                                    @endphp

                                </tr>
                                    
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>{{ __('Total') }}</strong></td>
                                    <td><strong>{{ $total }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 mx-auto my-3">
                    <div class="img-header mb-3">
                        <h4>{{ __('Additional Service') }}</h4>
                    </div>
                    <div class="table-responsive p-3">
                        <table  class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($service->additionals as $additional)
                                <tr>
                                    <td>{{ $additional->additional_service_title }}</td>
                                    <td>{{ $additional->additional_service_price }}</td>
                                    <td>{{ $additional->additional_service_quantity }}</td>
                                    <td>{{ $additional->additional_service_price * $additional->additional_service_quantity }}</td>

                                    @php
                                        $total += $additional->additional_service_price * $additional->additional_service_quantity;
                                    @endphp

                                </tr>
                                    
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>{{ __('Total') }}</strong></td>
                                    <td><strong>{{ $total }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        <h3 class="card-title text-center my-5"> <strong>@lang('Seller Details')</strong></h3>
        <div class="row ">
            
            <div class="col-md-2">
                
                <div class="user-image">
                    
                    <img  class="" src="{{ $service->seller->photo ? asset('assets/images/'.$service->seller->photo):asset('assets/images/noimage.png')}}" alt="No Image">
                    
                    <a  class="mybtn1 btn btn-primary"  data-email="{{ $service->seller->email }}" data-toggle="modal" data-target="#vendorform" href="">{{__('Send Message')}}</a>

                </div>
            </div>
            <div class="col-md-5 mt-5">
                <div class="table-responsive show-table">
                    <table class="table">
                    <tr>
                      <th>{{__('ID#')}}</th>
                      <td>{{$service->seller->id}}</td>
                    </tr>
                    <tr>
                      <th>{{__('Username')}}</th>
                      <td>{{$service->seller->name}}</td>
                    </tr>
                    <tr>
                      <th>{{__('Email')}}</th>
                      <td>{{$service->seller->email}}</td>
                    </tr>
                    <tr>
                      <th>{{__('Address')}}</th>
                      <td>{{$service->seller->address}}</td>
                    </tr>

                    <tr>
                      <th>{{__('City')}}</th>
                      <td>{{$service->seller->city}}</td>
                    </tr>

                    <tr>
                      <th>{{__('Zip Code')}}</th>
                      <td>{{$service->seller->zip}}</td>
                    </tr>


                    </table>
                </div>
            </div>
            <div class="col-md-4 mx-auto my-3">
              <h5 class="card-title text-center"> <strong>@lang('Available Balance') : {{ convertedPrice($service->seller->balance,$currency->id) }}</strong></h5>
              <form action="{{ route('admin.user.balance.add.deduct') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="inp-address">{{ __('Amount') }}</label>
                  <input type="number" class="form-control" id="inp-address" name="amount"  placeholder="{{ __('Enter Amount') }}" value="" min="0" step="0.01" required>
                </div>

                <input type="hidden" name="user_id" value="{{ $service->seller->id }}">

                <div class="form-group">
                  <label for="exampleFormControlSelect1">@lang('Select Method')</label>
                  <select class="form-control" name="type" id="exampleFormControlSelect1" required>
                    <option value="add">@lang('add amount')</option>
                    <option value="subtract">@lang('subtract amount')</option>
                  </select>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>
              </form>
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
    <div class="modal fade confirm-modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
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
                                            <input type="email" class="form-control" id="eml1" name="to" placeholder="{{ __('Email') }}" value="{{ $service->seller->email }}" required="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="subj1" name="subject" placeholder="{{ __('Subject') }}" value="" required="" />
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" id="msg1" cols="20" rows="6" placeholder="{{ __('Your Message') }} " required=""></textarea>
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

    {{-- MESSAGE MODAL ENDS --}}

{{-- DELETE MODAL --}}


    <div class="modal fade confirm-modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
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



