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
                    <h2>@lang('Log In')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Log In')</span>
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
            <h3>@lang('Log In')</h3>
            <span>@lang('If you new member, please') <a href="{{ route('user.register') }}"><button type="submit" class="sign-up">@lang('Sign Up')</button> </a></span>
            <form id="loginform" action="{{ route('user.login.submit') }}" method="POST">
                @includeIf('includes.user.form-both')
                @csrf
                <label for="email">@lang('Email')*
                    <input type="email" name="email" id="username" class="form-control" value="">
                </label>
                <label for="password">@lang('Password')*
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <input type="password" name="password" id="password" value="" class="form-control">
                </label>
                <div class="terms-forgot">
                    
                    <a href="{{route('user.forgot')}}">@lang('Forgot Your Password')</a>
                </div>
                <button class="btn btn-spay w-100 py-3 btn-contact" type="submit">{{ __('Submit ') }}<div class="spinner-border formSpin" role="status"></div></button>
            </form>
            
            @if($socialsetting->f_check == 1 || $socialsetting->g_check == 1)
            <div class="other-signup">
                <h4>@lang('or Sign up WITH')</h4>
                <div class="others-account">
                    @if($socialsetting->g_check == 1)
                    <a href="{{ route('social-provider','google') }}" class="google"><i class="fab fa-google"></i>@lang('Signup with google')</a>
                    @endif
                    @if($socialsetting->f_check == 1)
                    <a href="{{ route('social-provider','facebook') }}" class="facebook"><i class="fab fa-facebook-f"></i>@lang('Sign up with facebook')</a>
                    @endif
                </div>
            </div>
            @endif

            
            
        </div>
    </div>
</section>
<!-- End login-area section -->
@endsection

@push('js')

@endpush









