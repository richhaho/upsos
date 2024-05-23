@extends('layouts.user')

@push('css')

@endpush

@section('contents')

    <div class="breadcrumb-area">
        <h3 class="title">@lang('Edit Attributes')</h3>
        <ul class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>
            <li>@lang('Edit Attributes')</li>
        </ul>
    </div>

    <div class="dashboard--content-item">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-10">
                <div class="profile--card">
                    @includeIf('includes.flash')
                    @if ($serviceincludes->count()>0)
                        <form id="request-form" action="{{ route('user.update.attribute',$service->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5>{{ $service->is_service_online== 1 ? 'Online': 'Offline' }}</h5>

                            {{-- include package section start --}}
                            @if ($serviceincludes->count()>0)

                                @if ($service->is_service_online == 0)
                                    <input type="hidden" name="is_service_online" value="0">
                                    <div class="included-package">
                                        <div class=" mt-5">
                                            <h4>@lang('What is Included In This Package')</h4>
                                        </div>
                                        @foreach ($serviceincludes as $data)
                                            <div class="input my-4 row">
                                                <input type="hidden" name="attribute_id[]" value="{{ $data->id }}">
                                                <div class="col-md-3">
                                                    <div class="user--profile">
                                                        <div class="thumb">
                                                            <img src="{{ $data->image ? asset('assets/images/'.$data->image) : asset('assets/images/no-image.png') }}" alt="clients">
                                                        </div>
                                                        <div class="content">
                                                            <div class="">
                                                                <label class="btn btn-sm btn--base text--dark">
                                                                    Upload Service Image
                                                                    <input class="profile-image-upload" type="file" id="profile-image-upload" name="image[]" hidden>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mt-5">
                                                    <label for="#title">@lang('Title')</label>
                                                    <input id="title" value="{{ $data->include_service_title }}" name="include_service_title[]" type="text" class="form-control" >
                                                </div>

                                                <div class="col-md-2 mt-5">
                                                    <label for="#price">@lang('Price')</label>
                                                    <input id="price" value="{{ $data->include_service_price }}" name="include_service_price[]" type="text" class="form-control" >
                                                </div>

                                                <div class="col-md-{{$loop->first ? 3 : 2}} mt-5">
                                                    <label for="#duration">@lang('Quantity')</label>
                                                    <input id="quantity" value="{{ $data->include_service_quantity }}" name="include_service_quantity[]" type="text" class="form-control" >
                                                </div>
                                                @if (!$loop->first)
                                                    <div class="col-md-1 mt-5">
                                                        <a href="#" class="offline-remove remove_field btn btn-danger btn-sm cmn-remove"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="extra" id="offline">
                                        </div>
                                        <p id="offline-add" class="text-danger cmn-design"> <i class="fas fa-plus-circle "></i> @lang('Add more')</p>
                                    </div>
                                @else
                                    <input type="hidden" name="is_service_online" value="1">
                                    <div class="included-package">
                                        <div class=" mt-5">
                                            <h4>@lang('What is included in basic package')</h4>
                                        </div>

                                        @foreach ($serviceincludes as $data)
                                            <div class="input my-4 row">
                                                <div class="col-md-3">
                                                    <div class="user--profile mb-5">
                                                        <div class="thumb">
                                                            <img src="{{ $data->image ? asset('assets/images/'.$data->image) : asset('assets/images/no-image.png') }}" alt="clients" class="img-fluid">
                                                        </div>
                                                        <div class="content">
                                                            <div class="mt-4">
                                                                <label class="btn btn-sm btn--base text--dark">
                                                                    Upload Service Image
                                                                    <input class="profile-image-upload" type="file" id="profile-image-upload" name="image[]" hidden>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-{{$loop->first ? 9 : 8}} d-flex align-items-center">
                                                    <label for="title" class="me-3"> @lang('Title')</label>
                                                    <input id="title" value="{{ $data->include_service_title }}" name="include_service_title[]" type="text" class="form-control">
                                                </div>

                                                @if (!$loop->first)
                                                    <div class="col-md-1 d-flex align-items-center">
                                                        <a href="#" class="online-remove cmn-remove2 btn btn-danger btn-sm mt-0"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                @endif
                                            </div>

                                        @endforeach

                                        <div class="online" id="online">
                                        </div>
                                        <p id="online-add" class="text-danger cmn-design"><i class="fas fa-plus-circle "></i>@lang('Add more')</p>
                                    </div>

                                @endif

                            @endif
                            {{-- include package section end  --}}

                            {{-- Benefits of the package --}}
                            <div class="included-package">
                                <div class=" mt-5">
                                    <h4>@lang('Benefits of the package')</h4>
                                </div>
                                @if ($servicebenefits->count()>0)
                                    @foreach ($servicebenefits as $data)
                                        <div class="input my-4 row">
                                            <input type="hidden" name="benefit_id[]" value="{{ $data->id }}">
                                            <div class="col-md-11">
                                                <input id="title" value="{{ $data->benefits }}" name="benefits[]" type="text" class="form-control" placeholder="Type Here" >
                                            </div>
                                            <div class="col-md-1">
                                                <a href="#" class="benefit-remove cmn-remove2 btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input my-4 row">
                                        <div class="col-md-12">
                                            <input id="title" name="benefits[]" type="text" class="form-control" placeholder="Type Here" >
                                        </div>
                                    </div>
                                @endif
                                <div class="extra" id="benefits">
                                </div>
                                <p id="benefits-add" class="text-danger cmn-design"><i class="fas fa-plus-circle "></i> @lang('Add more')</p>
                            </div>

                            {{-- Additional package section start --}}

                            <div class="included-package">
                                <div class=" mt-5">
                                    <h4>@lang('Additional product or service')</h4>
                                </div>

                                @if ($serviceadditional->count()>0)
                                    @foreach ($serviceadditional as $data)
                                        <div class="input my-4 row">
                                            <input type="hidden" name="additional_id[]" value="{{ $data->id }}">
                                            <div class="col-md-3">
                                                <div class="product--image">
                                                    <div class="thumb">
                                                        <img src="{{ $data->product_image ? asset('assets/images/'.$data->product_image) : asset('assets/images/no-image.png') }}" alt="clients" class="img-fluid">
                                                    </div>
                                                    <div class="content">
                                                        <div class="">
                                                            <label class="btn btn-sm btn--base text--dark">
                                                                Upload Product Image
                                                                <input class="product-image-upload" type="file" id="product-image-upload" name="product_image[]" hidden>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="#title">@lang('Title')</label>
                                                <input id="title" value="{{ $data->additional_service_title }}" name="additional_service_title[]" type="text" class="form-control" >
                                            </div>

                                            <div class="col-md-2">
                                                <label for="#price">@lang('Price')</label>
                                                <input id="price" value="{{ $data->additional_service_price }}" name="additional_service_price[]" type="text" class="form-control" >
                                            </div>

                                            <div class="col-md-2">
                                                <label for="#duration">@lang('Quantity')</label>
                                                <input id="quantity" value="{{ $data->additional_service_quantity }}" name="additional_service_quantity[]" type="text" class="form-control" >
                                            </div>
                                            <div class="col-md-1">
                                                <a href="#" class="add-remove cmn-remove btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input my-4 row">
                                        <div class="col-md-4">
                                            <div class="product--image">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="clients" class="img-fluid">
                                                </div>
                                                <div class="content">
                                                    <div class="">
                                                        <label class="btn btn-sm btn--base text--dark">
                                                            Upload Product Image
                                                            <input class="product-image-upload" type="file" id="product-image-upload" name="product_image[]" hidden>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-5">
                                            <label for="#title">@lang('Title')</label>
                                            <input id="title" name="additional_service_title[]" type="text" class="form-control" >
                                        </div>
                                        <div class="col-md-2 mt-5">
                                            <label for="#price">@lang('Price')</label>
                                            <input id="price" name="additional_service_price[]" type="text" class="form-control" >
                                        </div>
                                        <div class="col-md-2 mt-5">
                                            <label for="#duration">@lang('Quantity')</label>
                                            <input id="quantity" name="additional_service_quantity[]" type="text" class="form-control" >
                                        </div>
                                    </div>
                                @endif

                                <div class="extra" id="additional">
                                </div>
                                <p id="additional-add" class="text-danger cmn-design"><i class="fas fa-plus-circle"></i> @lang('Add more')</p>
                            </div>

                            <div class="included-package">
                                <div class=" mt-5">
                                    <h4>FAQs</h4>
                                </div>
                                @if ($servicefaqs->count()>0)
                                    @foreach ($servicefaqs as $data)

                                        <div class="input my-4 row">
                                            <input type="hidden" name="faq_id[]" value="{{ $data->id }}">
                                            <div class="col-md-5">
                                                <input id="title" value="{{ $data->faq_title }}" name="faq_title[]" type="text" class="form-control" placeholder="Type Here" >
                                            </div>

                                            <div class="col-md-6">
                                                <textarea class="form-control nic-edit" name="faq_detail[]" id="" cols="30" rows="5">{{ $data->faq_detail }}</textarea>
                                            </div>

                                            <div class="col-md-1">
                                                <a href="#" class="faq-remove cmn-remove btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>

                                    @endforeach
                                @else
                                    <div class="input my-4 row">
                                        <div class="col-md-6">
                                            <input id="title" name="faq_title[]" type="text" class="form-control" placeholder="Type Here" >
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="form-control nic-edit" name="faq_detail[]" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                @endif
                                <div class="extra" id="faq">
                                </div>
                                <p id="faq-add" class="text-danger cmn-design"><i class="fas fa-plus-circle "></i> @lang('Add more')</p>
                            </div>

                            <div class="update-btn my-3">
                                <button type="submit" class="add-btn btn ">@lang('Update')</button>
                            </div>

                        </form>

                    @else
                        <h3 class="text-center">@lang('Please Add Attribute First')</h3>
                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection

@push('js')

    <script type="text/javascript">
        "use strict";
        $(document).ready(function(){
            // include service package start
            function updateImagePreview(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $(input).closest('.user--profile').find('.thumb img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var uploadedFile = new FileReader();
                    uploadedFile.onload = function (e) {
                        var preview = $(input).closest('.user--profile').find('.thumb');
                        preview.html(`<img src="${e.target.result}" alt="user" class="img-fluid">`);
                        preview.addClass('image-loaded');
                        preview.hide();
                        preview.fadeIn(650);
                    }
                    uploadedFile.readAsDataURL(input.files[0]);
                }
            }

            $(document).on('change', '.profile-image-upload', function() {
                if ($(this).attr('id') === 'profile-image-upload') {
                    proPicURL(this);
                } else {
                    updateImagePreview(this);
                }
            });

            function addNewOfflineServiceRow(uniqueId) {
                return `<div class="input my-4 row">
            <div class="col-md-3">
                <div class="user--profile mb-5">
                    <div class="thumb">
                        <img src="{{ asset('assets/images/no-image.png') }}" alt="clients" class="img-fluid">
                    </div>
                    <div class="content">
                        <div class="mt-4">
                            <label for="profile-image-upload-${uniqueId}" class="btn btn-sm btn--base text--dark">
                                Upload Service Image
                                <input class="profile-image-upload" type="file" id="profile-image-upload-${uniqueId}" name="image[]" hidden>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5">
                <label for="title-${uniqueId}" class="me-3">Title</label>
                <input id="title-${uniqueId}" name="include_service_title[]" type="text" class="form-control">
            </div>
            <div class="col-md-2 mt-5">
                <label for="price-${uniqueId}" class="me-3">Price</label>
                <input id="price-${uniqueId}" name="include_service_price[]" type="text" class="form-control">
            </div>
            <div class="col-md-2 mt-5">
                <label for="quantity-${uniqueId}" class="me-3">Quantity</label>
                <input id="quantity-${uniqueId}" name="include_service_quantity[]" type="text" class="form-control">
            </div>
            <div class="col-md-1 mt-5">
                <a href="#" class="offline-remove cmn-remove btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
            </div>
        </div>`;
            }

            $('#offline-add').click(function() {
                const uniqueId = Date.now();
                $('#offline').append(addNewOfflineServiceRow(uniqueId));
            });

            $('#offline, .included-package').on('click', '.offline-remove', function(e) {
                e.preventDefault();
                $(this).closest('.input').remove();
            });

            function addNewServiceRow(uniqueId) {
                return `<div class="input my-4 row">
            <div class="col-md-3">
                <div class="user--profile mb-5">
                    <div class="thumb">
                        <img src="{{ asset('assets/images/no-image.png') }}" alt="clients" class="img-fluid">
                    </div>
                    <div class="content">
                        <div class="mt-4">
                            <label for="profile-image-upload-${uniqueId}" class="btn btn-sm btn--base text--dark">
                                Upload Service Image
                                <input class="profile-image-upload" type="file" id="profile-image-upload-${uniqueId}" name="image[]" hidden>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <label for="title-${uniqueId}" class="me-3">Title</label>
                <input id="title-${uniqueId}" name="include_service_title[]" type="text" class="form-control">
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <a href="#" class="online-remove cmn-remove2 btn btn-danger btn-sm mt-0"><i class="fa fa-trash"></i></a>
            </div>
        </div>`;
            }

            $('#online-add').click(function() {
                const uniqueId = Date.now();
                $('#online').append(addNewServiceRow(uniqueId));
            });

            $('#online, .included-package').on('click', '.online-remove', function(e) {
                e.preventDefault();
                $(this).closest('.input').remove();
            });
            // include service package end

            // Additional package start
            function updateProductImagePreview(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $(input).closest('.product--image').find('.thumb img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function productPicURL(input) {
                if (input.files && input.files[0]) {
                    var uploadedFile = new FileReader();
                    uploadedFile.onload = function (e) {
                        var preview = $(input).closest('.product--image').find('.thumb');
                        preview.html(`<img src="${e.target.result}" alt="user" class="img-fluid">`);
                        preview.addClass('image-loaded');
                        preview.hide();
                        preview.fadeIn(650);
                    }
                    uploadedFile.readAsDataURL(input.files[0]);
                }
            }

            $(document).on('change', '.product-image-upload', function() {
                if ($(this).attr('id') === 'product-image-upload') {
                    productPicURL(this);
                } else {
                    updateProductImagePreview(this);
                }
            });

            function addNewAdditionalRow(uniqueId) {
                return `<div class="input my-4 row">
            <div class="col-md-3">
                <div class="product--image">
                    <div class="thumb">
                        <img src="{{ asset('assets/images/no-image.png') }}" alt="clients" class="img-fluid">
                    </div>
                    <div class="content">
                        <div class="mt-4">
                            <label for="product-image-upload-${uniqueId}" class="btn btn-sm btn--base text--dark">
                                Upload Product Image
                                <input class="product-image-upload" type="file" id="product-image-upload-${uniqueId}" name="product_image[]" hidden>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5">
                <label for="title-${uniqueId}" class="me-3">Title</label>
                <input id="title-${uniqueId}" name="additional_service_title[]" type="text" class="form-control">
            </div>
            <div class="col-md-2 mt-5">
                <label for="price-${uniqueId}" class="me-3">Price</label>
                <input id="price-${uniqueId}" name="additional_service_price[]" type="text" class="form-control">
            </div>
            <div class="col-md-2 mt-5">
                <label for="quantity-${uniqueId}" class="me-3">Quantity</label>
                <input id="quantity-${uniqueId}" name="additional_service_quantity[]" type="text" class="form-control">
            </div>
            <div class="col-md-1 mt-5">
                <a href="#" class="add-remove cmn-remove btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
            </div>
        </div>`;
            }

            $('#additional-add').click(function() {
                const uniqueId = Date.now();
                $('#additional').append(addNewAdditionalRow(uniqueId));
            });

            $('#additional, .included-package').on('click', '.add-remove', function(e) {
                e.preventDefault();
                $(this).closest('.input').remove();
            });
            // Additional package end

            // Benefits of the package start
            $('#benefits-add').click(function(){
                $('#benefits').append(
                    `<div class="input my-4 row">
                    <div class="col-md-11">
                        <input id="title" name="benefits[]" type="text" class="form-control" placeholder="Type Here" >
                    </div>
                    <div class="col-md-1">
                        <a href="#" class="benefit-remove cmn-remove2 btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </div>
                </div>`
                )
            })

            $('#benefits, .included-package > .row').on('click', '.benefit-remove', function(e){
                e.preventDefault();
                $(this).parent().parent('div').remove();
            })
            // Benefits of the package end

            // Faq of the package start
            $('#faq-add').click(function(){
                $('#faq').append(
                    `<div class="input my-4 row">
                    <div class="col-md-5">
                        <input id="title" name="faq_title[]" type="text" class="form-control" placeholder="Type Here" >
                    </div>

                    <div class="col-md-6">
                        <textarea class="form-control nic-edit"  name="faq_detail[]" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-md-1">
                        <a href="#" class="faq-remove cmn-remove btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </div>
                </div>`
                )

            })

            $('#faq, .included-package > .row').on('click', '.faq-remove', function(e){
                e.preventDefault();
                $(this).parent().parent('div').remove();
            })
            // Faq of the package end

        })
    </script>

@endpush
