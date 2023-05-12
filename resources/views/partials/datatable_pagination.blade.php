@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{--<li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">&lsaquo;</span>
            </li>--}}
            <li class="paginate_button page-item previous disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            {{--<li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>--}}
            <li class="paginate_button page-item previous">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link">Previous</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                {{--<li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>--}}
                <li class="paginate_button page-item disabled">
                    <span class="page-link">{{ $element }}</a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{--<li class="active" aria-current="page"><span>{{ $page }}</span></li>--}}
                        <li class="paginate_button page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        {{--<li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                        <li class="paginate_button page-item">
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            {{--<li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>--}}
            <li class="paginate_button page-item next">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next</a>
            </li>
        @else
            {{--<li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">&rsaquo;</span>
            </li>--}}
            <li class="paginate_button page-item next disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
@endif


{{--<ul class="pagination">
    <li class="paginate_button page-item previous disabled" id="table-2_previous">
        <a href="#" aria-controls="table-2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
    </li>
    <li class="paginate_button page-item active">
        <a href="#" aria-controls="table-2" data-dt-idx="1" tabindex="0" class="page-link">1</a>
    </li>
    <li class="paginate_button page-item ">
        <a href="#" aria-controls="table-2" data-dt-idx="2" tabindex="0" class="page-link">2</a>
    </li>
    <li class="paginate_button page-item next" id="table-2_next">
        <a href="#" aria-controls="table-2" data-dt-idx="3" tabindex="0" class="page-link">Next</a>
    </li>
</ul>--}}