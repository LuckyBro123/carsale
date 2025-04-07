@props (["title","color","photos_amount"])<!---->
<?php
switch ($color) {
	case "green" :
		$classes = "card-success";
		break;
	case "red" :
		$classes = "card-danger";
		break;
	case "yellow" :
		$classes = "card-warning";
		break;
	default:
	case "blue" :
		$classes = "card-primary";
		break;
}
?>
<div class="card card_create_car {{$classes}}">
	<div class="card-header d-flex justify-content-between">
		<h3 class="card-title">{{$title}}</h3>
		@if($title == __("Photos"))
			<h3 class="card-title photos_amount">{{$photos_amount}}</h3>
		@endif
	</div>
	<div class="card-body">{{$slot}}</div>
</div>