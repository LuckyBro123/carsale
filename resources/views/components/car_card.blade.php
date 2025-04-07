<?php
$URLforCard = route("car.view", [$car->id]);
$carId = $car->id;

if ($car->photos->count()) $carPhotoURL = Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($car->photos[0]->filename, PATHINFO_FILENAME) . ".webp");
else $carPhotoURL = "";

$carPrice = number_format($car->price, 0, "", " ") . " $";

if (app()->getLocale() == "ru") $carMileage = number_format($car->mileage, 0, "", " ") . " " . __("km");
else $carMileage = number_format(round($car->mileage / 1.609), 0, "", " ") . " " . __("m");

$wasInAccident = $car->was_in_accident ? "Yes" : "No";
?>
<div class="col-6 col-sm-4 col-lg-3 col-xl-5cols col-xxl-2 ps-0 ps-sm-0 pe-2 pe-sm-2 mb-sm-2 car_card_container">
	<div id="car_card{{$carId}}" class="card car_card" carid="{{$carId}}">
		<a href="{{$URLforCard}}" class="card_url">
			@if($carPhotoURL)
				<div class="card_photo_holder">
					<img src="{{$carPhotoURL}}" class="card-img-top" alt="car photo">
				</div>
			@else
				<div class="card_no_photo">{{__("NO PHOTO")}}</div>
			@endif
			<div class="card-body">
				<h6 class="car_name">{{$car->fullName}}</h6>
				<h6 class="car_price">{{$carPrice}}</h6>
				<p class="d-none d-sm-block card-text car_year_mileage">{{$car->production_year}}, {{$carMileage}}</p>
				<p class="d-sm-none card-text car_year_mileage">{{$car->production_year}}</p>
				<p class="d-sm-none card-text car_year_mileage">{{$carMileage}}</p>
			</div>
		</a>
		<label class="car_card_icons icon_compare">
			<input {{$isCompareIconChecked}} type="checkbox" class="input_compare" carid="{{$carId}}">
			<div class="icons">
				<x-svg_icon iconname="i_compare" width="1.15rem" height="1.15rem"/>
				<x-svg_icon iconname="i_compare_on" width="1.15rem" height="1.15rem"/>
			</div>
		</label>
		<label class="car_card_icons icon_favorite">
			<input {{$isFavoriteIconChecked}} type="checkbox" class="input_favorite" carid="{{$carId}}">
			<div class="icons">
				<x-svg_icon iconname="i_favorite" width="1.15rem" height="1.15rem"/>
				<x-svg_icon iconname="i_favorite_on" width="1.15rem" height="1.15rem"/>
			</div>
		</label>
		{{-- данные для расширенной карточки --}}
		<div id="test_id" class="d-none data_holder" fullname="{{$car->fullName}}" price="{{$carPrice}}" year="{{$car->production_year}}" mileage="{{$carMileage}}" gearbox="{{__($car->gearbox->name)}}" engine_capacity="{{$car->engine_capacity}}" engine_power="{{$car->engine_power}}" fuel_consumption="{{$car->fuel_consumption}}" wheelbase="{{$car->wheelbase}}" number_doors="{{$car->number_doors}}" was_in_accident="{{__($wasInAccident)}}">
			<div class="microphoto_set_for_ext_car_card d-none">
				<?php
				for ($i = 0; $i < 5; $i++) {
					$carPhotos[] = isset($car->photos[$i]) ? Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($car->photos[$i]->filename, PATHINFO_FILENAME) . ".webp") : "";
				}
				?>
				@foreach($carPhotos as $photo)
					@if($photo == "")
						<div class="ext_card_empty_img"></div>
					@else
						<img imgurl="{{$photo}}" class="ext_car_card_microphoto" alt="car photo">
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>