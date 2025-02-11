@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="d-sm-flex align-items-center justify-content-between py-3">
    <h5 class=" mb-0 text-gray-800 pl-3">{{ __('Edit Page') }} <a class="btn btn-primary btn-rounded btn-sm" href="{{route('admin.page.index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h5>
    <ol class="breadcrumb py-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">{{ __('Menu Page Settings') }}</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.page.index')}}">{{ __('Other Pages') }}</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.page.create',$data->id)}}">{{ __('Edit Page') }}</a></li>
    </ol>
    </div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-md-10">
    <!-- Form Basic -->
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit Page Form') }}</h6>
      </div>

      <div class="card-body">
        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
        <form class="geniusform" action="{{route('admin.page.update',$data->id)}}" method="POST" enctype="multipart/form-data">

            @include('includes.admin.form-both')

            {{ csrf_field() }}


            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control" id="title" name="title" value="{{$data->title}}"  placeholder="{{ __('Title') }}" value="" required>
            </div>

            <div class="form-group">
                <label for="inp-slug">{{ __('Slug') }}</label>
                <input type="text" class="form-control" id="inp-slug" value="{{$data->slug}}" name="slug"  placeholder="{{ __('Enter Slug') }}" value="" required>
            </div>

            <div class="form-group">
              <label for="details">{{ __('Description') }}</label>
              <textarea class="form-control summernote"  id="details" name="details" required rows="3" placeholder="{{__('Description')}}">{{$data->details}}</textarea>
          </div>

            <button type="submit" id="submit-btn" class="btn btn-primary w-100">{{ __('Submit') }}</button>

        </form>
      </div>
    </div>

    <!-- Form Sizing -->

    <!-- Horizontal Form -->

  </div>

</div>
<!--Row-->

@endsection
@section('scripts')
<script type="text/javascript">
  'use strict';
  
 $('#meta_tag').tagify();

 $(document).on('click','#seo',function(){
            if($(this).is(':checked')){
              $('.showbox').removeClass('d-none');
            }else{
              $('.showbox').addClass('d-none');
            }
  });


  $(document).ready(function(){
        if($('#seo').is(':checked')){
           $('.showbox').removeClass('d-none');
            }else{
                $('.showbox').addClass('d-none');
            }
    });


</script>
@endsection
