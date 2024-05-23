@extends('layouts.front')

@push('css')
    
@endpush

@section('content')
	<!-- Banner -->
    <section class="breadcrumbs" style="background-image: url({{ asset('assets/images/'.$gs->breadcumb_banner) }})">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <h2>@lang('Forgot Password')</h2>
                        <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Forgot Password')</span>
                        <div class="arrow-down">
                            <a href="#down"><i class="bi bi-chevron-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<!-- Banner -->
    <!-- Account -->
    <section class="account-section pt-100 pb-100 sec-m-top">
        <div class="container">
            <div class="account-wrapper bg--body">
                <div class="section-title mb-3">
                    <h3 class="title">@lang('Forgot Password')</h3>
                </div>
                <form class="account-form row gy-3 gx-4 align-items-center" id="forgotform" action="{{ route('user.forgot.submit') }}" method="POST">
                    @includeIf('includes.user.form-both')
                    @csrf
                    <div class="col-sm-12">
                        <label for="email" class="form-label">@lang('Your Email')</label>
                        <input type="text" id="email" name="email" class="form-control form--control">
                    </div>
                    <div class="col-sm-12 ">
                            <button type="submit" class="btn  btn-spay me-3 btn-contact">
                                @lang('Submit') <div class="spinner-border formSpin" role="status"></div>
                            </button>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-2 terms-forgot">
                            <a href="{{ route('user.login') }}" class="text--base mt-1">@lang('Login Now?')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Account -->
@endsection

@push('js')
    
@endpush