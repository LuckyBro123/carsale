@php
	$color = $color ?? "blue";
@endphp
<label class="checkbox_ON_OFF {{$color}} pt-1 pb-1" style="">
	<input type="checkbox" class="{{$classes}}" name="{{$name}}" {{$checked}}>
	<div class="checkbox_ON_OFF_switch {{$color}}"></div>
	<span class="checkbox_ON_OFF_text">{{$text}}</span>
</label>