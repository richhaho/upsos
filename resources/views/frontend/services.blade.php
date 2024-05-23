@extends('layouts.front')



@push('css')

<style>
    .location-form input {
        border-radius: 30px;
    }

    .location-form button {
        background-color: var(--theme-clr);
        border-radius: 50%;
        font-size: 18px;
    }


    .location-form input[type="text"] {
        padding-right: 60px;
    }

    .location-search {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .location-form {
        position: relative;
        width: 50%;
    }

    .location-form input {
        background-color: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, .125);
        box-sizing: border-box;
        box-shadow: 0px 0px 15px rgba(84, 161, 93, 0.1);
        height: 60px;
        width: 100%;
        font-size: 13px;
        color: #A29D9D;
        padding: 0 20px;
    }

    @media (max-width: 767px) {
        .location-form input {
            height: 50px;
        }

        .location-form {
            width: 80%;
        }
    }

    .location-form input[type="text"] {
        padding-right: 60px;
    }

    .location-form button {
        position: absolute;
        right: 5px;
        background-color: var(--theme-clr);
        border: none;
        color: #fff;
        height: 50px;
        width: 50px;
        top: 5px;
        font-size: 20px;
    }

    @media (max-width: 767px) {
        .location-form button {
            height: 40px;
            width: 40px;
            font-size: 18px;
        }
    }
</style>

@endpush



@section('content')



<!-- Start breadcrumbs section -->

<section class="breadcrumbs" style="background-image: url({{ asset('assets/images/'.$gs->breadcumb_banner) }})">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <div class="breadcrumb-wrapper">

                    <h2>@lang('All Services')</h2>

                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i
                            class="bi bi-chevron-right"></i>@lang('All Services')</span>

                    <div class="arrow-down">

                        <a href="#down"><i class="bi bi-chevron-down"></i></a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- End breadcrumbs section -->









<!-- Start services-area section -->

<section id="down" class="services-area sec-m-top">

    <div class="container">

        @include('frontend.partials.service-search')



        <div id="show_search_items">

            @include('load.service')

        </div>





    </div>

</section>

<!-- End services-area section -->





<form id="search_item" class="d-none" action="{{route('front.allservices')}}" method="GET">

    <input type="text" name="search" id="search" value="{{request()->input('search')}}">

    <input type="text" name="country" id="country" value="{{isset($filter['country']) ? $filter['country'] : ''}}">

    <input type="text" name="city" id="city" value="{{isset($filter['city']) ? $filter['city'] : ''}}">

    <input type="text" name="area" id="area" value="{{isset($filter['area']) ? $filter['area'] : ''}}">

    <input type="text" name="category" id="category" value="{{request()->input('category')}}">

    <input type="text" name="subcategory" id="subcategory" value="{{request()->input('subcategory')}}">



    <button type="submit" id="search_btn_submit" class="d-none"></button>

</form>





@endsection



@push('js')

<script type="text/javascript">

    "use strict";



    $(document).ready(function () {

        $(document).on('change', '#search_item_country', function () {

            var country = $('#search_item_country').val();

            $('#search_item #country').val(country);


            if (country) {
                $('.toggle-if-online-service').removeClass('d-none');
                $('#search_subcat_item').find('option[value=""]').text('SubCategory');
                $('.toggle-if-online-service.category').find('select').val('');
                $('#search_subcat_item').val('');

                updateCities(country, $('#search_item_city').val()).then(({ city, cities }) => {
                    if (city && cities && cities.filter(c => c.id == city).length > 0) {
                        $('#search_item_city,#search_item > #city').val(city);
                    } else {
                        $('#search_item_city,#search_item > #city').val('');
                    }
                });
            } else {
                $('.toggle-if-online-service').addClass('d-none');
                $('#search_subcat_item').find('option[value=""]').text('Category');
                $('.toggle-if-online-service.category').find('select').val(
                    $('.toggle-if-online-service.category').find('select option[data-online-service="1"]').val()
                );
                $('#search_item_area,#search_item > #city,#search_item > #area').val('');
            }

            $('#search_item > #category').val($('.toggle-if-online-service.category').find('select').val());
            $('#search_item > #subcategory').val($('#search_subcat_item').val());



            // $('#search_btn_submit').click();
        });



        $(document).on('change', '#search_item_city', function () {

            var city = $('#search_item_city').val();

            $('#search_item #city').val(city);

            updateAreas(city, $('#search_item_area').val()).then(({ area, areas }) => {
                if (area && areas.filter(a => a.id == area).length > 0) {
                    $('#search_item_area,#search_item > #area').val(area);
                } else {
                    $('#search_item_area,#search_item > #area').val('');
                }
            });

            // $('#search_btn_submit').click();
        });





        var subcategoryoptgroups = $('#search_subcat_item > option');



        $(document).on('change', '#search_cat_item', function () {

            var category = $('#search_cat_item').val();

            $('#search_item #category').val(category);



            // $('#search_btn_submit').click();
        });





        $(document).on('change', '#search_item_city', function () {

            var city = $('#search_item_city').val();

            $('#search_item #city').val(city);

            // $('#search_btn_submit').click();

        });



        $(document).on('change', '#search_item_area', function () {

            var area = $('#search_item_area').val();

            $('#search_item #area').val(area);

            // $('#search_btn_submit').click();

        });



        $(document).on('change', '#search_orderby_item', function () {

            var sortby = $('#search_orderby_item').val();

            $('#search_item #sortby').val(sortby);

            $('#search_btn_submit').click();

        });



        $(document).on('change', '#search_cat_item', function () {

            var category = $('#search_cat_item').val();

            $('#search_item #category').val(category);

            // $('#search_btn_submit').click();

        });



        $(document).on('change', '#search_subcat_item', function () {

            var subcategory = $('#search_subcat_item').val();

            $('#search_item #subcategory').val(subcategory);

            // $('#search_btn_submit').click();

        });



        $(document).on('submit', '#search_item', function (e) {

            e.preventDefault();

            $.ajax({

                method: 'GET',

                url: $(this).attr('action'),

                data: $(this).serialize(),

                success: function (data) {

                    $('#show_search_items').html(data);

                }

            });

        })

        $(document).on('change', '#location-search', function () {
            $('#search_item > #search').val($(this).val());
        });

        $(document).on('click', '#btn-search', function () {
            console.log('s');
            $('#search_btn_submit').click();
        });

        $(document).on('submit','#form-search', function (e) {
            e.preventDefault();
            console.log('s');
            $('#search_btn_submit').click();
        });

        setTimeout(() => {
            const country = $('#search_item_country').val();
            if (country) {
                $('#search_item_country').trigger('change');
            }
            const city = $('#search_item_city').val();
            if (city) {
                $('#search_item_city').trigger('change');
            }
        }, 500);

    });
    function isLocalAreaService() {
        return $('#filter_local_area').is(':checked');
    }

    function updateCities(countryId, selectedCity) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: "{{route('front.cities')}}",
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
                        $('#search_item_city').html(
                            '<option class="custom-option list" value="" data-country="" selected>Select City</option>'
                        );
                        resolve(null);
                    } else {
                        var options =
                            '<option class="custom-option list" value="" data-country="" selected>Select City</option>';
                        $.each(data.cities, function (key, city) {
                            options +=
                                '<option class="custom-option list" value="' +
                                city.id +
                                '" data-country="' + city.country_id + '">' +
                                city.title +
                                '</option>';
                        });

                        $('#search_item_city').html(options);

                        var options =
                            '<option class="custom-option list" value="" selected>Select Area</option>';
                        $.each(data.areas, function (key, area) {
                            options +=
                                '<option class="custom-option list" value="' +
                                area.id +
                                '" data-city="' +
                                area.city_id + '">' + area.title + '</option>';
                        });

                        $('#search_item_area').html(options);
                        resolve({ city: selectedCity, cities: data.cities });
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
                url: "{{route('front.areas')}}",
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
                        '<option class="custom-option list" value="" selected>Select Area</option>';
                    $.each(data, function (key, area) {
                        options += '<option value="' + area.id +
                            '" data-city="' +
                            area.city_id + '">' + area.title + '</option>';
                    });

                    $('#search_item_area').html(options);
                    resolve({ area: selectedArea, areas: data });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    reject(error);
                }
            });
        });
    }


</script>

@endpush