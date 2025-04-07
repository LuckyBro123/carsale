<?php
$width = isset($width) ? $width : "1rem";
$height = isset($height) ? $height : $width;
// отступ справа от иконки и стили, если есть
$marginRight = isset($padding) ? "margin-right: $padding;" : "";
if (!empty($styles)) $marginRight .= $styles;
?>

@if(!empty($iconname) )
	<svg width="{{$width}}" height="{{$height}}" class="{{$classes ?? ""}}" style="{{$marginRight}}">
		<use xlink:href="#{{$iconname}}"></use>
	</svg>
@endif
