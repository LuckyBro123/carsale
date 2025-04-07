<div class="col-6 col-md-4 col-lg-3 col-xl-5cols col-xxl-2 ps-0 ps-sm-0 pe-2 pe-sm-2 mb-2 car_card_container">
	<div id="car_card{{$ssdId}}" class="card car_card" ssdid="{{$ssdId}}">
		@if($ssdPhotoUrl)
			<div class="card_photo_holder">
				<img src="{{$ssdPhotoUrl}}" class="card-img-top laptop-phone-ssd_card_photo" alt="ssd photo">
			</div>
		@else
			<div class="card_no_photo">{{__("NO PHOTO")}}</div>
		@endif
		<div class="card-body">
			<h6 class="car_name">{{$ssdTitle}}</h6>
			<h6 class="car_price">{{$ssdPrice}}</h6>
			<p class="d-none d-sm-block card-text car_parameters">{{$ssdCapacity}} / {{$ssdSpeedReadWrite}}</p>
			<p class="d-sm-none card-text car_parameters">{{$ssdCapacity}}</p>
			<p class="d-sm-none card-text car_parameters">{{$ssdSpeedReadWrite}}</p>
		</div>
		<label class="car_card_icons icon_compare">
			<input {{$isCompareIconChecked}} type="checkbox" class="input_compare" ssdid="{{$ssdId}}">
			<div class="icons">
				<x-svg_icon iconname="i_compare" width="1.15rem" height="1.15rem"/>
				<x-svg_icon iconname="i_compare_on" width="1.15rem" height="1.15rem"/>
			</div>
		</label>
		<label class="car_card_icons icon_favorite">
			<input {{$isFavoriteIconChecked}} type="checkbox" class="input_favorite" ssdid="{{$ssdId}}">
			<div class="icons">
				<x-svg_icon iconname="i_favorite" width="1.15rem" height="1.15rem"/>
				<x-svg_icon iconname="i_favorite_on" width="1.15rem" height="1.15rem"/>
			</div>
		</label>
	</div>
</div>
