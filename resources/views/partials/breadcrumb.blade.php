@if(isset($breadcrumbs) && is_array($breadcrumbs))
<nav aria-label="breadcrumb" class="mt-3 mb-4">
  <ol class="breadcrumb bg-light px-3 py-2 rounded shadow-sm mb-0">
    @foreach($breadcrumbs as $breadcrumb)
      @if(!$loop->last)
        <li class="breadcrumb-item d-flex align-items-center">
          <i class="fas fa-angle-right text-muted mr-2"></i>
          <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none text-primary">
            {{ $breadcrumb['title'] }}
          </a>
        </li>
      @else
        <li class="breadcrumb-item active d-flex align-items-center text-muted" aria-current="page">
          <i class="fas fa-angle-right text-muted mr-2"></i>
          {{ $breadcrumb['title'] }}
        </li>
      @endif
    @endforeach
  </ol>
</nav>
@endif
