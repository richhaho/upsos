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
                    <h2>@lang('Contact Us')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Contact Us')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

<!-- Start contact-us-area section -->
<section id="down" class="contact-us-area sec-m">
    <div class="container">
        <div class="contact-info">
            <!-- <div class="row gy-4 align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="info">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="desc">
                            <h4>@lang('Location')</h4>
                            <p>{{ strip_tags($ps->street) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="info">
                        <div class="icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="desc">
                            <h4>@lang('Phone')</h4>
                            <a href="tel:01761111456">@lang('phone'): {{ $ps->phone }} </a>
                            <a href="tel:01761111555">@lang('fax'): {{ $ps->fax }} </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="info">
                        <div class="icon">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div class="desc">
                            <h4>@lang('Message Us')</h4>
                            <a href="mailto:{{ $ps->contact_email }}">{{ $ps->contact_email }}</a>
                            <a href="mailto:{{ $ps->email }}">{{ $ps->email }}</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="contact-form">

            <h2>{{ strip_tags($ps->side_title) }}</h2>
            <p>{{ strip_tags($ps->side_text) }}</p>
            <form action="{{route('front.contact.submit')}}" method="post" id="contactform">
                @includeIf('includes.user.form-both')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <input type="hidden" name="name" value="{{ auth()->user()->name }}" placeholder="Your Name:" required>
                    </div>
                    <div class="col-lg-6">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}" placeholder="Your Email:" required>
                    </div>
                    <div class="col-12">
                        <input type="text" name="subject" placeholder="Subject" required>
                        <textarea name="message" cols="30" rows="10" required placeholder="Write Message :"></textarea>

                    </div>
                    <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                    <div class="col-sm-12">
                        <button class="btn btn-spay w-100 py-3 btn-contact" type="submit">
                            @lang('Send Message')
                            <div class="spinner-border formSpin" role="status"></div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- End contact-us-area section -->


@endsection

@push('js')

@endpush
