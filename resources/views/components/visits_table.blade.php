@php
	use Carbon\Carbon;
@endphp
<div class="visits_table_wrapper">
	<x-simple_paginator_for_visits classes="mt-2 mb-1" :visits="$visits"/>
	<x-columns_sorting_row_for_visits classes="" sort-mode="{{$sortMode}}"/>
	<ul class="visits_table">
		@foreach ($visits as $visit)
				<?php
				$country = getCountryByIp($visit->ip);
				$utcTime = Carbon::parse($visit->time)->toISOString();
				?>
			<li class="visits_table_item" visit_id="{{$visit->id}}">
				<span>{{$visit->ip}}</span><span>{{$country}}</span><span>{{$visit->method}}</span><span>{{$visit->url}}</span><span class="timestamp" data-time="{{$utcTime}}"></span>
			</li>
		@endforeach
	</ul>
	<x-columns_sorting_row_for_visits classes="" sort-mode="{{$sortMode}}"/>
	<x-simple_paginator_for_visits classes="mt-2 mb-2" :visits="$visits"/>
</div>