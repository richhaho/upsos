@extends('layouts.user')

@push('css')

@endpush

@section('contents')
    <div class="breadcrumb-area">
        <h3 class="title">@lang('My Services')</h3>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
            </li>
            <li>
                @lang('My Services')
            </li>
        </ul>
    </div>
    <div class="text-right mr-0">
        <a class="btn add-btn float-end" href="{{ route('user.add.service') }}">@lang('Add Service')</a>
    </div>



    <div class="dashboard--content-item">

        @foreach ($services as $item)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-2 col-xl-2 col-md-4">
                            <img class="img-fluid" src="{{ asset('assets/images/'.$item->image) }}" alt="">
                        </div>

                        <div class="col-12 col-lg-5 col-xl-5 col-md-8">
                            <h5 class="card-title text--black">{{ $item->title }}</h5>

                            <ul class="d-flex">
                                <li class="me-5 text--black"> <i class="fas fa-star"></i> ({{ ratings($item->id)==null ? 0 : ratings($item->id) }}/5)</li>
                                <li class="text--black"> <i class="fa fa-eye" aria-hidden="true"></i> ({{ $item->view }})</li>
                            </ul>

                            <div class="data mt-4">
                                <div class="queue {{ $item->is_service_online == 1 ? 'bg-success' : 'bg-danger' }} text-light   d-inline px-5 py-3 rounded">
                                    {{ $item->is_service_online == 1 ? 'Online' : 'Offline' }}
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-5">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('user.edit.service', $item->id) }}" class="btn btn-primary me-2">@lang('Edit')</a>

                                <button id="delete"  data-href="{{ route('user.delete.service', $item->slug) }}" class="btn btn-danger btn-sm me-2">@lang('Delete')</button>

                                <a href="{{ route('user.attribute',$item->slug) }}" class="btn btn-success me-2">@lang('Add Attribute')</a>

                                <a class="btn btn-warning me-2" href="{{ route('user.edit.attribute',$item->slug) }}">@lang('Edit Attribute')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @include('partials.front.delete')

    </div>


@endsection

@push('js')
    <script type="text/javascript">
        "use strict";
        $(document).ready(function() {
            $('body').on('click', '#delete', function(e) {
                e.preventDefault();
                var url = $(this).data('href');
                $('#deleteModal').modal('show');
                $('#modaldelete').attr('href', url);
            });
        });

    </script>


@endpush
