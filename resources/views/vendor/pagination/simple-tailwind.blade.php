@if ($paginator->hasPages())
    <nav>
        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="cursor-default">« Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">« Anterior</a>
        @endif

        {{-- Próximo --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Próximo »</a>
        @else
            <span class="cursor-default">Próximo »</span>
        @endif
    </nav>
@endif