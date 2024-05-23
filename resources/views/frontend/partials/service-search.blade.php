<div class="service-selection wow animate fadeInUp filter" data-wow-delay="1800ms" data-wow-duration="1500ms">

    <form action="#" method="post" id="form-search">

        <div class="row">

            <div class="col-lg-3">

                <div class="service-loc-selection">

                    <select class="loc-select form-select form-select-lg" id="search_item_country">

                        <option value="">@lang($is_service_online ? 'Online Services' : 'Select')</option>

                        @foreach ($countries as $country)

                        <option value="{{ $country->id }}" {{ isset($filter['country']) &&
                            $filter['country']==$country->id ? 'selected' : ''}}>{{ $country->name
                            }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="col-lg-9">

                <div class="card py-4 px-3  ">

                    <div class="row d-flex">

                        <div
                            class="col-sm-12 col-md-6 col-lg-3 mb-md-2 mb-sm-2 toggle-if-online-service city {{ isset($is_service_online) && $is_service_online ? 'd-none'  : '' }}">

                            <div class="form-group">

                                <select class="form-select form-select-lg" aria-label="Default select example"
                                    id="search_item_city">

                                    <option value="" selected>@lang('Select City')</option>

                                    @foreach ($cities as $city)

                                    <option value="{{ $city->id }}" {{ isset($filter['city']) &&
                                        $filter['city']==$city->id ? 'selected' : ''}}
                                        data-country="{{ $city->country_id }}">{{ $city->title }}</option>

                                    @endforeach



                                </select>

                            </div>

                        </div>



                        <div
                            class="col-sm-12 col-md-6 col-lg-3 mb-md-2 mb-sm-2 toggle-if-online-service area {{ isset($is_service_online) && $is_service_online ? 'd-none'  : '' }}">

                            <div class="form-group">

                                <select class="form-select form-select-lg" aria-label="Default select example"
                                    id="search_item_area">

                                    <option value="" selected>@lang('Select Area')</option>

                                    @foreach ($areas as $area)

                                    <option value="{{ $area->id }}" {{ isset($filter['area']) &&
                                        $filter['area']==$area->id ? 'selected' : ''}}
                                        data-city="{{ $area->city_id }}">{{ $area->title }}</option>

                                    @endforeach



                                </select>

                            </div>

                        </div>







                        <div
                            class="col-sm-12 col-md-6 col-lg-3 mb-md-2 mb-sm-2 toggle-if-online-service category {{ isset($is_service_online) && $is_service_online ? 'd-none' : '' }}">

                            <div class="form-group">

                                <select class="form-select form-select-lg " aria-label="Default select example"
                                    id="search_cat_item">

                                    <option value="" selected>@lang('Category')</option>

                                    @foreach ($categories->filter(fn($category) => $category->type == 'parent')
                                    as $category)

                                    <option
                                        data-online-service="{{ $category->slug == 'online-services' ? true : false }}"
                                        value="{{ $category->id }}" {{ isset(request()->input()['category']) &&
                                        request()->input()['category'] == $category->id ? 'selected' : ''}}
                                        {{ isset($is_service_online) && $is_service_online ? ($category->slug
                                        == 'online-services' ?
                                        'selected'
                                        : '') : '' }}
                                        >{{ $category->title }}</option>

                                    @endforeach



                                </select>

                            </div>

                        </div>



                        <div class="col-sm-12 col-md-6 col-lg-3 mb-md-2 mb-sm-2">

                            <div class="form-group">

                                <select class="form-select form-select-lg " aria-label="Default select example"
                                    id="search_subcat_item">

                                    <option value="" selected>@lang(isset($is_service_online) &&
                                        $is_service_online ? 'Category'
                                        :'Subcategory')</option>

                                    @foreach ($subcategories as $subcategory)

                                    <option value="{{ $subcategory->id }}" {{ isset(request()->
                                        input()['subcategory']) && request()->input()['subcategory'] ==
                                        $subcategory->id ? 'selected' : ''}} data-category="{{
                                        $subcategory->category_id }}">{{ $subcategory->title }}</option>

                                    @endforeach



                                </select>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-3">
            <div class="location-search">
                <div class="location-form">
                    <input type="text" name="location-search" id="location-search"
                        placeholder="Find Your Services Here" value="{{ request()->input('search')}}" required>
                    <button type="button" id="btn-search"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>

    </form>

</div>