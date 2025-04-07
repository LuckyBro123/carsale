	@extends("test.layout_test_charts")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,12) . '.webp')}}" type="image/x-icon">
		<title>{{$page_title ?? "3 columns & 14 blocks"}}</title>
		<x-bootstrap_5_and_my_mod/>
		<x-jquery_with_cookie/>
		<!-- DRAG DROP FILES-->
		<x-sortable_2_plugins/>
		{{--  --}}
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<x-color_theme_loader/>
		<link href="{{asset('/css/test_3columns_14blocks.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/compare.css')}}" rel="stylesheet"/>
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		<script src="{{asset('/js/test_3columns_14blocks.js')}}" type="text/javascript"></script>
		
		{{--	for debugging --}}
		@if (config('app.debug') && !config('app.FREE_HOSTING'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
		{{--		<link href="fontawesome/css/fontawesome_all.min.css" rel="stylesheet">--}}
	</head>
@endsection

@section("content")
	{{-- CONTENT --}}
	<content>
		@include("test.content_3columns_14blocks")
	</content>
@endsection


