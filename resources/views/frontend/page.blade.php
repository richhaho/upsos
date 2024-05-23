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
                    <h2>{{ $page->title }}</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>{{ $page->title }}</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->


<!-- Start blog-sidebar-area section -->
<section id="down" class="blog-sidebar-area sec-m-top sec-m">
    <div class="container">
        @php
			echo $page->details;
		@endphp
    </div>
</section>
<!-- End blog-sidebar-area section -->


@endsection

@push('js')

@endpush
