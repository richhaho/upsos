@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="d-sm-flex align-items-center justify-content-between py-3">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Section Heading') }}</h5>
    <ol class="breadcrumb py-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">{{ __('Home Page Manage') }}</a></li>
    </ol>
    </div>
</div>

    <div class="card mb-4 mt-3">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Section Heading') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{route('admin.ps.update')}}" method="POST" enctype="multipart/form-data">

            @include('includes.admin.form-both')

            {{ csrf_field() }}

            <div class="form-group">
              <label for="category-title">{{ __('Category Title') }} *</label>
              <input type="text" class="form-control" id="category-title" name="category_title"  placeholder="{{ __('Category Title') }}" value="{{ $data->category_title }}" required>
            </div>

            <div class="form-group">
              <label for="category-subtitle">{{ __('Category Subtitle') }} *</label>
              <textarea name="category_subtitle" id="category-subtitle" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Category Subtitle') }}" required>{{ $data->category_subtitle }} </textarea>
            </div>

            <div class="form-group">
              <label for="best-service-title">{{ __('Best Service Title') }} *</label>
              <input type="text" class="form-control" id="best-service-title" name="best_service_title"  placeholder="{{ __('Best Service Title') }}" value="{{ $data->best_service_title }}" required>
            </div>

            <div class="form-group">
              <label for="best-service-subtitle">{{ __('Best Service Text') }} *</label>
              <textarea name="best_service_text" id="best-service-subtitle" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Best Service Text') }}" required>{{ $data->best_service_text }} </textarea>
            </div>

            <div class="form-group">
              <label for="popular-service-title">{{ __('Popular Service Title') }} *</label>
              <input type="text" class="form-control" id="popular-service-title" name="popular_service_title"  placeholder="{{ __('Popular Service Title') }}" value="{{ $data->popular_service_title }}" required>
            </div>

            <div class="form-group">
              <label for="popular-service-subtitle">{{ __('Popular Service Text') }} *</label>
              <textarea name="popular_service_text" id="popular-service-subtitle" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Popular Service Text') }}" required>{{ $data->popular_service_text }} </textarea>
            </div>

            <div class="form-group">
              <label for="choose-title">{{ __('Why Choose Us Title') }} *</label>
              <input type="text" class="form-control" id="choose-title" name="choose_us_title"  placeholder="{{ __('Why Choose Us') }}" value="{{ $data->choose_us_title }}" required>
            </div>

            <div class="form-group">
              <label for="choose-us-subtitle">{{ __('Why Choose Us Text') }} *</label>
              <textarea name="choose_us_text" id="choose-us-subtitle" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Choose Us Text') }}" required>{{ $data->choose_us_text }} </textarea>
            </div>

            <div class="form-group">
              <label for="featured-title">{{ __('Featured Section Title') }} *</label>
              <input type="text" class="form-control" id="featured-title" name="featured_title"  placeholder="{{ __('Featured Section Title') }}" value="{{ $data->featured_title }}" required>
            </div>

            <div class="form-group">
              <label for="featured-text">{{ __('Featured Section Subtitle') }} *</label>
              <textarea name="featured_text" id="featured-text" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Featured Section Subtitle') }}" required>{{ $data->featured_text }} </textarea>
            </div>

            <div class="form-group">
              <label for="partner-title">{{ __('Partner Title') }} *</label>
              <input type="text" class="form-control" id="partner-title" name="partner_title"  placeholder="{{ __('Partner Title') }}" value="{{ $data->partner_title }}" required>
            </div>

            <div class="form-group">
              <label for="partner-text">{{ __('Partner Subtitle') }} *</label>
              <textarea name="partner_text" id="partner-text" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Partner Subtitle') }}" required>{{ $data->partner_text }} </textarea>
            </div>

            <div class="form-group">
              <label for="testimonial-title">{{ __('Testimonial Title') }} *</label>
              <input type="text" class="form-control" id="testimonial-title" name="testimonial_title"  placeholder="{{ __('Testimonial Title') }}" value="{{ $data->testimonial_title }}" required>
            </div>

            <div class="form-group">
              <label for="testimonial-text">{{ __('Testimonial Subtitle') }} *</label>
              <textarea name="testimonial_text" id="testimonial-text" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Testimonial Subtitle') }}" required>{{ $data->testimonial_text }} </textarea>
            </div>

            <div class="form-group">
              <label for="blog-title">{{ __('Blog Title') }} *</label>
              <input type="text" class="form-control" id="blog-title" name="blog_title"  placeholder="{{ __('Blog Title') }}" value="{{ $data->blog_title }}" required>
            </div>

            <div class="form-group">
              <label for="blog-text">{{ __('Blog Subtitle') }} *</label>
              <textarea name="blog_text" id="blog-text" cols="30" rows="5" class="form-control summernote" placeholder="{{ __('Blog Subtitle') }}" required>{{ $data->blog_text }} </textarea>
            </div>

            <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>
@endsection
