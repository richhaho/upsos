@if ($paginator->hasPages())
<div class="paginatation wow animate fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
    <ul class="paginate">
        @if ($paginator->onFirstPage())
        <li><a href="#">@lang('Previous')</a></li>
        @else
        <li><a href="{{ $paginator->previousPageUrl() }}">@lang('Previous')</a></li>
        @endif


        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active">
                            <a class="">0{{ $page }}</a>
                        </li>
                    @else
                        <li class="">
                            <a class="" href="{{ $url }}">0{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
        <li class="">
            <a class="" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('Next')</a>
        </li>
    @else
        <li class="">
            <a class="" href="#">@lang('Next')</a>
        </li>
    @endif
</ul>
</div>
@endif
