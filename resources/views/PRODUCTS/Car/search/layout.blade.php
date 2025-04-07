<!DOCTYPE html>
<html lang="en">
<head>
	@yield("tag_head")
</head>
<body class="" card_or_row_view_mode = "{{$cardOrListViewMode}}">
<x-myapp_init__CARS/>
<script type="text/javascript">
	// это надо чтобы потом сгенерить в строку адреса параметры с выбранными фильтрами вместо поисковой строки
  $myApp.searchResults = true;
</script>
@yield("header__logo_search_auth_menu")     {{--▪▪▪  HEADER  ШАПКА и МЕНЮ  ▪▪▪--}}
@yield("brands_menu")                        {{--▪▪▪ МЕНЮ  ИКОНОК  БРЭНДОВ  ▪▪▪--}}
@yield("filters")                          {{--▪▪▪ ФИЛЬТРЫ  FILTERS ▪▪▪--}}
@yield("message_above_content")
@yield("content")
@yield("footer")
@yield("switch_language")
</body>
@yield("storage__svg_icons")
</html>
