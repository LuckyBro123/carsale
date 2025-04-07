@extends("PRODUCTS.Phone.index.layout")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		@include("common_sections.meta_tags")
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,12) . '.webp')}}" type="image/x-icon">
		<title>{{$page_title ?? "CAR SALE"}}</title>
		<x-bootstrap_5_and_my_mod/>
		<x-jquery_with_cookie/>
		{{--  --}}
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		{{--	для фильтров Ion.RangeSlider  https://github.com/IonDen/ion.rangeSlider  https://jsfiddle.net/IonDen/avcm6wpj/  --}}
		<link href="{{asset('/plugins/ion-rangeslider/css/ion.rangeSlider__my_mod.css')}}" rel="stylesheet">
		<script src="{{asset('/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
		{{--  --}}
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<x-color_theme_loader/>
		<link href="{{asset('/css/index_laptop-phone-ssd.css')}}" rel="stylesheet"/>
		<script src="{{asset('/js/main__index.js')}}" type="module"></script>
		{{--	for debugging --}}
		@if (config('app.debug') && !config('app.FREE_HOSTING'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
	</head>
@endsection

@section("header__logo_search_auth_menu")
	{{-- header__logo_search_auth_menu --}}
	@include("common_sections.header__logo_search_auth_menu")
@endsection

@section("filters")
	{{-- FILTERS --}}
	@include("common_sections.filters")
@endsection

@section("content")
	{{-- CONTENT --}}
	<content>
		@include("PRODUCTS.Phone.index.content")
	</content>
@endsection

@section("footer")
	{{-- FOOTER --}}
	@include("common_sections.footer")
@endsection

@section("switch_language")
	{{-- SWITCH LANGUAGE --}}
	@include("common_sections.switch_language")
@endsection

@section("storage__svg_icons")
	@include("common_sections.storage__svg_icons")
@endsection


