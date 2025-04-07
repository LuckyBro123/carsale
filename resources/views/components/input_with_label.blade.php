@props(["name","title","iconname" => "","classes" => ""])
<div class="form-group {{$classes}}">
	<label for="{{$name}}">
		@if(!empty($iconname))
			<x-svg_icon iconname="{{$iconname}}" padding="0.1rem"/>
		@endif
		<span>{{$title}}</span></label>
	<input class="form-control" id="{{$name}}" name="{{$name}}" {{$attributes}}>
</div>
				