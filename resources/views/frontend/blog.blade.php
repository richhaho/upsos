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
                    <h2>@lang('All Blog')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('All Blog')</span>
                    <div class="arrow-down">
                        <a href="#down"><i class="bi bi-chevron-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumbs section -->

@if (count($blogs) == 0)
	<div class="col-12 text-center sec-m border p-4">
			<h3 class="m-0">{{__('No Blog Found')}}</h3>
	</div>
@else
<!-- Start blog-sidebar-area section -->
<section id="down" class="blog-sidebar-area sec-m-top sec-m">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-sidebar-details">
                    <div class="row g-4">
                        @foreach ($blogs as $blog)
                        <div class="col-md-6 wow animate fadeInLeft" data-wow-delay="{{ $loop->iteration * 200 }}ms" data-wow-duration="1500ms">
                            <div class="single-blog layout-2">
                                <div class="blog-thumb">
                                    <a href="{{ route('blog.details',$blog->slug) }}"><img src="{{ asset('assets/images/'.$blog->photo) }}" alt=""></a>
                                </div>
                                <div class="blog-inner">
                                    <span><i class="bi bi-calendar-week"></i>{{ $blog->created_at->format('j F ,Y') }}</span>
                                    <h4><a href="{{ route('blog.details',$blog->slug) }}">{{ $blog->title }}</a></h4>
                                    <a href="{{ route('blog.details',$blog->slug) }}">@lang('Read more')<span><i class="bi bi-arrow-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                {{ $blogs->links('vendor.pagination.custom') }}
            </div>
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <div class="widget-search wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <form action="{{ route('front.blogsearch') }}" method="get">
                            <input type="text" name="search" placeholder="@lang('Search Here')" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}" required>
                            <button type="submit" name="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                    <div class="widget-sidebar wow animate fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                        <h4>@lang('Recent Post')</h4>
                        @foreach ($recent_blogs as $rblog)
                        <div class="recent-post">
                            <div class="recent-thumb">
                                <a href="{{ route('blog.details',$rblog->slug) }}"><img src="{{ asset('assets/images/'.$rblog->photo) }}" alt=""></a>
                            </div>
                            <div class="recent-post-cnt">
                                <span>{{ $rblog->created_at->format('j F ,Y') }}</span>
                                <h5><a href="{{ route('blog.details',$rblog->slug) }}">{{ $rblog->title }}</a></h5>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="widget-sidebar wow animate fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <h4>@lang('Category')</h4>
                        <ul class="category-list">
                            @foreach ($bcats as $data)
                            <li><a href="{{ route('front.blogcategory',$data->slug) }}">{{ $data->name }}<i class="bi bi-chevron-right"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget-sidebar wow animate fadeInUp" data-wow-delay="500ms" data-wow-duration="1500ms">
                        <h4>@lang('Post Tag')</h4>
                        <ul class="post-tags">
                            @foreach ($tags as $tag)
                            @if(!empty($tag))
                            <li><a href="{{ route('front.blogtags',$tag) }}">{{ $tag }}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End blog-sidebar-area section -->
@endif

@endsection

@push('js')

@endpush
