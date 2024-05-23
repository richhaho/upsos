@extends('layouts.user')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.7.1/dist/style.css">
@endpush

@section('contents')

<div class="breadcrumb-area">
  <h3 class="title">@lang('Profile') - <a href="{{  url('resume') }}/{{ $user->username }}" target="_blank" >@lang('Click to See Your Public Profile')</a></h3>

  <ul class="breadcrumb">
       <li>
@if($user->is_seller == 1)
          <a href="{{ auth::user()->is_seller == 1 ? route('user.dashboard') : route('buyer.dashboard') }}">@lang('Seller')</a>
@else
<a href="{{ auth::user()->is_seller == 1 ? route('user.dashboard') : route('buyer.dashboard') }}">@lang('Buyer')</a>
 @endif
      </li>
      <li>
        @lang('User Profile')
      </li>
  </ul>
</div>
<div class="dashboard--content-item">
    @php
    $tags = [];
    foreach($user->tags as $tag){
        $tags[] = [
                    "key"=>$tag->slug,
                    "value"=>$tag->slug
                    ];
    }
    @endphp
  <form id="request-form" action="{{ auth::user()->is_seller == 1 ? route('user.profile.update') : route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="profile--card">
      <div class="user--profile mb-5">
          <div class="thumb">


@if(auth()->user()->is_provider == 1)
                        <img src="{{ auth()->user()->is_provider ? asset(auth()->user()->photo):asset('assets/images/avatars/avatar.png')}}" alt="No Image">
                        @else
                        <img src="{{ auth()->user()->photo ? asset('assets/images/avatars/'.auth()->user()->photo) : asset('assets/images/avatars/avatar.png') }}" alt="clients">
                        @endif


          </div>
          <div class="remove-thumb">
              <i class="fas fa-times"></i>
          </div>
          <div class="content">
              <div>
                  <h3 class="title">
                      {{ auth()->user()->name }}
                  </h3>
                  <a href="#0" class="text--base">
                      {{ auth()->user()->email }}
                  </a>
              </div>
              <div class="mt-4">
                  <label class="btn btn-sm btn--base text--dark">
                      @lang('Update Profile Picture')
                      <input type="file" id="profile-image-upload" name="photo" hidden>
                  </label>
              </div>
          </div>
      </div>

          <div class="row gy-4">
              <div class="col-sm-6 col-xxl-4">
                  <label for="name" class="form-label">@lang('Name') <span style="color:red">*</span></label>
                  <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
              </div>

			   <div class="col-sm-6 col-xxl-4">
                  <label for="name" class="form-label">@lang('UserName') <span style="color:red">*</span></label>
                  <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" required>
              </div>

              <div class="col-sm-6 col-xxl-4">
                  <label for="email" class="form-label">@lang('Email Address') <span style="color:red">*</span></label>
                  <input type="email" id="email" class="form-control"
                      value="{{ $user->email }}" readonly>
              </div>

<div class="col-sm-6 col-xxl-4">
                  <label for="country" class="form-label">@lang('Phone Number')</label>
<div class="input-group">
<select class="input-group-text m-0 form-label uphone-code" name="uphone_code" id="ucountry" for="uphone_code" required>
							<option disabled selected value="" >Code</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->phone_code }}" {{$user->uphone_code == $country->phone_code  ? 'selected' : ''}}>{{ $country->phone_code }}</option>
                                @endforeach
								<input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                            </select></label></div>	 </div>

<div class="col-sm-6 col-xxl-4">
                  <label for="country" class="form-label">@lang('Country') <span style="color:red">*</span></label>

<select class="input-group-text m-0 form-label" name="ucountry" id="ucountry" for="ucountry" required>
							<option disabled selected value="" >- Select Country -</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->name }}" {{$user->ucountry == $country->name  ? 'selected' : ''}}>{{ $country->name }}</option>
                                @endforeach
                            </select></label></div>


              <div class="col-sm-6 col-xxl-4">
                  <label for="name" class="form-label">@lang('Zip')</label>
                  <input type="text" name="zip" class="form-control" value="{{ $user->zip }}">
              </div>

              <div class="col-sm-6 col-xxl-4">
                <label for="city" class="form-label">@lang('City')</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ $user->city }}">
              </div>

              <div class="col-sm-6 col-xxl-4">
                <label for="last-name" class="form-label">@lang('Fax')</label>
                <input type="text" id="last-name" name="fax" class="form-control" value="{{ $user->fax }}">
              </div>

              <div class="col-sm-6 col-xxl-4">
                <label for="address" class="form-label">@lang('Address')</label>
                <input type="text" id="address"  name="address" class="form-control" value="{{ $user->address }}">
              </div>


              <div class="col-sm-6 col-xxl-4">
<label for="aboutme" class="form-label">@lang('About Me')</label>

 <textarea rows="7" cols="54" id="aboutme" name="aboutme" style="resize:yes, " value="{{ $user->aboutme }}">{{ $user->aboutme }}</textarea>

              </div>

              <div class="col-sm-6 col-xxl-4" id="tags">
                  <div>
                      <input type="text" value="" id="tags_json" name="tags_json" hidden>
                      <label for="last-name" class="form-label">@lang('Tags')</label>
                      <tags-input element-id="tags"
                                  v-model="selectedTags"
                                  :existing-tags="avaiableTags"
                                  :typeahead="true"
                                    placeholder="Type and press enter"></tags-input>
                  </div>
              </div>

              <div class="col-sm-12">
                  <div class="text-end">
                      <button type="submit" class="cmn--btn">@lang('Update Profile')</button>
                  </div>
              </div>
          </div>
        </div>
      </form>
</div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.7.1/dist/voerro-vue-tagsinput.js"></script>

    <script>
        new Vue({
            el: '#tags',
            components: { "tags-input": VoerroTagsInput },
            data: {
                selectedTags: {!! json_encode($tags) !!},
                avaiableTags: {!! json_encode($allTags) !!},
            },
            watch:{
                selectedTags(val){
                    $("#tags_json").val(JSON.stringify(val));
                }
            }
        });
    </script>


    <script type="text/javascript">
    "use strict";
  var prevImg = $('.user--profile .thumb').html();
  function proPicURL(input) {
      if (input.files && input.files[0]) {
          var uploadedFile = new FileReader();
          uploadedFile.onload = function (e) {
              var preview = $('.user--profile').find('.thumb');
              preview.html(`<img src="${e.target.result}" alt="user">`);
              preview.addClass('image-loaded');
              preview.hide();
              preview.fadeIn(650);
              $(".image-view").hide();
              $(".remove-thumb").show();
          }
          uploadedFile.readAsDataURL(input.files[0]);
      }
  }
  $("#profile-image-upload").on('change', function () {
      proPicURL(this);
  });
  $(".remove-thumb").on('click', function () {
      $(".user--profile .thumb").html(prevImg);
      $(".user--profile .thumb").removeClass('image-loaded');
      $(".image-view").show();
      $(this).hide();
  })
</script>
@endpush
