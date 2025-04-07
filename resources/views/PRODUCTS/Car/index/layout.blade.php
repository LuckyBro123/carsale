<!DOCTYPE html>
<html lang="en">
@yield("tag_head")
<body class="" card_or_row_view_mode = "{{$cardOrListViewMode}}">
{{--
@if (config('app.debug') && !config('app.FREE_HOSTING'))
	<x-load_css phoneCSS="test_phone_css.css" tabletCSS="test_tablet_css.css" desktopCSS="test_desktop_css.css"/>
@endif
--}}
<x-myapp_init__CARS/>
@yield("header__logo_search_auth_menu")     {{--▪▪▪  HEADER  ШАПКА и МЕНЮ  ▪▪▪--}}
@yield("brands_menu")                        {{--▪▪▪ МЕНЮ  ИКОНОК  БРЭНДОВ  ▪▪▪--}}
@yield("filters")                          {{--▪▪▪ ФИЛЬТРЫ  FILTERS ▪▪▪--}}
@yield("statistics")                          {{--▪▪▪ СТАТИСТИКА ▪▪▪--}}
@yield("content")
@yield("footer")
@yield("switch_language")
@yield("text__what_is_it")
</body>
@yield("storage__svg_icons")
</html>
