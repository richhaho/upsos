<section class="hero-area-three" style="background-image:url({{ asset('assets/images/' . $ps->hero_photo) }})">
    <div class="container-fluid">
        <div class="hero-wrapper">
            <div class="hero-content">
                <span>{{ $ps->hero_title }}</span>
                <h1>{{ $ps->hero_subtitle }}</h1>

                <div class="find-service">
                    <div class="choose-location"><span>@lang('Choose your location to find local services')</span></div>
                    <div class="location-search d-block">
                        <div class="location-btn d-flex justify-content-center }}">
<div class="front-location-select">
<div class="front-country-select">
                            <form class="d-flex justify-content-around">
                                @csrf
                                <select id="country-select" class="nice-select loc-select mb-3">
                                    <option class="custom-option list" value="" selected>@lang(!$is_service_online ?
    'Select Country' : 'Online Services')
                                    </option>
                                    @foreach ($countries as $country)
                                    <option {{ isset ($visit->value['country']) && isset ($is_service_online) &&
        !$is_service_online &&
        $visit->value['country'] ==
        $country->id ? 'selected' :
        '' }} class="custom-option list" value="{{ $country->id}}">
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
							</div>
<div class="front-city-select">
                            <form
                                class="d-flex justify-content-around toggle-if-online-service city  {{ isset ($is_service_online) && $is_service_online ? 'd-none' : '' }}">
                                @csrf
                                <select id="city-select" class="nice-select loc-select mb-3">
                                    <option class="custom-option list" value="" data-country="" selected>
                                        Select City
                                    </option>
                                    @foreach ($cities as $city)
                                    <option {{ isset ($visit->value['city']) && $visit->value['city'] == $city->id ?
        'selected' :
        '' }}
                                        class="custom-option list" value="{{ isset ($is_service_online) &&
        $is_service_online ? '' : $city->id }}"
                                        data-country="{{ $city->country_id }}">
                                        {{ $city->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
</div>
<div class="front-area-select">
                            <form
                                class="d-flex justify-content-around toggle-if-online-service area  {{ isset ($is_service_online) && $is_service_online ? 'd-none' : '' }}">
                                @csrf
                                <select id="area-select" class="nice-select loc-select mb-3">
                                    <option class="custom-option list" value="" selected>Select Area
                                    </option>
                                    @foreach ($areas as $area)
                                    <option {{ isset ($visit->value['area']) && $visit->value['area'] == $area->id
        ? 'selected' :
        '' }}
                                        class="custom-option list" value="{{ $area->id }}" data-city="">
                                        {{ $area->title }}</option>
                                    @endforeach
                                </select>
                            </form>
</div></div>

                        </div>
                        <div class="location-form">
                            <form action="{{ route('front.servicesearch') }}" method="get">
                                <input type="hidden" name="country" />
                                <input type="hidden" name="city" />
                                <input type="hidden" name="area" />
                                <input type="text" name="search" placeholder="Find Your Services Here" value=""
                                    required>
                                <button type="submit"><i class="bi bi-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="suggest">
                        <!-- <span>@lang('Suggest For You'):</span>
                        <ul class="suggest-list">
                            @foreach ($categories->take(4) as $data)
                                <li><a
                                        href="{{ route('front.servicecategory', $data->slug) }}">{{ $data->title }}</a>
                                </li>
                            @endforeach
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>