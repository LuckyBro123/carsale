<div class="form-group">
	<label for="{{$name}}">
		@if(!empty($iconname))
			<x-svg_icon iconname="{{$iconname}}" padding="0.1rem"/>
		@endif
		<span>{{$title}}</span>
	</label>
	<select class="form-select" id="{{$name}}" name="{{$name}}" placeholder="{{__("Select brand")}}" {{$attributes->except(["name","title","options","value"])}}>
		@foreach($options as $option)
			<option {{$option == $value ? "selected" : ""}} value="{{$option}}">{{__($option)}}</option>
		@endforeach
	</select>
</div>