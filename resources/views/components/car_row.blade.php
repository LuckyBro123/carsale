<?php
$carId = $car->id;
$URLforCard = route("car.view", [$carId]);
$photosCount = $car->photos->count() > 10 ? 10 : $car->photos->count();
$photosPlaces = $photosCount == 0 ? 1 : $photosCount;
if ($car->photos->count()) $carPhotoURL = asset(Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($car->photos[0]->filename, PATHINFO_FILENAME) . ".webp"));
else $carPhotoURL = "";
$carPrice = number_format($car->price, 0, "", " ") . " $";
if (app()->getLocale() == "ru") $carMileage = number_format($car->mileage, 0, "", " ") . " " . __("km");
else $carMileage = number_format(round($car->mileage / 1.609), 0, "", " ") . " " . __("m");
$engineCapacity = round($car->engine_capacity / 1000, 1) . __("литры ОДНОЙ буквой");
?>
<div class="col-12 px-0 car_row_container">
	<a href="{{$URLforCard}}" class="card_url">
		<div id="car_row{{$carId}}" class="car_row" carid="{{$carId}}">
			<div class="car_photos photos{{$photosPlaces}}">
				<?php
				try {
					?>
				
				@for ($i = 0; $i < $photosPlaces; $i++)
						<?php if ($i < $photosCount) $carPhotoURL = asset(Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($car->photos[$i]->filename, PATHINFO_FILENAME) . ".webp"));
					else $carPhotoURL = ""; ?>
					@switch($i)
						@case(0)
							@if($carPhotoURL)
								<div class="row_photo_holder">
									<img src="{{$carPhotoURL}}" class="{{--row-img-top--}}" alt="Car Photo {{$i}}">
								</div>
							@else
								<div class="row_no_photo">{{__("NO PHOTO")}}</div>
							@endif
							@break
						@default
							@if($carPhotoURL)
								<div class="row_photo_holder photo_not_loaded">
									<div class="row_no_photo">...</div>
									<img src="" class="{{--row-img-top--}}" alt="Car Photo {{$i}}" imgurl="{{$carPhotoURL}}">
								</div>
							@endif
					@endswitch
				@endfor

					<?php
				} catch (\ErrorException $e) {
					Log::error('Undefined index error', [
						'message' => $e->getMessage(),
						'file'    => $e->getFile(),
						'line'    => $e->getLine()
					]);
				} ?>mb_strtolower($text, 'UTF-8')
			</div>
			<div class="car_info">
				<div class="car_name">{{$car->fullName}}</div>
				<div class="car_details">
					<span>{{$car->production_year}}</span>, {{mb_strtolower(__("Engine"), 'UTF-8')}}
					<span>{{$engineCapacity}}</span>, {{mb_strtolower(__("Mileage"), 'UTF-8')}}
					<span>{{$carMileage}}</span>
				</div>
				<div class="car_price">{{$carPrice}}</div>
			</div>
		</div>
	</a>
</div>

