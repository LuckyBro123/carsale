<div class="container content">
	<x-simple_paginator_for_goods classes="" :goods="$goods"/>
	<x-sorting_and_per_page classes="mt-2 mb-1" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$goods->lastPage()" :currentPage="$goods->currentPage()" :currentPerPage="$goods->perPage()" cardOrListViewMode="{{$cardOrListViewMode}}"/>
	<div class="row">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-1 pt-sm-0 goods_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($goods as $car)
				{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}

					<?php
					$isFavoriteIconChecked = in_array($car->id, $favoritesElems) ? " checked " : "";
					$isCompareIconChecked = in_array($car->id, $compareElems) ? " checked " : "";
					?>
				@if($cardOrListViewMode == "card")
					<x-car_card :car="$car" :isFavoriteIconChecked="$isFavoriteIconChecked" :isCompareIconChecked="$isCompareIconChecked"/>
				@else
					<x-car_row :car="$car" :isFavoriteIconChecked="$isFavoriteIconChecked" :isCompareIconChecked="$isCompareIconChecked"/>
				@endif
			@endforeach
		</div>
	</div>
	<x-sorting_and_per_page classes="mt-2 mt-md-0 mb-2" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$goods->lastPage()" :currentPage="$goods->currentPage()" :currentPerPage="$goods->perPage()" cardOrListViewMode="{{$cardOrListViewMode}}"/>
	<x-simple_paginator_for_goods classes="mt-1 mb-2 mb-sm-3" :goods="$goods"/>
</div><!-- ▪▪▪▪▪▪▪▪▪▪▪ заготовка EXTENDED_CAR_CARD ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
<div id="extCard_FOR_CLONE" class="card car_card extended_car_card d-none" card_id="">
	<a class="card_url position-relative" href="">
		<div class="ext_card_photo_holder">
			<img src="" class="ext_car_card_photo" alt="car photo">
		</div>
		<div class="ext_car_card_microphoto_set d-flex justify-content-between mt-2 mb-3 mx-2">
			@for ($i = 0; $i < 5; $i++)
				<div class="ext_card_empty_img"></div>
			@endfor
		</div>
		<div class="card-body pt-0 "></div>
		<div class="ext_card_footer">
			<a href="" class="btn btn-outline-success btn-sm" style="min-width: 6rem;line-height: 1.2;">{{__("Details")}}</a>
		</div>
	</a>
</div>