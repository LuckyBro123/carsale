<?php
$dnone = $visits->hasPages() ? "" : "d-none";
?>
<div class="row paginator_container {{$dnone}}">
	<div class="col text-center align-items-stretch {{$classes}}">
		{{$visits->withQueryString()->onEachSide(0)->links("vendor.pagination.goods_paginator_BS5")}}
	</div>
</div>