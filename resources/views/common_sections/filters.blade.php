<?php
$totalProductsFound = $goods->total();
$extProductCardSettings = $extProductCardSettings ?? false;
?>
<x-filters_section isAnyFiltersSelected="{{$isAnyFiltersSelected}}" :pluralWords="$pluralWords" totalProductsFound="{{$totalProductsFound}}" :filters="$filters" :car="$goods->items()[0]" :compareElems="$compareElems" :favoritesElems="$favoritesElems" :extProductCardSettings="$extProductCardSettings" cardOrListViewMode="{{$cardOrListViewMode}}"/>