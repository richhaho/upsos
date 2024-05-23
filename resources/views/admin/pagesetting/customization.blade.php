@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="d-sm-flex align-items-center justify-content-between py-3">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Edit Homepage Customization') }} </h5>
    <ol class="breadcrumb py-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">{{ __('Manage Homepage Customization') }}</a></li>
    </ol>
    </div>
</div>

    <div class="card mb-4 mt-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit Homepage Customization') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{route('admin.ps.customization.update')}}" method="POST" enctype="multipart/form-data">

            @include('includes.admin.form-both')

            {{ csrf_field() }}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="home_module[]" value="Hero" {{ $data->homeModuleCheck('Hero') ? 'checked' : '' }} class="custom-control-input" id="Hero">
                  <label class="custom-control-label" for="Hero">{{__('Hero')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="home_module[]" value="Category" {{ $data->homeModuleCheck('Category') ? 'checked' : '' }} class="custom-control-input" id="Category">
                  <label class="custom-control-label" for="Category">{{__('Category')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="home_module[]" value="Best service" {{ $data->homeModuleCheck('Best service') ? 'checked' : '' }} class="custom-control-input" id="Best service">
                  <label class="custom-control-label" for="Best service">{{__('Best service')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="home_module[]" value="Popular Service" {{ $data->homeModuleCheck('Popular Service') ? 'checked' : '' }} class="custom-control-input" id="Popular Service">
                  <label class="custom-control-label" for="Popular Service">{{__('Popular Service')}}</label>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="home_module[]" value="Why Choose" {{ $data->homeModuleCheck('Why Choose') ? 'checked' : '' }} class="custom-control-input" id="Why Choose">
                    <label class="custom-control-label" for="Partners">{{__('Why Choose')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="home_module[]" value="Featured Service" {{ $data->homeModuleCheck('Featured Service') ? 'checked' : '' }} class="custom-control-input" id="Featured Service">
                        <label class="custom-control-label" for="Featured Service">{{__('Featured Service')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="home_module[]" value="Partner" {{ $data->homeModuleCheck('Partner') ? 'checked' : '' }} class="custom-control-input" id="Partner">
                        <label class="custom-control-label" for="Partner">{{__('Partner')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="home_module[]" value="Testimonials" {{ $data->homeModuleCheck('Testimonials') ? 'checked' : '' }} class="custom-control-input" id="Testimonials">
                        <label class="custom-control-label" for="Testimonials">{{__('Testimonials')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="home_module[]" value="How To Works" {{ $data->homeModuleCheck('How To Works') ? 'checked' : '' }} class="custom-control-input" id="How To Works">
                        <label class="custom-control-label" for="How To Works">{{__('How To Works')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="home_module[]" value="Blogs" {{ $data->homeModuleCheck('Blogs') ? 'checked' : '' }} class="custom-control-input" id="Blogs">
                        <label class="custom-control-label" for="Blogs">{{__('Blogs')}}</label>
                    </div>
                </div>
            </div>
          </div>



            <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>

@endsection
