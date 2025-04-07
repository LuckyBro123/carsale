@if ($paginator->hasPages())
	<nav class="d-flex justify-items-center justify-content-between">
		<div class="d-flex justify-content-center flex-wrap flex-fill d-sm-none">          {{--  for PHONES --}}
			<p class=" align-items-center justify-content-between	 text-muted p-0 m-0 mb-1 ">
				{!! __('Showing') !!}
				<span class="fw-semibold">{{ $paginator->firstItem() }}</span>
				{!! __('to') !!}
				<span class="fw-semibold">{{ $paginator->lastItem() }}</span>
				{!! __('of') !!}
				<span class="fw-semibold">{{ $paginator->total() }}</span>
			</p>
			<ul class="pagination">
				{{-- First Page Link --}}
				@if ($paginator->onFirstPage())
					<li class="page-item disabled" aria-disabled="true">
						<span class="page-link">«</span>
					</li>
				@else
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->url(1) }}" rel="prev">«</a>
					</li>
				@endif
				
				{{-- Previous Page Link --}}
				@if ($paginator->onFirstPage())
					<li class="page-item disabled" aria-disabled="true">
						<span class="page-link">@lang('pagination.prev')</span>
					</li>
				@else
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.prev')</a>
					</li>
				@endif
				
				{{-- Next Page Link --}}
				@if ($paginator->hasMorePages())
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
					</li>
				@else
					<li class="page-item disabled" aria-disabled="true">
						<span class="page-link">@lang('pagination.next')</span>
					</li>
				@endif
				
				{{-- Last Page Link --}}
				@if ($paginator->hasMorePages())
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">»</a>
					</li>
				@else
					<li class="page-item disabled" aria-disabled="true">
						<span class="page-link">»</span>
					</li>
				@endif
			</ul>
		</div>
		<div class="row d-none flex-sm-fill d-sm-flex flex-sm-wrap align-items-sm-center justify-content-sm-center ">
			{{--  for BIG SCREENs --}}
			<div class="col-12 col-sm-auto d-sm-flex me-sm-0 {{--me-md-3--}} mb-md-0 justify-content-sm-center justify-content-md-start text-sm-center text-md-left align-middle showing_to_of_text">
				<p class="text-muted p-0 m-0">
					{!! __('Showing') !!}
					<span class="fw-semibold">{{ $paginator->firstItem() }}</span>
					{!! __('to') !!}
					<span class="fw-semibold">{{ $paginator->lastItem() }}</span>
					{!! __('of') !!}
					<span class="fw-semibold">{{ $paginator->total() }}</span>
					{{--{!! __('car(s)') !!}--}}
				</p>
			</div>
			<div class="col-12 col-sm-auto  d-flex justify-content-sm-center justify-content-md-end">
				<ul class="pagination mb-1">
					{{-- Previous Page Link --}}
					@if ($paginator->onFirstPage())
						<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
							<span class="page-link" aria-hidden="true">&lsaquo;</span>
						</li>
					@else
						<li class="page-item">
							<a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
						</li>
					@endif
					
					{{-- Pagination Elements --}}
					@foreach ($elements as $element)
						{{-- "Three Dots" Separator --}}
						@if (is_string($element))
							<li class="page-item disabled" aria-disabled="true">
								<span class="page-link">{{ $element }}</span>
							</li>
						@endif
						
						{{-- Array Of Links --}}
						@if (is_array($element))
							@foreach ($element as $page => $url)
								@if ($page == $paginator->currentPage())
									<li class="page-item active" aria-current="page">
										<span class="page-link">{{ $page }}</span>
									</li>
								@else
									<li class="page-item">
										<a class="page-link" href="{{ $url }}">{{ $page }}</a>
									</li>
								@endif
							@endforeach
						@endif
					@endforeach
					
					{{-- Next Page Link --}}
					@if ($paginator->hasMorePages())
						<li class="page-item">
							<a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
						</li>
					@else
						<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
							<span class="page-link" aria-hidden="true">&rsaquo;</span>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
@endif
