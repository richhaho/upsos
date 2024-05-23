@extends('layouts.admin')

@section('content')

<div class="card">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Add New SubCategory') }} <a class="btn btn-primary btn-rounded btn-sm" href="{{route('admin.subcategories.index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h5>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.subcategories.create') }}">{{ __('Add New SubCategory') }}</a></li>
    </ol>
  </div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-md-10">
    <!-- Form Basic -->
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Add New Category Form') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{route('admin.subcategories.store')}}" method="POST" enctype="multipart/form-data">

          @include('includes.admin.form-both')

          {{ csrf_field() }}

          <div class="form-group">
            <label for="inp-name">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="inp-name" name="title" placeholder="{{ __('Enter Name') }}" value="" required>
          </div>

          <div class="form-group">
            <label for="inp-slug">{{ __('Slug') }}</label>
            <input type="text" class="form-control" id="inp-slug" name="slug" placeholder="{{ __('Enter Slug') }}" value="" required>
          </div>

          <div class="form-group">
            <label for="inp-name">{{ __('Category') }}</label>
            <select class="form-control mb-3" name="category_id">
              <option value="" selected>{{__('Select Category')}}</option>
              @foreach ($categories as $key=>$category)
              <option value="{{$category->id.','.$category->type}}">{{$category->title}}</option>
              @endforeach
            </select>
          </div>


          <div class="form-group">
            <label>{{ __('Set Picture') }} </label>
            <div class="wrapper-image-preview">
              <div class="box">
                <div class="back-preview-image"
                  style="background-image: url({{ asset('assets/images/placeholder.jpg') }});"></div>
                <div class="upload-options">
                  <label class="img-upload-label" for="img-upload"> <i class="fas fa-camera"></i> {{ __('Upload
                    Picture') }} </label>
                  <input id="img-upload" type="file" class="image-upload" name="image" accept="image/*">
                </div>
              </div>
            </div>
          </div>

          <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>
  </div>

</div>
@endsection