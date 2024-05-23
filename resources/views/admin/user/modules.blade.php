@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="d-sm-flex align-items-center justify-content-between py-3">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Edit KYC Module') }} </h5>
    <ol class="breadcrumb py-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">{{ __('Manage User KYC Module') }}</a></li>
    </ol>
    </div>
</div>

    <div class="card mb-4 mt-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit User KYC Module') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{route('admin.manage.module.update')}}" method="POST" enctype="multipart/form-data">

            @include('includes.admin.form-both')

            {{ csrf_field() }}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="module_section[]" value="Service" {{ $data->sectionCheck('Service') ? 'checked' : '' }} class="custom-control-input" id="Service">
                  <label class="custom-control-label" for="Service">{{__('Service')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="module_section[]" value="Job" {{ $data->sectionCheck('Job') ? 'checked' : '' }} class="custom-control-input" id="Job">
                  <label class="custom-control-label" for="Job">{{__('Job')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="module_section[]" value="Deposits" {{ $data->sectionCheck('Deposits') ? 'checked' : '' }} class="custom-control-input" id="deposit">
                  <label class="custom-control-label" for="deposit">{{__('Deposits')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="module_section[]" value="Payouts" {{ $data->sectionCheck('Payouts') ? 'checked' : '' }} class="custom-control-input" id="payout">
                  <label class="custom-control-label" for="payout">{{__('Payouts')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="module_section[]" value="Job Order" {{ $data->sectionCheck('Job Order') ? 'checked' : '' }} class="custom-control-input" id="joborder">
                  <label class="custom-control-label" for="joborder">{{__('Job Order')}}</label>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="module_section[]" value="Service Order" {{ $data->sectionCheck('Service Order') ? 'checked' : '' }} class="custom-control-input" id="serviceorder">
                  <label class="custom-control-label" for="serviceorder">{{__('Service Order')}}</label>
                  </div>
              </div>
            </div>
          </div>
            <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>

@endsection
