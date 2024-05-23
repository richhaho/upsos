@extends('layouts.admin')

@section('content')

<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between py-3">
	<h5 class=" mb-0 text-gray-800 pl-3">{{ __('Commission Setting') }} <a class="btn btn-primary btn-rounded btn-sm" href="{{route('admin.commission.setting')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h5>
	<ol class="breadcrumb py-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">{{ __('Commission Setting') }}</a></li>
	</ol>
	</div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-md-10">
    <!-- Form Basic -->
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Update Commission Setting') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{ route('admin.gs.update') }}" method="POST" enctype="multipart/form-data">

            @include('includes.admin.form-both')

            {{ csrf_field() }}

            <div class="form-group">
              <label for="inp-name">{{ __('Type') }}</label>
              <select class="form-control mb-3" name="commission_type">
                <option {{ $gs->commission_type==1 ? 'selected':'' }} value="1">{{__('Percentage')}}</option>
                <option {{ $gs->commission_type==0 ? 'selected':'' }}  value="0">{{__('Fixed Amount')}}</option>
              </select>
            </div>

            <div class="form-group">
                <label for="inp-percentage">{{  __('Amount')  }}</label>
                <input type="number" class="form-control" id="inp-percentage" placeholder="{{  __('Amount')  }}" step="0.1" name="commission_price" value="{{ $gs->commission_price }}" required>
            </div>

            <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>
  </div>

</div>
@endsection
