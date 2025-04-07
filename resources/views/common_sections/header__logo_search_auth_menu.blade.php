<?php
$routeHome = route("cars.index");
?>
<header class="container-fluid m-0 p-0 bg-light">
	<div class="black_rect_fullscreen d-none"></div>
	<!--	▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
	<!--	HEADER с меню ДЛЯ МОБИЛКИ                                 -->
	<div class="d-sm-none container-fluid bg-light px-0">
		<nav class="navbar navbar-expand-md navbar-light bg-light mb-0 pb-0 mobile_navbar">
			<div class="container-fluid px-0 logo_block_mobile">
				<div class="w-100 d-flex justify-content-between flex-nowrap">
					
					<a href="{{$routeHome}}" class="d-flex align-items-center justify-content-start mb-1 bg-light car_sale_logo" data-bs-toggle="tooltip" data-bs-title="{{__("Go to start page")}}" style="flex: 0 1 auto">
						<x-svg_icon iconname="svg_logo" width="13.6rem" height="2.5rem" styles="padding-top: 10px; padding-left: 15px;"/>
					</a>
					<button class="navbar-toggler collapsed mt-1 mb-1 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_mobile_red_menu" aria-controls="navbar_mobile_red_menu" aria-expanded="false" aria-label="Переключить навигацию">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
				<div class="col-12 pb-0 pb-sm-3">
					<form id="search_form" class="d-flex" action="/search">
						<div class="input-group search_wrapper">
							<input id="search_mobile" name="search_str" type="search" class="form-control" placeholder="{{__("Search in ads...")}}" aria-label="Search" autocomplete="off" value="{{request()->search_str}}">
							<button class="btn btn-outline-secondary" id="btn_search_submit" type="button">
								<x-svg_icon iconname="i_search" width="16" height="16"/>
							</button>
							<div class="dynamic_search_results_mobile mt-2 mb-2 d-none"></div>
						</div>
					</form>
				</div>
			</div>
			<div class="navbar-collapse collapse" id="navbar_mobile_red_menu">
				<div class="row mx-0 justify-content-center">
					<div class="col-6 bg-danger px-0" style="width: 54vw !important;">
						<ul class="navbar-nav me-auto main_menu_red">
							<li class="nav-item">
								<a class="nav-link" href="{{$routeHome}}">{{__("HOME")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('cars.latest')}}">{{__("LATEST ADS")}}</a>
							</li>
							<li class="nav-item">
								<a href="{{route("cars.create")}}" class="nav-link active" aria-current="page">{{__("CREATE AD")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("cars.compare")}}">{{__("COMPARE")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("cars.favorites")}}">{{__("FAVORITES")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("categories")}}">{{__("CATEGORIES")}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route("contacts")}}">{{__("CONTACTS")}}</a>
							</li>
							<li class="language_menu_mobile_hint">{{__("Choose language")}}</li>
							@foreach (Config::get('languages') as $lang => $language)
								<li class="language_menu_mobile_item">
									<a href="{{ route('lang.switch', $lang) }}" class="language_menu_mobile_link"><span class="flag_icon flag_icon_{{$lang}}"></span><span>{{$language}}</span></a>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="col-6 bg-danger px-0" style="background-color: var(--settings_menu_submenu_item_bg) !important; width:46vw !important;">
						{{-- SETTINGS menu--}}
						<ul class="settings_menu_submenu d-block" id="settings_menu_submenu2">
							<li class="settings_menu_help">{{__("Choose color theme")}}</li>
							<hr>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__red.css')}}">
								<span class="color_theme_icon color_theme_icon_red"></span>
								<span class="settings_menu_link">{{__("Red theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__black.css')}}">
								<span class="color_theme_icon color_theme_icon_black"></span>
								<span class="settings_menu_link">{{__("Black theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__blue.css')}}">
								<span class="color_theme_icon color_theme_icon_blue"></span>
								<span class="settings_menu_link">{{__("Blue theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__orange.css')}}">
								<span class="color_theme_icon color_theme_icon_orange"></span>
								<span class="settings_menu_link">{{__("Orange theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__green.css')}}">
								<span class="color_theme_icon color_theme_icon_green"></span>
								<span class="settings_menu_link">{{__("Green theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__pink.css')}}">
								<span class="color_theme_icon color_theme_icon_pink"></span>
								<span class="settings_menu_link">{{__("Pink theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__brown.css')}}">
								<span class="color_theme_icon color_theme_icon_brown"></span>
								<span class="settings_menu_link">{{__("Brown theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__emerald.css')}}">
								<span class="color_theme_icon color_theme_icon_emerald"></span>
								<span class="settings_menu_link">{{__("Emerald theme")}}</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</div>
	<!--	▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
	<!--	HEADER линия c логотипом для экранов DESKTOP              -->
	<div class="container-fluid logo_block">
		<div class="d-none d-sm-block {{--container-md--}} bg-light ">
			<div class="d-flex flex-wrap justify-content-left align-items-center flex-nowrap">
				<a href="{{$routeHome}}" class="d-flex align-items-center justify-content-start mb-sm-0 mt-sd-0 bg-light me-2 car_sale_logo" data-bs-toggle="tooltip" data-bs-title="{{__("Go to start page")}}" style="flex: 0 1 auto">
					<x-svg_icon iconname="svg_logo" styles="width: 237px; height: 34px;padding-top: 2px;"/>
				</a>
				<form id="search_form" class="me-3" style="flex: 1 1 auto" action="/search">
					<div class="input-group search_wrapper">
						<input id="search" name="search_str" type="search" class="form-control" placeholder="{{__("Search in ads...")}}" aria-label="Search" autocomplete="off" value="{{request()->search_str}}">
						<button class="btn btn-outline-secondary" id="btn_search_mobile_submit" type="submit">
							<x-svg_icon iconname="i_search" width="16" height="16"/>
						</button>
						<div class="dynamic_search_results mt-2 mb-2 d-none "></div>
					</div>
				</form>
				{{-- SETTINGS menu--}}
				<ul class="settings_menu">
					<li class="settings_menu_level1_item">
						<i class="i_settings"></i>
						<ul class="settings_menu_submenu" id="settings_menu_submenu2">
							<div class="thin_stub_at_the_top"></div>
							<li class="settings_menu_help border_bottom_1px_settings_menu">{{__("Choose language")}}</li>
							@foreach (Config::get('languages') as $lang => $language)
								<li class="settings_menu_item">
									<a href="{{ route('lang.switch', $lang) }}" class="settings_menu_link"><span class="flag_icon flag_icon_{{$lang}}"></span><span>{{$language}}</span></a>
								</li>
							@endforeach
							<li class="settings_menu_help border_top_bottom_1px_settings_menu">{{__("Choose color theme")}}</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__red.css')}}">
								<span class="color_theme_icon color_theme_icon_red"></span>
								<span class="settings_menu_link">{{__("Red theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__black.css')}}">
								<span class="color_theme_icon color_theme_icon_black"></span>
								<span class="settings_menu_link">{{__("Black theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__blue.css')}}">
								<span class="color_theme_icon color_theme_icon_blue"></span>
								<span class="settings_menu_link">{{__("Blue theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__orange.css')}}">
								<span class="color_theme_icon color_theme_icon_orange"></span>
								<span class="settings_menu_link">{{__("Orange theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__green.css')}}">
								<span class="color_theme_icon color_theme_icon_green"></span>
								<span class="settings_menu_link">{{__("Green theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__pink.css')}}">
								<span class="color_theme_icon color_theme_icon_pink"></span>
								<span class="settings_menu_link">{{__("Pink theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__brown.css')}}">
								<span class="color_theme_icon color_theme_icon_brown"></span>
								<span class="settings_menu_link">{{__("Brown theme")}}</span>
							</li>
							<li class="settings_menu_item" theme_href="{{asset('/css/color_theme__emerald.css')}}">
								<span class="color_theme_icon color_theme_icon_emerald"></span>
								<span class="settings_menu_link">{{__("Emerald theme")}}</span>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	</div>
	<!--	МЕНЮ для экранов DESKTOP -->
	<nav class="d-none d-sm-block py-2  text-white main_menu_red">
		<div class="container-fluid d-flex  flex-wrap">
			<ul class="nav mx-auto justify-content-center">
				<li class="nav-item">
					<a href="{{$routeHome}}" class="nav-link link-light px-2">{{__("HOME")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route('cars.latest')}}" class="nav-link link-light px-2">{{__("LATEST ADS")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("cars.create")}}" class="nav-link link-light px-2" aria-current="page">{{__("CREATE AD")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("cars.compare")}}" class="nav-link link-light px-2">{{__("COMPARE")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("cars.favorites")}}" class="nav-link link-light px-2">{{__("FAVORITES")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("categories")}}" class="nav-link link-light px-2">{{__("CATEGORIES")}}</a>
				</li>
				<li class="nav-item">
					<a href="{{route("contacts")}}" class="nav-link link-light px-2">{{__("CONTACTS")}}</a>
				</li>
				{{--
								<li class="nav-item">
									<a class="nav-link link-light px-2" href="{{ route('admin.cars.index') }}">{{__("ADMIN")}}</a>
								</li>
				--}}
			</ul>
		</div>
	</nav>
</header>