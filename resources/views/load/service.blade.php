@if (count($services) == 0)
    <div class="container sec-p">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center border p-4">
                   <h3>@lang('No Service Found')</h3> 
                </div>
            </div>
        </div>
    </div>
@else
<div class="row g-4">
    @foreach ($services as $service)
        <div class="col-md-6 col-lg-4 wow animate fadeInLeft mb-5" data-wow-delay="{{ 200 * $loop->iteration }}ms" data-wow-duration="1500ms">
            <div class="single-service layout-2 layout-3">
                <div class="thumb">
                    <a href="{{ route('front.servicedetails',$service->slug) }}"><img src="{{ asset('assets/images/'.$service->image) }}" alt=""></a>
                    <div class="tag">
                        <a href="{{ route('front.servicedetails',$service->slug) }}">{{ $service->category->title }}</a>
                    </div>
                    <div class="wish">
                        @if ($service->is_service_online == 1)
                        <a href="javascript:;">@lang('Online')</a>
                        @else
                        <a href="javascript:;"> <i class="fas fa-map-marker"></i> {{ $service->country->name }}</a> 
                        @endif
                        
                    </div>

                </div>
                <div class="single-inner">
                    <div class="author-info">
                        <div class="author-thumb">
                          


 @if($service->seller->is_provider == 1)
                       <img src="{{ $service->seller->photo ? asset($service->seller->photo):asset('assets/images/avatars/avatar.png')}}" alt="">
                        @else
                          <img src="{{ $service->seller->photo ? asset('assets/images/avatars/'.$service->seller->photo):asset('assets/images/avatars/avatar.png')}}" alt="">
                        @endif




                        </div>
                        <div class="author-content">
                            <span><a href="{{  url('resume') }}/{{ $service->seller->username }}">{{ $service->seller->name }}</a></span>
                            <div class="ratting">
                                <ul class="stars">
                                    <strong>
                                        @php
                                            $avg=$service->reviews->avg('rating');
                                            @endphp
                                            @if ($avg == null)
                                                @for($i = 0; $i < 5; $i++)
                                                <i class="fas fa-star"></i>
                                                @endfor
                                                
                                            @else
                                            @for ($i = 0; $i < 5; $i++)
                                                @if (floor($avg - $i) >= 1)
                                                    {{--Full Start--}}
                                                    <i class="fa fa-star filled"></i>
                                                @elseif ($avg - $i > 0)
                                                    {{--Half Start--}}
                                                    <i class="fa fa-star-half-alt filled"> </i>
                                                @else
                                                    {{--Empty Start--}}
                                                    <i class="fa fa-star"> </i>
                                                @endif
                                            @endfor
                                            @endif
                                        <b>({{ ratings($service->id) != null ? ratings($service->id) : 0 }}/5)</b>
                                    </strong>
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                    <h4><a href="{{ route('front.servicedetails',$service->slug) }}">{{ $service->title }}</a></h4>
                    <div class="started">
                        <a href="{{ route('front.servicedetails',$service->slug) }}">@lang('View Details')<span><i class="bi bi-arrow-right"></i></span></a>
                        <span><small>{{ $defaultCurrency->sign }}</small> {{rootAmount(servicePrice($service->id)) }} </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    
</div>
{{ $services->links('vendor.pagination.custom') }}

@endif