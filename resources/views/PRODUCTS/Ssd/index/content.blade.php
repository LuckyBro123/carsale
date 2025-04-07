<div class="content container pt-0 pb-1">
	<x-simple_paginator_for_goods classes="" :goods="$goods"/>
	<x-sorting_and_per_page classes="mt-2 mb-1" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$goods->lastPage()" :currentPage="$goods->currentPage()" :currentPerPage="$goods->perPage()"/>
	<div class="row">
		<div class="d-flex flex-wrap ps-2 pe-0 pt-1 pt-sm-0 goods_list_container"> <!-- ОБЁРТКА ЧТОБЫ ВЫРОВНЯТЬ ОТСТУПЫ МЕЖДУ CARDs-->
			@foreach ($goods as $ssd)
					<?php
					$ssdId = $ssd->id;
					$ssdPhotoUrl = $ssd->getPhotoUrl();
					$ssdPrice = number_format($ssd->price, 0, "", " ") . " $";
					$ssdCapacity = $ssd->capacity . 'Mb';
					$ssdSpeedReadWrite = $ssd->speed_read . " / " . $ssd->speed_write;
					$isFavoriteIconChecked = in_array($ssdId, $favoritesElems) ? " checked " : "";
					$isCompareIconChecked = in_array($ssdId, $compareElems) ? " checked " : "";
					?>
				{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}
				<x-ssd_card :ssdId="$ssdId" :ssdPhotoUrl="$ssdPhotoUrl" :ssdTitle="$ssd->fullName" :ssdPrice="$ssdPrice" :ssdCapacity="$ssdCapacity" :ssdSpeedReadWrite="$ssdSpeedReadWrite" :isFavoriteIconChecked="$isFavoriteIconChecked" :isCompareIconChecked="$isCompareIconChecked"/>
			@endforeach
		</div>
	</div>
	<x-sorting_and_per_page classes="mt-2 mt-md-0 mb-2" :allSortModes="$allSortModes" :sortMode="$sortMode" :pagesAmount="$goods->lastPage()" :currentPage="$goods->currentPage()" :currentPerPage="$goods->perPage()"/>
	<x-simple_paginator_for_goods classes="mt-1 mb-2 mb-sm-3" :goods="$goods"/>
</div> <!-- ▪▪▪▪▪▪▪▪▪▪▪  The end of the CONTENT ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
