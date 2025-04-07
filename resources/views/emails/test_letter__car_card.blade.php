<style>
  .container {
    padding: 2rem;
    background-color: #e7e7e7;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .message {
    padding: 2rem 1rem 2rem 1rem;
  }
</style>
<div class="container">
	<?php
	$car = $data["car"];
	$carId = $car->id;
	$URLforCard = route("car.view", [$carId]);
	$carPhotoURL = $message->embed(storage_path('app/public/cars_photos/small_duplicates/' . $car->photos[0]->filename));
	$carPrice = number_format($car->price, 0, "", " ") . " $";
	if (app()->getLocale() == "ru") $carMileage = number_format($car->mileage, 0, "", " ") . " " . __("km");
	else $carMileage = number_format(round($car->mileage / 1.609), 0, "", " ") . " " . __("m");
	?>
{{--▪▪▪ CAR CARD  карточка машины ▪▪▪--}}

	<div class="col-6 col-md-4 col-lg-3 col-xl-5cols col-xxl-2 ps-0 ps-sm-0 pe-2 pe-sm-2 mb-sm-2 car_card_container">
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
		</div>
		<p class="message">{{$data["message"]}}</p>
	</div>
</div>
