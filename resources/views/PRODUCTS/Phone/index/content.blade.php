<div class="content container pt-0 pb-1">
	<x-simple_paginator_for_goods classes="" :goods="$goods"/>
	<x-sorting_and_per_page classes="mt-2 mb-1" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$goods->lastPage()" :currentPage="$goods->currentPage()" :currentPerPage="$goods->perPage()"/>
	<div class="row">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-1 pt-sm-0 goods_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($goods as $phone)
					<?php
					$phoneId = $phone->id;
					$phonePhotoUrl = $phone->getPhotoUrl();
					$phonePrice = number_format($phone->price, 0, "", " ") . " $";
					$phoneDisplaySize = $phone->display_size . '"';
					$phoneRamStorage = $phone->ram . " / " . $phone->storage;
					$isFavoriteIconChecked = in_array($phoneId, $favoritesElems) ? " checked " : "";
					$isCompareIconChecked = in_array($phoneId, $compareElems) ? " checked " : "";
					?>
				{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}
				<x-phone_card :phoneId="$phoneId" :phonePhotoUrl="$phonePhotoUrl" :phoneTitle="$phone->fullName" :phonePrice="$phonePrice" :phoneDisplaySize="$phoneDisplaySize" :phoneRamStorage="$phoneRamStorage" :isFavoriteIconChecked="$isFavoriteIconChecked" :isCompareIconChecked="$isCompareIconChecked"/>
			@endforeach
		</div>
	</div>
	<x-sorting_and_per_page classes="mt-2 mt-md-0 mb-2" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$goods->lastPage()" :currentPage="$goods->currentPage()" :currentPerPage="$goods->perPage()"/>
	<x-simple_paginator_for_goods classes="mt-1 mb-2 mb-sm-3" :goods="$goods"/>
</div> <!-- ▪▪▪▪▪▪▪▪▪▪▪  The end of the CONTENT ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->

