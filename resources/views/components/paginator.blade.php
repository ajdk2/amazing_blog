<!-- Pager-->
@if ($paginator->hasPages())
    <div class="d-flex mb-4">
        @if (!$paginator->onFirstPage())
            <a class="btn btn-primary text-uppercase me-auto" href="{{ $paginator->previousPageUrl() }}">← Newer
                Posts</a>
        @endif

        @if ($paginator->hasMorePages())
            <a class="btn btn-primary text-uppercase ms-auto" href="{{ $paginator->nextPageUrl() }}">Older Posts →</a>
        @endif
    </div>
@endif
