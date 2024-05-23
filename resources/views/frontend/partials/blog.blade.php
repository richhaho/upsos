 <!-- Start lastest-blog-three section -->
 <section class="lastest-blog-three sec-m">
    <div class="container">
        <div class="row">
            <div class="col-12 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="sec-title layout-3">
                    <h2>{{ $ps->blog_title }}</h2>
                    <p>{{ strip_tags($ps->blog_text) }}</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($blogs as $data)
            <div class="col-md-6 col-lg-4 wow animate fadeInLeft" data-wow-delay="{{ $loop->iteration *200 }}ms" data-wow-duration="1500ms">
                <div class="single-blog layout-3">
                    <div class="blog-thumb">
                        <a href="{{ route('blog.details',$data->slug) }}"><img src="{{ asset('assets/images/'.$data->photo) }}" alt=""></a>
                        <div class="date">
                            
                            <span>{{ $data->created_at->format('j F ,Y') }}</span>
                        </div>
                    </div>
                    <div class="blog-inner">
                        <h4><a href="{{ route('blog.details',$data->slug) }}">{{ $data->title }}</a></h4>
                        <p>
                            {{ Str::limit(strip_tags($data->details), 90)  }}
                        </p>
                        <a href="{{ route('blog.details',$data->slug) }}">@lang('Read more')<span><i class="bi bi-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End lastest-blog-three section -->
