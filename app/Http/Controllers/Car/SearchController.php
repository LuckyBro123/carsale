<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\DynamicSearchRequest;
use App\Models\_filters\CarFilter;
use App\Models\_filters\Filter;
use App\Models\Car\Car;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class SearchController extends __BaseController {

	public function __invoke(DynamicSearchRequest $request, CarFilter $filter) {

		$searchStr = $request->validated()["search_str"];
		[$filters, $selectedFilters, $isAnyFiltersSelected, $brands] = $filter->count_Filters_And_Other_Data_From_GETsearchRequest($searchStr);
		[$sortMode, $productsPerPage] = $filter->get_sortMode_perPage_and_setCookie();
		$cardOrListViewMode = $this->service->get_cardOrRow_viewMode();
		[$compareElems, $favoritesElems] = $this->service->get_Compare_And_Favorites_Lists();
		$extProductCardSettings = $this->service->get_Ext_Product_Card_Settings();
		$goods = $filter->getFilteredContent($selectedFilters, $sortMode, $productsPerPage);
		$pluralWords = Car::getPluralWords();
		$allSortModes = $filter->getSortModesAndTexts();

//		dump($selectedFilters);
//		$totalElements = $goods->total();
//		dump('Total elements:', $totalElements);

		return view("PRODUCTS.Car.search.sections_search", compact(["goods", "sortMode", "productsPerPage", "brands", "filters", "isAnyFiltersSelected", "compareElems", "favoritesElems", "extProductCardSettings", "searchStr", "pluralWords", "allSortModes", "cardOrListViewMode"]));
	}
}
