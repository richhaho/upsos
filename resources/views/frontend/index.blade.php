@extends('layouts.front')

@push('css')
@endpush

@section('content')
<!-- Start hero-area-three section -->
@if (in_array('Hero', $home_modules))
@include('frontend.partials.hero')
@endif

<!-- End hero-area-three section -->

@if (in_array('Category', $home_modules))
@include('frontend.partials.category')
@endif

@if (in_array('Best service', $home_modules))
@include('frontend.partials.best-service')
@endif


@if (in_array('Popular Service', $home_modules))
@include('frontend.partials.popular_service')
@endif

@if (in_array('Why Choose', $home_modules))
@include('frontend.partials.why_choose_us')
@endif

@if (in_array('Featured Service', $home_modules))
@include('frontend.partials.featured_service')
@endif

@if (in_array('Partner', $home_modules))
@include('frontend.partials.partner')
@endif

@if (in_array('Testimonials', $home_modules))
@include('frontend.partials.testimonial')
@endif

@if (in_array('How To Works', $home_modules))
@include('frontend.partials.how_it_works')
@endif


@if (in_array('Blogs', $home_modules))
@include('frontend.partials.blog')
@endif
@endsection

@push('js')
<script>
    $(document).ready(function () {
        var storedCountry = localStorage.getItem('selectedCountry');
        var storedCity = localStorage.getItem('selectedCity');
        var storedArea = localStorage.getItem('selectedArea');

        var hiddenCountry = $('input[name="country"]').attr('type', 'hidden');
        var hiddenCity = $('input[name="city"]').attr('type', 'hidden');
        var hiddenArea = $('input[name="area"]').attr('type', 'hidden');
        var isOnlineServices = "{{$is_service_online}}";

        if (storedCountry && !isOnlineServices) {
            $('#country-select').val(storedCountry);
            updateCities(storedCountry, storedCity)
                .then(function (selectedCity) {
                    if (selectedCity) {
                        $('#city-select').val(selectedCity);
                        return updateAreas(selectedCity, storedArea);
                    }
                })
                .then(function (selectedArea) {
                    if (selectedArea) {
                        $('#area-select').val(selectedArea);
                    }
                });
        }

        if (!isOnlineServices) {
            if (storedCountry && hiddenCountry) {
                hiddenCountry.val(storedCountry);
            }
            if (storedCity && hiddenCity) {
                hiddenCity.val(storedCity);
            }
            if (storedArea && hiddenArea) {
                hiddenArea.val(storedArea);
            }
        }


        $(document).on('change', '#country-select',function () {
            var countryId = $(this).val();

            updateCities(countryId, '')
                .then(function (selectedCity) {
                    localStorage.setItem('selectedCountry', countryId);
                    localStorage.removeItem('selectedCity');
                    localStorage.removeItem('selectedArea');
                    if (selectedCity) {
                        $('#city-select').val(selectedCity);
                        return updateAreas(selectedCity, '');
                    }
                    if (hiddenCity) {
                        hiddenCity.val(selectedCity);
                    }
                })
                .then(function (selectedArea) {
                    if (selectedArea) {
                        $('#area-select').val(selectedArea);
                    }
                    if (hiddenArea) {
                        hiddenArea.val(selectedArea);
                    }
                });

            if (hiddenCountry) {
                hiddenCountry.val(countryId);
            }

            if (!countryId && isOnlineServices) {
                $('.toggle-if-online-service').addClass('d-none');
            } else {
                $('.toggle-if-online-service.city').removeClass('d-none');
            }
        });

        $(document).on('change', '#city-select', function () {
            var countryId = $('#country-select').val();
            var cityId = $(this).val();
            updateAreas(cityId, '')
                .then(function (selectedArea) {
                    localStorage.setItem('selectedCity', cityId);
                    if (selectedArea) {
                        $('#area-select').val(selectedArea);
                    }
                    if (hiddenArea) {
                        hiddenArea.val(selectedArea);
                    }
                });
            if (hiddenCity) {
                hiddenCity.val(cityId);
            }

            $('.toggle-if-online-service.area').removeClass('d-none');
        });

        $(document).on('change', '#area-select', function () {
            var areaId = $(this).val();
            localStorage.setItem('selectedArea', areaId);
            if (hiddenArea) {
                hiddenArea.val(areaId);
            }
        });

        function updateCities(countryId, selectedCity) {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: '/cities',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        country_id: countryId
                    },
                    success: function (data) {
                        if (data.length === 0) {
                            $('#city-select').html(
                                '<option class="custom-option list" value="" data-country="" selected disabled>Select City</option>'
                            );
                            resolve('');
                        } else {
                            var options =
                                '<option class="custom-option list" value="" data-country="" selected disabled>Select City</option>';
                            $.each(data.cities, function (key, city) {
                                options +=
                                    '<option class="custom-option list" value="' +
                                    city.id +
                                    '" data-country="' + city.country_id + '">' +
                                    city.title +
                                    '</option>';
                            });

                            $('#city-select').html(options);

                            var options =
                                '<option class="custom-option list" value="" selected disabled>Select Area</option>';
                            $.each(data.areas, function (key, area) {
                                options +=
                                    '<option class="custom-option list" value="' +
                                    area.id +
                                    '" data-city="' +
                                    area.city_id + '">' + area.title + '</option>';
                            });

                            $('#area-select').html(options);
                            resolve(selectedCity);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        reject(error);
                    }
                });
            });
        }

        function updateAreas(cityId, selectedArea) {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: '/areas',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        city_id: cityId
                    },
                    success: function (data) {
                        var options =
                            '<option class="custom-option list" value="" selected disabled>Select Area</option>';
                        $.each(data, function (key, area) {
                            options += '<option value="' + area.id +
                                '" data-city="' +
                                area.city_id + '">' + area.title + '</option>';
                        });

                        $('#area-select').html(options);
                        resolve(selectedArea);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        reject(error);
                    }
                });
            });
        }
    });
</script>
@endpush