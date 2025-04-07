@extends("visits.layout")

@section("tag_head")
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		@include("common_sections.meta_tags")
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{asset('/img/favicons\favicon' . mt_rand(1,12) . '.webp')}}" type="image/x-icon">
		<title>{{$page_title ?? "посещения"}}</title>
		<x-bootstrap_5_and_my_mod/>
		<x-jquery_with_cookie/>
		{{--  --}}
		<script src="{{asset('/js/_my_functions_lib.js')}}" type="text/javascript"></script>
		<link href="{{asset('/css/my_reset.css')}}" rel="stylesheet"/>
		<link href="{{asset('/css/visits.css')}}" rel="stylesheet"/>
		<script src="{{asset('/js/main__visits.js')}}" type="module"></script>
		{{--	for debugging --}}
		@if (config('app.debug') && !config('app.FREE_HOSTING'))
			<script src="{{asset('/plugins/live_only_JS_and_css.js')}}" type="text/javascript"></script>
			<script src="{{asset('/plugins/faker-5.5.3.min.js')}}" type="text/javascript"></script>
		@endif
	</head>
@endsection

@section("content")
	{{-- CONTENT таблица с всеми посещениями сайта --}}
	<content>
		@include("visits.content")
	</content>
@endsection

@section("storage__svg_icons")
	@include("common_sections.storage__svg_icons")
@endsection


