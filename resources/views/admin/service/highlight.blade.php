@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="d-sm-flex align-items-center justify-content-between py-3">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Edit Service Highlight') }} </h5>
    <ol class="breadcrumb py-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">{{ __('Service Highlight') }}</a></li>
    </ol>
    </div>
</div>

    <div class="card mb-4 mt-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit Service Highlight') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{route('admin.services.highlight.update',$service->id)}}" method="POST" enctype="multipart/form-data">

            @include('includes.admin.form-both')

            {{ csrf_field() }}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="is_featured"  {{ $service->is_featured == 1 ? 'checked' : '' }} class="custom-control-input" id="featured">
                  <label class="custom-control-label" for="featured">{{__('Is Featured')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="is_best"  {{ $service->is_best == 1 ? 'checked' : '' }} class="custom-control-input" id="best">
                  <label class="custom-control-label" for="best">{{__('Is Best')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="is_popular"  {{ $service->is_popular == 1 ? 'checked' : '' }} class="custom-control-input" id="Popular">
                  <label class="custom-control-label" for="Popular">{{__('Is Popular')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="is_trending"  {{ $service->is_trending == 1 ? 'checked' : '' }} class="custom-control-input" id="Trending">
                  <label class="custom-control-label" for="Trending">{{__('Is Trending')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_new" {{ $service->is_new == 1 ? 'checked' : '' }} class="custom-control-input" id="New">
                    <label class="custom-control-label" for="New">{{__('Is New')}}</label>
                    </div>
                </div>
            </div>





            <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>

@endsection
