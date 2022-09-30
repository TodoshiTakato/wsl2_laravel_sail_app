@if($paginator->hasPages())
    <ul class="pages">

        {{-- Pagination Elements --}}
        @if($paginator->onFirstPage())

        @else
            <li>
                <a href="{{$paginator->previousPageUrl()}}">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach($elements as $element)

            {{-- "Three Dots" Separator --}}
            @if(is_string($element)) <li><a>...</a></li> @endif

            {{-- Array Of Links --}}
            @if(is_array($element))
                @foreach($element as $page => $url)

                    {{-- Current Page --}}
                    @if($page == $paginator->currentPage())
                        <li class="active">
                            <a>
                                {{$page}}
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{$paginator->url($page)}}">
                                {{$page}}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if($paginator->hasMorePages())
            <li>
                <a href="{{$paginator->nextPageUrl()}}">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
        @else

        @endif
    </ul>
@endif
