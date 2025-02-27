@if ($paginator->hasPages())
    <div class="dataTable-bottom">
        <div class="dataTable-info">
            {!! __('pagination.showing') !!}
            {!! __('pagination.from') !!}
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            {!! __('pagination.to') !!}
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {!! __('pagination.of') !!}
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            {!! \Str::lower(__('pagination.results')) !!}
        </div>

        <div class="dataTable-pagination">
            <ul class="dataTable-pagination-list pagination pagination-primary">
                {{-- Previous Page Link --}}
                @if (!$paginator->onFirstPage())
                    <li class="pager page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span
                                class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="pager page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                            aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
