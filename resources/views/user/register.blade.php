@extends('layouts.front')

@push('css')

@endpush

@section('content')

<!-- Start breadcrumbs section -->
<section class="breadcrumbs" style="background-image: url({{ asset('assets/images/'.$gs->breadcumb_banner) }})">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <h2>@lang('Sign Up')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Sign Up')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

<!-- Start login-area section -->
<section id="down" class="login-area sec-p">
    <div class="container">
        <div class="login-form">
            <h3>@lang('Sign Up')</h3>
            <span>@lang('Do you already have an account?') <a href="{{ route('user.login') }}">@lang('Log in here')</a></span>
            <form id="registerform" class="row gy-3" action="{{ route('user.register.submit') }}" method="POST">
                @includeIf('includes.user.form-both')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="fname">@lang('Name') <span style="color:red">*</span>
                            <input type="text" name="name" id="fname" placeholder="Name">
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="lname">@lang('User Name') <span style="color:red">*</span>
                            <input type="text" name="username" id="lname" placeholder="User Name">
                        </label>
                    </div>
                    <div class="col-12">
                        <label for="email">@lang('Email') <span style="color:red">*</span>
                            <input type="email" name="email" id="email" placeholder="Your Email Here">
                        </label>
                       
                    </div>
                    <div class="col-md-6">
                        <label for="country" class="form-label">@lang('Seller Or Buyer')
                        <select name="is_seller" id="is_seller" class="form-control">
                               <option value="0">@lang('Buyer')</option>
                            <option value="1">@lang('Seller')</option>
                        </select></label>
                     </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">@lang('Country') <span style="color:red">*</span>
                        <div class="input-group">
                            <select class="input-group-text m-0 form-label" name="ucountry" id="ucountry" for="ucountry" required>
							<option disabled selected value="" >- Select Country -</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </select></label>
                        </div>
                    </div>

					<div class="col-md-6 form-label">
                        <label for="lname">@lang('State/City') 
                            <input type="text" name="city" id="city" placeholder="State/City">
                        </label>
                    </div>


                    <div class="col-md-6">
                        
                        <div class="input-group">
						<label for="phone" >@lang('Your Phone') </label>
                            <select class="input-group-text m-0 form-label" name="uphone_code" id="uphone_code" for="uphone_code">
							
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->phone_code }}">{{ $country->phone_code }}</option>
                                @endforeach

               
                            </select>
							 <input type="text" name="phone" id="phone" class="form-control">
                            
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-5">
                        <label for="password">@lang('Password') <span style="color:red">*</span>
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                            <input type="password" name="password" id="password" placeholder="Type Your Password">
                        </label>
                    </div>

                    <div class="col-md-6 mt-5">
                        <label for="confirm-password">@lang('Confirm Password') <span style="color:red">*</span>
                            
                            <input type="password" name="password_confirmation" id="confirm-password" placeholder="Type Your Password">
                        </label>
                    </div>
                </div>
                <div class="terms-forgot d-flex justify-content-between">
                    <p><input type="checkbox" checked name="agree">@lang('I agree to the') <a href="#">@lang('Terms & Policy')</a></p>
                    <a href="{{ route('user.forgot') }}" class="text--base">@lang('Forget Password')</a>
                </div>
				
				{!! RecaptchaV3::field('register') !!}
				
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-spay w-100 py-3 btn-contact">@lang('Sign Up') <div class="spinner-border formSpin" role="status"></div></button>
                </div>
            </form>
           
        </div>
    </div>
</section>
<!-- End login-area section -->

<!-- End login-area section -->
@endsection

@push('js')

@endpush