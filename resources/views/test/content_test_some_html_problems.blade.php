<div class="container-fluid contacts_container">
	<div class="contacts">
		<div class="row justify-content-center">
			<div class="col-12">
				<ul>
					@foreach($jeeps as $jeep)
						@break($loop->index == 1)
					<span>id = {{$jeep->id}}</span>
						<li class="card_photo_holder">
							@foreach($jeep->photos as $photo)
								@php
									$carPhotoURL = asset(Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($photo->filename, PATHINFO_FILENAME) . ".webp"));
								@endphp
								<img src="{{$carPhotoURL}}" class="card-img-top" alt="car photo" style="width: 200px">
							@endforeach
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
<style></style>