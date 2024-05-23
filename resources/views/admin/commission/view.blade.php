@extends('layouts.admin')

@section('content')

<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between py-3">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Commissions') }}</h5>
    <ol class="breadcrumb m-0 py-0">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
      <li class="breadcrumb-item"><a href="javascript:;">{{ __('Admin Commissions') }}</a></li>
    </ol>
	</div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-md-12">
    <!-- Form Basic -->
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Commission Details') }}</h6>
      </div>

      <div class="card-body p-5">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

        <div class="row">
            <td><strong>Commission From</strong> : {{ $data->commision_from }}</td>
        </div>
        <div class="row mt-4">
            <td><strong>Commission charge</strong> : {{ showAdminPrice($data->commision_charge) }}</td>
        </div>

        <div class="row mt-4">
            <td><strong>Commission For</strong> : {{ $data->commission_method}}</td>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
