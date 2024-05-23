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
                    <h2>@lang('All Jobs')</h2>
                    <span><a href="{{ route('front.index') }}">@lang('Home')</a><i class="bi bi-chevron-right"></i>@lang('All Jobs')</span>
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
        <div class="service-selection wow animate fadeInUp" data-wow-delay="1800ms" data-wow-duration="1500ms">
            <form action="#" method="post">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="service-loc-selection">
                            <i><img src="assets/images/location.svg" alt=""></i>
                            <select class="loc-select form-select form-select-lg" id="search_item_country">
                                <option value="">{{__('Select Country')}}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ isset(request()->input()['country']) && request()->input()['country'] == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card py-4 px-3  ">
                            <div class="row d-flex">

                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select form-select-lg" aria-label="Default select example" id="search_item_city">
                                            <option selected>@lang('Select City')</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ isset(request()->input()['city']) && request()->input()['city'] == $city->id ? 'selected' : ''}} data-country="{{ $city->country_id }}">{{ $city->title }}</option>
                                            @endforeach
                                            
                                          </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select form-select-lg " aria-label="Default select example" id="search_cat_item">
                                            <option selected>@lang('Select Category')</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ isset(request()->input()['category']) && request()->input()['category'] == $category->id ? 'selected' : ''}}>{{ $category->title }}</option>
                                            @endforeach
                                            
                                          </select>
                                    </div>
                                </div> 

                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select form-select-lg " aria-label="Default select example" id="search_orderby_item">
                                            <option value="date_desc" {{ isset(request()->input()['sortby']) && request()->input()['sortby'] == 'date_desc' ? 'selected' : ''}}>{{__('Date: Newest on top')}}</option>
                                            <option value="date_asc" {{ isset(request()->input()['sortby']) && request()->input()['sortby'] == 'date_asc' ? 'selected' : ''}}>{{__('Date: Oldest on top')}}</option>
                                            <option value="price_desc" {{ isset(request()->input()['sortby']) && request()->input()['sortby'] == 'price_desc' ? 'selected' : ''}}>{{__('Price: High to Low')}}</option>
                                            <option value="price_asc" {{ isset(request()->input()['sortby']) && request()->input()['sortby'] == 'price_asc' ? 'selected' : ''}}>{{__('Price: Low to High')}}</option>
                                          </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>

        <div id="show_search_items">
            @include('load.job')
        </div>
        
        
    </div>
</section>
<!-- End services-area section -->




<form id="search_item" class="d-none" action="{{route('front.alljobs')}}" method="GET">

    <input type="text" name="country" id="country" value="{{request()->input('country')}}">
    <input type="text" name="city" id="city" value="{{request()->input('city')}}">
    <input type="text" name="sortby" id="sortby" value="{{request()->input('sortby')}}">
    <input type="text" name="category" id="category" value="{{request()->input('category')}}">

    <button type="submit" id="search_btn_submit" class="d-none"></button>
</form>


@endsection

@push('js')
<script type="text/javascript">
    "use strict";

    $(document).ready(function(){
        var optgroups = $('#search_item_city > option');
        $('#search_item_country').on('change', function(){
           var country= $('#search_item_country').val();
           $('#search_item #country').val(country);
            $('#search_btn_submit').click();

        var options = optgroups.filter('[data-country="'+country+'"]');
        $('#search_item_city').html( '<option value="">@lang('Select City')</option>' + options.map(function(){
            return '<option value="'+this.value+'">'+this.text+'</option>';
        }).get().join('') );
        });


        $('#search_item_city').on('change', function(){
            var city= $('#search_item_city').val();
            $('#search_item #city').val(city);
            $('#search_btn_submit').click();
        });

        $('#search_orderby_item').on('change', function(){
            var sortby= $('#search_orderby_item').val();
            $('#search_item #sortby').val(sortby);
            $('#search_btn_submit').click();
        });

        $('#search_cat_item').on('change', function(){
            var category= $('#search_cat_item').val();
            $('#search_item #category').val(category);
            $('#search_btn_submit').click();
        });

        $(document).on('submit','#search_item',function(e){
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


    });

	
</script>
@endpush

