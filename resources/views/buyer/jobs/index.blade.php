@extends('layouts.user') @push('css') @endpush @section('contents')
<div class="breadcrumb-area">
    <h3 class="title">@lang('My Jobs')</h3>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route('buyer.dashboard') }}">@lang('Dashboard')</a>
        </li>
        <li>
            @lang('All Jobs')
        </li>
    </ul>
</div>

<div class="text-right mr-0">
    <a class="btn add-btn float-end" href="{{ route('buyer.job.create') }}">@lang('Add New Job')</a>
</div>
<div class="dashboard--content-item">
    @foreach ($jobs as $item)
    <div class="card mb-2">
        <div class="card-body text--black">
            <div class="row">
                <div class="col-12 col-lg-2 col-xl-2 col-md-4 col-sm-12">
                    <img class="img-fluid" src="{{ asset('assets/images/'.$item->image) }}" alt="" />
                </div>

                <div class="col-12 col-lg-5 col-xl-5 col-md-8 col-sm-12 mt-2">
                    <h5 class="card-title text--black">{{ $item->job_title }}</h5>

                    <ul class="d-flex">
                        <li class="me-5">@lang('Total Request'): ({{ $item->Jobrequests()->count() }})</li>
                        <li><i class="fa fa-eye" aria-hidden="true"></i> ({{ $item->views }})</li>
                    </ul>

                    <div class="data mt-4">
                        <div class="queue {{ $item->is_service_online == 1 ? 'bg-success' : 'bg-danger' }} text-light   d-inline px-5 py-3 rounded">
                            {{ $item->is_job_online == 1 ? 'Online' : 'Offline' }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('buyer.job.edit', $item->id) }}" class="btn btn-primary me-2">@lang('Edit')</a>

                        <button  id="delete"  data-href="{{ route('buyer.job.delete', $item->id) }}" class="btn btn-danger btn-sm me-2">@lang('Delete')</button>

                        <a class="btn btn-warning me-2" href="{{ route('front.jobdetails',$item->job_slug) }}">@lang('Show Job Post')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach @include('partials.front.delete')
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
