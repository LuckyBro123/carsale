<?php

namespace App\Services;



class __BaseService {

	function get_Compare_And_Favorites_Lists() {
		$compareCookieName = get_called_class()::$productTable . "_compare_elems";
		$favoritesCookieName = get_called_class()::$productTable . "_favorites_elems";
		$compareElems = json_decode($_COOKIE[$compareCookieName] ?? "[]");
		$favoritesElems = json_decode($_COOKIE[$favoritesCookieName] ?? "[]");
		return [$compareElems, $favoritesElems];
	}

	function get_Ext_Product_Card_Settings() {
		$сookieName = get_called_class()::$productTable . "_ext_card_settings";
		$settings = json_decode($_COOKIE[$сookieName] ?? "[]");
		return empty($settings) ? ["mileage", "fuel_consumption", "was_in_accident"] : $settings;
	}

	function get_sortMode_perPage_and_setCookie() {
		$class = get_called_class();
		[$sortMode, $elementsPerPage] = get_sortMode_perPage($class::$sortModeName, $class::$perPageName, $class::getSortModes());
		set_cookie("sort_mode", 0, 0);
		set_cookie("per_page", 0, 0);
		set_cookie($class::$sortModeName, $sortMode, 15000);
		set_cookie($class::$perPageName, $elementsPerPage, 15000);
		return [$sortMode, $elementsPerPage];
	}

	function get_cardOrRow_viewMode() {
		$viewModeCookieName = get_called_class()::$productTable . "_card_or_row_viewmode";
		$viewMode = get_cardOrRow_viewMode($viewModeCookieName);
		return $viewMode;
	}

}
