@php
	if ($sortMode == "ip_asc") $sortingIpURL = request()->url() . '?visits_sort_mode=ip_desc';
	else if ($sortMode == "ip_desc") $sortingIpURL = request()->url() . '?visits_sort_mode=ip_asc';
	else $sortingIpURL = request()->url() . '?visits_sort_mode=ip_desc';
	
	if ($sortMode == "method_asc") $sortingMethodURL = request()->url() . '?visits_sort_mode=method_desc';
	else if ($sortMode == "method_desc") $sortingMethodURL = request()->url() . '?visits_sort_mode=method_asc';
	else $sortingMethodURL = request()->url() . '?visits_sort_mode=method_desc';

	if ($sortMode == "url_asc") $sortingUrlURL = request()->url() . '?visits_sort_mode=url_desc';
	else if ($sortMode == "url_desc") $sortingUrlURL = request()->url() . '?visits_sort_mode=url_asc';
	else $sortingUrlURL = request()->url() . '?visits_sort_mode=url_desc';

	if ($sortMode == "time_asc") $sortingTimeURL = request()->url() . '?visits_sort_mode=url_desc';
	else if ($sortMode == "time_desc") $sortingTimeURL = request()->url() . '?visits_sort_mode=time_asc';
	else $sortingTimeURL = request()->url() . '?visits_sort_mode=time_desc';
@endphp
<div class="columns_sorting {{$sortMode}}" sorting_mode="{{$sortMode}}">
	<a href="{{$sortingIpURL}}" class="sorting_ip" data-func="sorting_ip">{{__("IP")}}</a><a class="country">{{__("country")}}</a><a href="{{$sortingMethodURL}}" class="sorting_method" data-func="sorting_method">{{__("method")}}</a><a href="{{$sortingUrlURL}}" class="sorting_url" data-func="sorting_url">{{__("URL")}}</a><a href="{{$sortingTimeURL}}" class="sorting_time" data-func="sorting_time">{{__("time")}}</a>
</div>