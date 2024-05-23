
@extends('layouts.user')

@push('css')


@endpush

@section('contents')
    <div class="breadcrumb-area">
        <h3 class="title">@lang('Add New Service')</h3>
        <ul class="breadcrumb">
            <div class="form-check form-switch me-5">
                <label class="form-check-label" for="flexSwitchCheckDefault">@lang('-Online Service-')</label>
                <input class="form-check-input" name="is_service_online" type="checkbox" id="check">

            </div>
            <li>
                <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
            </li>
            <li>
                @lang('Add New Servicce')
            </li>
        </ul>
    </div>
    <div class="dashboard--content-item">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-10">
                <div class="profile--card">
                    @includeIf('includes.flash')
                    <form id="request-form" action="{{ route('user.store.service') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="is_service_online" id="checkval" value="0">
                        <div class="row gy-4">


<!--  -->


                            <div class="col-sm-6">
                                <label for="category" class="form-label">@lang('Select Service Type')</label>

                            <div class="d-none online-class">
                                <select name="category_id" id="category" class="form-control">
                                    <!-- <option value="">@lang('Select Service Type')</option> -->
                                    @foreach ($categories_main as $item)
                                        <option value="{{ $item->id }}" {{ $item->id==1 ? 'selected': '' }}>{{ __($item->title) }}</option>
                                    @endforeach
                                </select>
                            </div>


                                <div class="offline-class">
                                <select name="category_id" id="category" class="form-control">
                                    <!-- <option value="">@lang('Select Category')</option> -->

                                    @foreach ($categories_main as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id==2 ? 'selected': '' }} >{{ __($cat->title) }}</option>
                                    @endforeach
                                </select>
								</div>

                            </div>

<!--  -->




                            <div class="col-sm-6">

                                <label for="subcategory" class="form-label">@lang('Select Category')</label>
                                <select name="subcategory_ids[]" id="subcategory" class="form-control js-example-basic-multiple" multiple="multiple">
                                    <option value="">@lang('Select SubCategory')</option>

                                    @if($subcategories != null)
                                        @foreach($subcategories as $subcategory)

                                            <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">
                                            {{ $subcategory->title }}
                                            </option>
                                            @if($subcategory->children != null)
                                                @foreach($subcategory->children as $sub_subCategory)

                                                    <option  value="{{ $sub_subCategory->id }}" data-category="{{ $sub_subCategory->category_id }}">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $sub_subCategory->title }}
                                                    </option>

                                                    @if($sub_subCategory->children != null)
                                                    @foreach($sub_subCategory->children as $sub_subsubCategory)

                                                        <option value="{{ $sub_subsubCategory->id }}" data-category="{{ $sub_subsubCategory->category_id }}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $sub_subsubCategory->title }}
                                                        </option>
                                                            @if($sub_subsubCategory->children != null)
                                                            @foreach($sub_subsubCategory->children as $sub_subsubsubCategory)

                                                                <option value="{{ $sub_subsubsubCategory->id }}" data-category="{{ $sub_subsubsubCategory->category_id }}">
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $sub_subsubsubCategory->title }}
                                                                </option>

                                                            @endforeach
                                                            @endif
                                                    @endforeach
                                                    @endif
                                                @endforeach
                                            @endif

                                        @endforeach

                                    @endif
                                </select>


                            </div>
                            <div class="col-sm-6">
                                <label for="service-title" class="form-label">@lang('Service Title')</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="@lang('Service Title')" required>
                            </div>
                            <div class="col-sm-6 d-none online-class">
                                <label for="delivery_days" class="form-label">@lang('Delivery Days')</label>
                                <input type="number" name="delivery_days" id="delivery_days" class="form-control" placeholder="@lang('Delivery Days')">
                            </div>
                            <div class="col-sm-6 d-none online-class">
                                <label for="revision" class="form-label">@lang('Revision')</label>
                                <input type="number" name="revision" id="revision" class="form-control" placeholder="@lang('Revision')">
                            </div>

                            <div class="col-sm-6 d-none online-class">
                                <label for="price" class="form-label">@lang('Service Price')</label>
                                <input type="number" name="price" id="price" class="form-control" step="any" min="0" placeholder="@lang('Service Price')">
                            </div>

                            <div class="col-sm-6 service">
                                <label for="video" class="form-label">@lang('Service video Url')</label>
                                <input type="text" name="video" id="video" class="form-control"
                                       placeholder="@lang('Service Video Url')">
                            </div>

                            <div class="col-sm-4 offline-class">
                                <label for="country" class="form-label">@lang('Select Country')</label>
                                <select name="service_country_id" id="country" class="form-control">
                                    <option value="">@lang('Select Country')</option>
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->id }}" >{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 offline-class">
                                <label for="city" class="form-label">@lang('Select Cities')</label>
                                <select name="service_city_id" id="city" class="form-control">
                                    <option value="">@lang('Select City')</option>
                                    @foreach ($cities as $item)
                                        <option value="{{ $item->id }}" data-country="{{ $item->country_id }}">{{ __($item->title) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Area section start --}}
                            <div class="col-sm-4 offline-class">
                                <label for="area" class="form-label">@lang('Select Area')</label>
                                <select name="service_area_id" id="area" class="form-control">
                                    <option value="">@lang('Select Area')</option>
                                    @foreach ($areas as $item)
                                        <option value="{{ $item->id }}" data-city="{{ $item->city_id }}">{{ __($item->title) }}</option>
                                    @endforeach
                                    <option value="0">@lang('Add New Area')</option>
                                </select>
                                <div id="input">
                                </div>
                            </div>
                            <span class="offline-class">If you can't find a area for your service on the list, please <a href="/contact" target="_blank">contact</a> us and we will add it.</span>
                            {{-- Area section end --}}

                            <div class="col-sm-12" >
                                <label for="text" class="form-label">@lang('Service Description')</label>
                                <textarea id="summernote" name="description" class="form-control summernote"  required  placeholder="@lang('Service Description')" ></textarea>
                            </div>

                            <div class="col-sm-12">
                                <label for="text" class="form-label">@lang('Service Image')</label>
                                <div class="user--profile mb-5">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/no-image.png') }}" alt="clients">
                                    </div>
                                    <div class="remove-thumb">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="content">
                                        <div class="mt-4">
                                            <label class="btn btn-sm btn--base text--dark">
                                                @lang('Upload Service Image')
                                                <input type="file" id="profile-image-upload" name="image" hidden>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label for="service-gallery-upload" class="form-label">@lang('Service Gallery Images')</label>
                                <div class="service-gallery-image mb-5">
                                    <div class="thumb-grid">
                                        <img src="{{ asset('assets/images/no-image.png') }}" alt="clients">
                                    </div>
                                    <div class="mt-4">
                                        <label class="btn btn-sm btn--base text--dark">
                                            @lang('Upload Multiple Service Image')
                                                <input type="file" id="service-gallery-upload" name="image_gallery[]" multiple hidden>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="slug" name="slug" value="">
                            <div class="col-sm-12">
                                <div class="text-end">
                                    <button type="submit" class="cmn--btn">@lang('Submit')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')


    <script type="text/javascript">
        "use strict";
        var optgroups = $('#subcategory > option');
        $('#category').on('change', function(){
            var category = $(this).val();
            var options = optgroups.filter('[data-category="'+category+'"]');

            $('#subcategory').html( '<option value="">@lang('Select SubCategory')</option>' + options.map(function(){
                return '<option value="'+this.value+'">'+this.text+'</option>';
            }).get().join('') );

        });

        var countryOptgroups = $('#city > option');
        $('#country').on('change', function(){
            var country = $(this).val();
            var options = countryOptgroups.filter('[data-country="'+country+'"]');

            $('#city').html( '<option value="">@lang('Select City')</option>' + options.map(function(){
                return '<option value="'+this.value+'">'+this.text+'</option>';
            }).get().join('') );

        });

        var cityOptgroups = $('#area > option');
        $('#city').on('change', function(){
            var city = $(this).val();
            var options = cityOptgroups.filter('[data-city="'+city+'"]');



            $('#area').html( '<option value="">@lang('Select Area')</option>' + options.map(function(){
                return '<option value="'+this.value+'">'+this.text+'</option>';
            }).get().join('') + '<option value="0">@lang('Add New Area')</option>' );


        });
        $('#area').on('change', function(){
            var optdata = $(this).val();
            if(optdata==0){
                $('#input').html('<input type="text" name="newarea" required class="form-control mt-2" placeholder="Add new service area">');
            }
            else{
                $('#input').html('');
            }

        });

        $('#title').on('keyup', function(){
            var title = $(this).val();
            var slug = title.replace(/[^a-z0-9]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            $('#slug').val(slug);
        });

        "use strict"
        var prevImg = $('.user--profile .thumb').html();
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var uploadedFile = new FileReader();
                uploadedFile.onload = function (e) {
                    var preview = $('.user--profile').find('.thumb');
                    preview.html(`<img src="${e.target.result}" alt="user">`);
                    preview.addClass('image-loaded');
                    preview.hide();
                    preview.fadeIn(650);
                    $(".image-view").hide();
                    $(".remove-thumb").show();
                }
                uploadedFile.readAsDataURL(input.files[0]);
            }
        }
        $("#profile-image-upload").on('change', function () {
            proPicURL(this);
        });
        $(".remove-thumb").on('click', function () {
            $(".user--profile .thumb").html(prevImg);
            $(".user--profile .thumb").removeClass('image-loaded');
            $(".image-view").show();
            $(this).hide();
        })

        $('#check').on('change', function(){
            if($(this).is(':checked')){
                $('#checkval').val(1);
                $('.online-class').removeClass('d-none');
                $('.offline-class').addClass('d-none');
                $('.service').removeClass('col-sm-6');
                $('.service').addClass('col-sm-12');
				$("#category_id option:selected").attr("selected", "selected");

            }else{
                $('#checkval').val(0);
                $('.online-class').addClass('d-none');
                $('.offline-class').removeClass('d-none');
                $('.service').removeClass('col-sm-12');
                $('.service').addClass('col-sm-6');
            }
        });

        $('#summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        //Upload multiple images
        $("#service-gallery-upload").on('change', function () {
            const files = $(this)[0].files;
            const previewContainer = $('.thumb-grid');

            previewContainer.empty();
            if (files.length === 0) {
                previewContainer.html('<img src="{{ asset('assets/images/no-image.png') }}" alt="clients">');
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function (event) {
                    const imgHtml = `<div class="image-preview">
                             <img src="${event.target.result}" alt="preview">
                             <div class="remove-thumb btn-remove-img" style="display: block">
                                 <i class="fas fa-times"></i>
                             </div>
                         </div>`;
                    previewContainer.append(imgHtml);
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).on('click', '.btn-remove-img', function () {
            $(this).parent('.image-preview').remove();
            const previewContainer = $('.thumb-grid');
            if (previewContainer.children().length === 0) {
                previewContainer.html('<img src="{{ asset('assets/images/no-image.png') }}" alt="clients">');
            }
        });

    </script>

@endpush
