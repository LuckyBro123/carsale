<?php
$cardOrListViewMode = $cardOrListViewMode ?? "";
$cardOrListViewMode = isDesktopViewport() ? $cardOrListViewMode : "";
?>
<div class="row sorting_and_per_page {{$classes}} p-0 justify-content-center justify-content-md-between">
	<div class="col-12 col-sm-auto d-flex justify-content-center mt-1 mt-sm-0 py-1">
		{{-- Grid view mode button --}}
		@if($cardOrListViewMode)
			<a href="{{route('cars.cardview', request()->except(['is_allowed_IP', 'is_admin']))}}" class="d-none d-sm-inline-flex btn ps-0 pe-2 icon_viewmode {{$cardOrListViewMode == "card" ? "viewmode_on" : ""}}" title="{{__("Card view mode")}}">
				<x-svg_icon iconname="i_card_viewmode"/>
			</a>
			<a href="{{route('cars.listview', request()->except(['is_allowed_IP', 'is_admin']))}}" class="d-none d-sm-inline-flex btn ps-0 pe-2 me-1 icon_viewmode {{$cardOrListViewMode == "row" ? "viewmode_on" : ""}}" title="{{__("List view mode")}}">
				<x-svg_icon iconname="i_row_viewmode"/>
			</a>
		@endif
		{{-- SORTING SELECTOR --}}
		<label class="align-self-center">{{__("Sort by")}}</label>
		<select id="sort_mode" class="form-select form-select-sm">
			@foreach ($allSortModes as $sortModeTitle => $sortModeText)
				<option value="{{$sortModeTitle}}" {{$sortMode == $sortModeTitle ? "selected" : ""}}>{{__($sortModeText)}}</option>
			@endforeach
		</select>
	</div>
	@if($pagesAmount > 4)
		<div class="col-12 col-sm-auto d-flex justify-content-center py-1">
			{{-- PAGE NUMBERS SELECTOR --}}
			<label class="align-self-center">{{__("Page №")}}</label>
			@if($pagesAmount > 30)
				{{-- будет использован input для выбора номера страницы --}}
				<div class="input-group input-group_page_number">
					<input name="page_number" type="number" class="form-control page_number" autocomplete="off" value="{{$currentPage}}" min="{{1}}" max="{{$pagesAmount}}" maxlength="4">
					<button class="btn btn-outline-secondary btn_page_number_submit" type="button">
						<x-svg_icon iconname="i_search" styles="width: 1.2rem; height: 0.85rem !important;"/>
					</button>
				</div>
			@else
				{{-- будет использован select для выбора номера страницы --}}
				<select id="page_numbers" class="form-select form-select-sm">
					@for ($number = 1; $number <= $pagesAmount; $number++)
						<option value="{{$number}}" {{$number == $currentPage ? "selected" : ""}}>{{$number}}</option>
					@endfor
				</select>
			@endif
		</div>
	@endif
	<div class="col-12 col-sm-auto d-flex justify-content-center mb-1 mb-sm-0 py-1">
		{{-- PER PAGE NUMBER SELECTOR --}}
		<label class="align-self-center">{{__("Per page")}}</label>
		<select id="elems_per_page" class="form-select form-select-sm">
			<option value="15" {{$currentPerPage == "15" ? "selected" : ""}}>15</option>
			<option value="20" {{$currentPerPage == "20" ? "selected" : ""}}>20</option>
			<option value="30" {{$currentPerPage == "30" ? "selected" : ""}}>30</option>
			<option value="50" {{$currentPerPage == "50" ? "selected" : ""}}>50</option>
			<option value="100" {{$currentPerPage == "100" ? "selected" : ""}}>100</option>
		</select>
	</div>
</div>







