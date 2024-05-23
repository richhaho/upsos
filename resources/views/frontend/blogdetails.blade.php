@extends('layouts.front')

@push('css')
    
@endpush

@section('content')
    <!-- Banner -->
     <!-- Start breadcrumbs section -->
	 <section class="breadcrumbs" style="background-image: url({{ asset('assets/images/'.$gs->breadcumb_banner) }})">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="breadcrumb-wrapper">
						<h2>@lang('Blog Details')</h2>
						<span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('Blog Details')</span>
						<div class="arrow-down">
							<a href="#down"><i class="bi bi-chevron-down"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- End breadcrumbs section -->

    <!-- Start blog-details-area section -->
    <section id="down" class="blog-details-area sec-m-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-content">
                        <h3>{{ $data->title }}</h3>
                        <div class="date-cmnt">
                            <a href="#"><i class="bi bi-calendar-week"></i>{{ $data->created_at->format('j F ,Y') }}</a>
                            <a href="#"><i class="bi bi-person-circle"></i>@lang('Posted by Admin')</a>
                           
                        </div>
                        <div class="thumbnail">
                            <img src="{{ $data->photo ? asset('assets/images/'.$data->photo): asset('assets/images/sample.jpg') }}" alt="">
                        </div>

						<p>
                            @php
                                echo $data->details;
                            @endphp
                        </p>
                        
                        <div class="single-post-tag-social">
                            <div class="tags">
                                <span>@lang('Post Tag'):</span>
								@foreach (array_unique(explode(',',$data->tags)) as $tag)
								<a href="{{ route('front.blogtags',$tag) }}">{{ $tag }} {{ $loop->last ? '.':','  }}</a>
								@endforeach
                            </div>

                            <ul class="post-share a2a_kit a2a_kit_size_32 a2a_default_style">
                                <li><a class="a2a_dd" href="https://www.addtoany.com/share"></a></li>
                                <li><a class="a2a_button_facebook"></a></li>
                                <li><a class="a2a_button_twitter"></a></li>
                                <li><a class="a2a_button_email"></a></li>
                            </ul>
							<script async src="https://static.addtoany.com/menu/page.js"></script>
                        </div>
                    </div>
						<div class="sec-m" id="disqus_thread"></div>
                </div>
				<div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="widget-search">
                            <form action="{{ route('front.blogsearch') }}" method="get">
								<input type="text" name="search" placeholder="@lang('Search Here')" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}" required>
								<button type="submit" name="submit"><i class="bi bi-search"></i></button>
							</form>
                        </div>
                        <div class="widget-sidebar">
                            <h4>@lang('Recent Posts')</h4>
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
                        <div class="widget-sidebar">
                            <h4>@lang('Category')</h4>
                            <ul class="category-list">
                            @foreach ($bcats as $data)
                            	<li><a href="{{ route('front.blogcategory',$data->slug) }}">{{ $data->name }}<i class="bi bi-chevron-right"></i></a></li>
                            @endforeach
                            </ul>
                        </div>
                        <div class="widget-sidebar">
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
    <!-- End blog-details-area section -->
		
@endsection

@push('js')
@if ($gs->is_disqus == 1)
<script type="text/javascript">
    "use strict";
	(function () {
		var d = document,
		s = d.createElement('script');
		s.src = 'https://{{ $gs->disqus}}.disqus.com/embed.js';
		s.setAttribute('data-timestamp', +new Date());
		(d.head || d.body).appendChild(s);
	})();
</script>
<noscript>{{__('Please enable JavaScript to view the')}} <a href="https://disqus.com/?ref_noscript">{{__('comments powered by Disqus.')}}</a></noscript>
@endif
@endpush