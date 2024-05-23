@if (count($jobs) == 0)
    <div class="container sec-p">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center border p-4">
                   <h3>@lang('No Job Found')</h3> 
                </div>
            </div>
        </div>
    </div>
@else
<div class="row g-4">
    @foreach ($jobs as $job)
        <div class="col-md-6 col-lg-4 wow animate fadeInLeft mb-5" data-wow-delay="{{ 200 * $loop->iteration }}ms" data-wow-duration="1500ms">
            <div class="single-service layout-2 layout-3">
                <div class="thumb">
                    <a href="{{ route('front.jobdetails',$job->job_slug) }}"><img src="{{ asset('assets/images/'.$job->image) }}" alt=""></a>
                    <div class="tag">
                        <a href="{{ route('front.jobdetails',$job->job_slug) }}">{{ $job->category->title ?? 'None' }}</a>
                    </div>
                    <div class="wish">
                        @if ($job->is_job_online == 1)
                        <a href="javascript:;">@lang('Online')</a>
                        @else
                        <a href="javascript:;"> <i class="fas fa-map-marker"></i> {{ $job->country->name }}</a> 
                        @endif
                        
                    </div>

                </div>
                <div class="single-inner">
                    <div class="author-info">
                        <div class="author-thumb">
                            <img src="{{ asset('assets/images/'. $job->buyer->photo) }}" alt="">
                        </div>
                        <div class="author-content">
                            <span>{{ $job->buyer->name }}</span>
                            
                        </div>
                    </div>
                    <h4><a href="{{ route('front.jobdetails',$job->job_slug) }}">{{ $job->job_title }}</a></h4>
                    <div class="started">
                        <a href="{{ route('front.jobdetails',$job->job_slug) }}">@lang('View Details')<span><i class="bi bi-arrow-right"></i></span></a>
                        <span><small>{{ $defaultCurrency->sign }}</small> {{rootAmount($job->budget) }} </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    
</div>
{{ $jobs->links('vendor.pagination.custom') }}

@endif