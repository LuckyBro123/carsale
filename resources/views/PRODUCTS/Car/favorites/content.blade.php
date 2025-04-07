<div class="container no_cars_in_favorits {{$cars->count() ? "d-none" : ""}}">
	<div class="row">
		<div class="col d-flex justify-content-center ">
			<span class="fs-2 fw-bolder" style="line-height: 20rem;">No cars in favorits</span>
		</div>
	</div>
</div>
<div class="content container pt-0 pb-1 {{$cars->count() ? "" : "d-none"}}">
	<div class="row justify-content-center">
		<div class="col-8 col-sm-5 col-md-4 mt-2 mb-2 mt-sm-3 mb-sm-2">
			<a id="clear_favorites" class="w-100 btn btn-outline-secondary lh-sm ">{{__("Clear favorites")}}</a>
		</div>
	</div>
	<x-simple_paginator_for_goods classes="" :goods="$cars"/>
	<x-sorting_and_per_page classes="mt-2 mb-1" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$cars->lastPage()" :currentPage="$cars->currentPage()" :currentPerPage="$cars->perPage()"/>
	<div class="row">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-1 pt-sm-0 goods_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($cars as $car)
					<?php
					$isFavoriteIconChecked = in_array($car->id, $favoritesElems) ? " checked " : "";
					$isCompareIconChecked = in_array($car->id, $compareElems) ? " checked " : "";
					?>
				{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}
				<x-car_card :car="$car" :isFavoriteIconChecked="$isFavoriteIconChecked" :isCompareIconChecked="$isCompareIconChecked"/>
			@endforeach
		</div>
	</div>
	<x-sorting_and_per_page classes="mb-1" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$cars->lastPage()" :currentPage="$cars->currentPage()" :currentPerPage="$cars->perPage()"/>
	<x-simple_paginator_for_goods classes="mt-1 mb-2 mb-sm-3" :goods="$cars"/>
</div>