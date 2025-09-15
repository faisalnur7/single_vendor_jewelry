@if ($paginator->lastPage() > 1)
    @php
        $total = $paginator->lastPage(); // total pages
        $current = $paginator->currentPage();
        $range = 2; // pages to show on each side of current page
    @endphp

    <nav class="flex items-center space-x-2">
        {{-- Previous --}}
        @if ($current > 1)
            <a href="{{ $paginator->url($current - 1) }}"
               class="px-4 py-2 rounded-full bg-white border text-black text-xl hover:bg-black hover:text-white transition-all duration-200">
                &lt;
            </a>
        @endif

        {{-- First page --}}
        @if ($current > 2 + $range)
            <a href="{{ $paginator->url(1) }}"
               class="px-4 py-2 rounded-full bg-white border text-black text-xl hover:bg-black hover:text-white transition-all duration-200">
                1
            </a>
            <span class="px-3 py-2 rounded-full bg-white border text-black text-xl">...</span>
        @endif

        {{-- Pages around current --}}
        @for ($i = max(1, $current - $range); $i <= min($total, $current + $range); $i++)
            @if ($i == $current)
                <span class="px-5 py-3 rounded-full bg-black text-white text-xl font-semibold transition-all duration-200">
                    {{ $i }}
                </span>
            @else
                <a href="{{ $paginator->url($i) }}"
                   class="px-4 py-2 rounded-full bg-white border text-black text-xl hover:bg-black hover:text-white transition-all duration-200">
                    {{ $i }}
                </a>
            @endif
        @endfor

        {{-- Last page --}}
        @if ($current < $total - $range - 1)
            <span class="px-3 py-2 rounded-full bg-white border text-black text-xl">...</span>
            <a href="{{ $paginator->url($total) }}"
               class="px-4 py-2 rounded-full bg-white border text-black text-xl hover:bg-black hover:text-white transition-all duration-200">
                {{ $total }}
            </a>
        @endif

        {{-- Next --}}
        @if ($current < $total)
            <a href="{{ $paginator->url($current + 1) }}"
               class="px-4 py-2 rounded-full bg-white border text-black text-xl hover:bg-black hover:text-white transition-all duration-200">
                &gt;
            </a>
        @endif
    </nav>
@endif
