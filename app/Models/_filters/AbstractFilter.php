<?php

namespace App\Models\_filters;

use App\Models\_filters\Traits\createFiltersBasicDataTable;
use App\Models\_filters\Traits\createFilterTable;
use App\Models\_filters\Traits\getFilteredContent;
use App\Models\_filters\Traits\getSelectedFiltersFromRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

define("FILTER_NORMAL_INT", "Ni");
define("FILTER_NORMAL_FLOAT", "Nf");
define("FILTER_RANGE", "D");
//define("FILTER_RANGE_FLOAT", "Df");
define("FILTER_MINI_RANGE", "MD");
define("FILTER_COLOR", "C");
define("FILTER_YESNO", "YN");
define("FILTER_RELATIONSHIP", "R");

abstract class AbstractFilter extends Model {
	public $TIMES█tamps = false;
	protected $guarded = [];
	use HasFactory, createFilterTable, createFiltersBasicDataTable, getFilteredContent, getSelectedFiltersFromRequest;

	protected static $filtersBasicDataTableName = "filters__basic_data";

//             -             -             -             -             -             -
	static function getSortCallback($sortMode) {
		return get_called_class()::$sortCallbacks[$sortMode];
	}

	static function getSortModes() {
		return array_keys(get_called_class()::$allSortModes);
	}

	public function getSortModesAndTexts() {
		return get_called_class()::$allSortModes;
	}

	public function count_Filters_And_Other_Data_From_POST() {
		return $this->countFiltersAndOther();
	}

	public function count_Filters_And_Other_Data_From_GET() {
		return $this->countFiltersAndOther();
	}

	public function count_Filters_And_Other_Data_From_GETsearchRequest($searchStr) {
		return $this->countFiltersAndOther($searchStr);
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected function countFiltersAndOther($searchStr = "") {
		$filters = $this->get_All_Filters_From_DB_And_Sort_Them_Into_Groups();
		[$selectedFilters, $selectedFilterCodes, $requestMethod] = $this->getSelectedFiltersFromRequest($searchStr, $filters);
		$isAnyFiltersSelected = false;

		if ($selectedFilters) {
			$queryArray = [];
			$selectedGroups = $selectedFilters;
			foreach ($selectedGroups as $index => $filterGroup) if (isset($filterGroup["belongs_to"])) unset($selectedGroups[$index]);
			foreach ($filters as $index => $filterGroup) {
				foreach ($filterGroup["codes"] as $index2 => $code) {
					$chiefFilterCode = $filterGroup["belongs_to"][$index2] ?? false;
					$isFilterHidden = $chiefFilterCode ? !in_array($chiefFilterCode, $selectedFilterCodes) : false;
					if ($chiefFilterCode && !$isFilterHidden) $filters[$index]["is_hidden"][$index2] = false;

					if (in_array($code, $selectedFilterCodes) || $isFilterHidden) {   // this is a selected or hidden filter, no need to count
						$filters[$index]["checkedStatuses"][$index2] = $isFilterHidden ? 0 : 1;
						if ($isFilterHidden) $filters[$index]["is_hidden"][$index2] = true;

						$filters[$index]["amounts"][$index2] = "";
						if ($filterGroup["type"] == FILTER_RANGE) {
							$filters[$index]["amounts"] = ["min" => $filters[$index]["values"][0], "max" => $filters[$index]["values"][1]];
							$filters[$index]["values"] = $selectedFilters[$index]["values"];
						}
					} else if ($filterGroup["type"] == FILTER_RANGE) { // this is not a selected filter but Diapason, need to count
						$filtersToCalculate = $selectedGroups;
						$filtersToCalculate[$index]["name"] = $index;
						$filtersToCalculate[$index]["type"] = $filterGroup["type"];
						$filtersToCalculate[$index]["values"] = $filterGroup["values"];
						$filters[$index]["amounts"][$index2] = 0;
					} else {                                // this is not a selected filter, need to count
						$filtersToCalculate = $selectedGroups;
						$filtersToCalculate[$index]["name"] = $index;
						$filtersToCalculate[$index]["type"] = $filterGroup["type"];
						if ($filterGroup["type"] == FILTER_MINI_RANGE) {
							$filtersToCalculate[$index]["minMax"] = [];
							$filtersToCalculate[$index]["minMax"][] = $filterGroup["minMax"][$index2];
						} else {
							$filtersToCalculate[$index]["values"] = [];
							$filtersToCalculate[$index]["values"][] = $filterGroup["values"][$index2];
							$filtersToCalculate[$index]["binded_table_values"] = [];
							$filtersToCalculate[$index]["binded_table_values"][] = $filterGroup["binded_table_values"][$index2];
						}
						$key = "" . $index . "--" . $index2;
						$queryArray[$key] = $this->calculateOneFilterAmount($filtersToCalculate);
					}
				}
			}

			if ($requestMethod != "GET") {
				$summaryQuery = DB::query();
				foreach ($queryArray as $key => $oneQuery) $summaryQuery->selectSub($oneQuery, $key);
				$allNumbers = (array)$summaryQuery->first();

				foreach ($allNumbers as $key => $oneNumber) {
					[$groupIndex, $amountIndex] = explode("--", $key);
					$filters[$groupIndex]["amounts"][$amountIndex] = $oneNumber;
				}
			}

			$selectedItemsTotalCount = array_values((array)$this->calculateOneFilterAmount($selectedFilters)->first())[0];
			$isAnyFiltersSelected = true;
		} else {
			foreach ($filters as $index => $filterGroup) if (isset($filterGroup["belongs_to"])) $filters[$index]["is_hidden"] = array_fill(0, count($filters[$index]["belongs_to"]), true);
			$selectedItemsTotalCount = (get_called_class()::$productClass)::count();
		}

		if ($requestMethod == "POST") return [$this->convertToCodesAndValuesArray($filters), $selectedItemsTotalCount];
		else {
			$codesAndBrands = array_combine($filters["brand_id"]["codes"], $filters["brand_id"]["binded_table_values"]);
			return [$filters, $selectedFilters, /*$selectedItemsTotalCount,*/ $isAnyFiltersSelected, $codesAndBrands];
		}
	}

	// возвращает присланные выбранные фильтры в виде групп, берет их из GET, и из POST
	// или создаёт их из строки поиска $searchStr
	public function getSelectedFiltersFromRequest($searchStr = "", $filters = []) {
		//-------------------------------------------------
		//  внутренние функции
		//-------------------------------------------------
		function validateMinMaxParams($min, $max) {
			if ($min < 0 || $min == null) $min = 0;
			if ($max < 0 || $max == null) $max = 0;
			if ($min > $max) {
				$tt = $min;
				$min = $max;
				$max = $tt;
			}
			return [$min, $max];
		}

		//-------------------------------------------------
		//	возвращает [ $isOnlyBrands, $isBrandAndModel , $selectedFilterCodes ]
		function getSelectedFilterCodes($brandsAndModelsMixed, $filters) {
			// #####  встроенные функции
			function getBrandOfModel($modelCode, $filters) {
				$index = array_search($modelCode, $filters["model_id"]["codes"]);
				return $filters["model_id"]["belongs_to"][$index];
			}

			function getAllModelsOfBrand($brandCode, $filters) {
				$belongs_to = $filters["model_id"]["belongs_to"];
				$models = $filters["model_id"]["codes"];
				// Шаг 1: Получаем все ключи из $belongs_to, где значение равно $brandCode
				$brandKeys = array_keys($belongs_to, $brandCode);
				// Шаг 2: Получаем все значения из $models по найденным ключам
				$result = array_map(function ($key) use ($models) {
					return $models[$key];
				}, $brandKeys);
				return $result;
			}      // #####  КОНЕЦ встроенных функции  ####################

			$brands = $models = [];
			foreach ($brandsAndModelsMixed as $key => $item)
				if ($item->column == "brand_id") $brands[] = $item->code;
				else $models[] = $item->code;

			$selectedFilterCodes = collect($brands);
			if ($models) {
				foreach ($brands as $brand) $selectedFilterCodes = $selectedFilterCodes->concat(getAllModelsOfBrand($brand, $filters));
				foreach ($models as $model)
					$selectedFilterCodes = $selectedFilterCodes->push($model, getBrandOfModel($model, $filters));
			}
			// и надо эту свалку кодов фильтров очистить от дубликатов
			return $selectedFilterCodes->unique()->sort()->values()->all();
		}

		function convertSearchstrToBrandsAndModels($searchStr, $filterClass) {
			$words = str_word_count($searchStr, 1, '1234567890йцукенгшщзхъфывапролджэячсмитьбюёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ');
			$brandsAndModelsToSearch = collect();
			foreach ($words as $word) {
				$somefilters = Cache__tags("FILTERS ", $filterClass)->remember("searchStr " . $word, 3600, function () use ($word, $filterClass) {
					return $filterClass::whereIn("column", ["brand_id", "model_id"])->where("binded_table_value", "like", "%" . $word . "%")->get();
				});
				$brandsAndModelsToSearch = $brandsAndModelsToSearch->concat($somefilters);
			}
			return $brandsAndModelsToSearch;
		}

		//-------------------------------------------------
		//  КОНЕЦ  внутренних функций
		//-------------------------------------------------

		$selectedFilterCodes = [];
		$diapasonFiltersData = [];

		if ($searchStr) {  // GET запрос поиска по словам
			$brandsAndModelsToSearch = convertSearchstrToBrandsAndModels($searchStr, get_called_class());
			$selectedFilterCodes = getSelectedFilterCodes($brandsAndModelsToSearch, $filters);
			$request_method = "GET";
		} else {
			// подготовить массив кодов простых фильтров
			if (request()->ff) $selectedFilterCodes = explode("-", request()->ff);         // если прислано GET
			if (request()->checkedFilters) $selectedFilterCodes = request()->checkedFilters;  // если прислано POST

			// теперь диапазонные фильтры
			if ($fd = request()->fd) {                                  // если прислано GET
				$fd = explode("-", $fd);
				foreach ($fd as $oneDiapasonFilterStr) {
					$arr = explode("_", $oneDiapasonFilterStr);
					$minAndMax = validateMinMaxParams($arr[1], $arr[2]);
					if ($minAndMax[1]) $diapasonFiltersData[$arr[0]] = $minAndMax;
				}
			}
			if (request()->diapasonFilters) {                            // если прислано POST
				foreach (request()->diapasonFilters as $arr) {
					$minAndMax = validateMinMaxParams($arr[1], $arr[2]);
					if ($minAndMax[1]) $diapasonFiltersData[$arr[0]] = $minAndMax;
				}
			}
			$request_method = request()->methodPOST ? "POST" : "GET";
		}

		$selectedFiltersSortedByGroups = $this->convertFilterCodesArrayToGroups($selectedFilterCodes, $diapasonFiltersData);
		$selectedFilterCodes = array_merge($selectedFilterCodes, array_keys($diapasonFiltersData));
		return [$selectedFiltersSortedByGroups, $selectedFilterCodes, $request_method];
	}

	protected function calculateOneFilterAmount($filters) {
//		$query = DB::table(get_called_class()::$productTable);
		$query = DB::table(get_called_class()::$productTable . "__memory");

		foreach ($filters as $filterGroup) {
			switch ($filterGroup["type"]) {
				case FILTER_RANGE :
					$values = $filterGroup["values"];
					$query->whereBetween($filterGroup["name"], $values);
					break;
				case FILTER_MINI_RANGE :
					$query->where(function ($query) use ($filterGroup) {
						foreach ($filterGroup["minMax"] as $index => $minMax) {
							if ($index) $query->orWhereBetween($filterGroup["name"], $minMax); else $query->whereBetween($filterGroup["name"], $minMax);
						}
					});
					break;
				/*	  case FILTER_RELATIONSHIP :
							case FILTER_COLOR :
							case FILTER_NORMAL_INT :
							case FILTER_YESNO : */
				default:
					$values = $filterGroup["values"];
					$query->whereIn($filterGroup["name"], $values);
					break;
			}
		}
		$query->selectRaw('COUNT(*)');
		return $query;

		// по сути надо из этих запросов собрать один запрос типа:
		// НЕ УДАЛЯТЬ ПРИМЕР НИЖЕ
		/* $allNumbers = (array)DB::query()
			 ->selectSub(DB::table("cars")->whereBetween("id", [10, 70])->selectRaw('count(*)'), 'count1')
			 ->selectSub(DB::table("cars")->where("id", ">", 70)->selectRaw('count(*)'), 'count2')
			 ->selectSub(DB::table("cars")->where("id", ">", 20)->where("production_year", ">", 2015)->selectRaw('count(*)'), 'count3')
						->first();*/
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected function get_All_Filters_From_DB_And_Sort_Them_Into_Groups() {
		return $this->convertFilterCodesArrayToGroups();
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected function convertFilterCodesArrayToGroups($selectedFilterCodes = null, $diapasonFilterData = null) {
		$filters = $allCheckedFilterCodes = [];
		$getFromDB = ($selectedFilterCodes === null && $diapasonFilterData === null);
		if ($getFromDB) {
			$filtersFromDB = Cache__tags("FILTERS", get_called_class())->rememberForever("all()->toArray()", function () {
				return get_called_class()::all()->toArray();
			});
		} else {
			// формирую единый массив выбранных фильтров, из БД
			foreach ($selectedFilterCodes as $oneCode) $allCheckedFilterCodes[$oneCode] = 0;
			$allCheckedFilterCodes = $allCheckedFilterCodes + $diapasonFilterData;

			$keys = array_keys($allCheckedFilterCodes);
			$cacheKey = "Filter:" . hash("md4", implode("-", $keys));
			$filtersFromDB = Cache__tags("FILTERS", get_called_class())->rememberForever($cacheKey, function () use ($keys) {
				return get_called_class()::whereIn("code", $keys)->get()->toArray();
			});
		}

		// преобразовываю массив инфы из БД в группы фильтров
		foreach ($filtersFromDB as $oneFilter) {
			$groupName = $oneFilter["column"];
			$filters[$groupName]["name"] = $groupName;
			$filters[$groupName]["type"] = $oneFilter["type"];
			$filters[$groupName]["binded_table_column"] = $oneFilter["binded_table_column"];
			$filters[$groupName]["titleOnSite"] = $oneFilter["filter_group_title_on_site"];
			if ($oneFilter["belongs_to"]) {
//			$filters[$groupName]["belongs_to_name"] = arraySearchByCode($filtersFromDB, $oneFilter["code"]);
				$filters[$groupName]["belongs_to"][] = $oneFilter["belongs_to"];
			}
			switch ($oneFilter["type"]) {
				case FILTER_RANGE :            //*********************** Diapason filter
					if ($getFromDB) $filters[$groupName]["values"] = [$oneFilter["min"], $oneFilter["max"]]; else $filters[$groupName]["values"] = $allCheckedFilterCodes[$oneFilter["code"]];
					$filters[$groupName]["totalMin"] = $oneFilter["min"];
					$filters[$groupName]["totalMax"] = $oneFilter["max"];
					break;
				case FILTER_MINI_RANGE :        //*********************** Mini Diapason filter
					$filters[$groupName]["values"][] = $oneFilter["value"];
					$filters[$groupName]["binded_table_values"][] = "";
					$filters[$groupName]["minMax"][] = [$oneFilter["min"], $oneFilter["max"]];
					break;
				case FILTER_RELATIONSHIP :       //*********************** Relationship / Color filter
				case FILTER_COLOR :
					$filters[$groupName]["values"][] = $oneFilter["value"];
					$filters[$groupName]["binded_table_values"][] = $oneFilter["binded_table_value"];
					break;
				case FILTER_NORMAL_INT :         //**************** Normal / YesNo filter
				case FILTER_YESNO :
					$filters[$groupName]["values"][] = $oneFilter["value"];
					$filters[$groupName]["binded_table_values"][] = "";
					break;
			}

			$filters[$groupName]["codes"][] = $oneFilter["code"];
			$filters[$groupName]["amounts"][] = $oneFilter["amount"];
			$filters[$groupName]["checkedStatuses"][] = $getFromDB ? 0 : 1;
		}
		return $filters;
	}

	protected function convertToCodesAndValuesArray($filters) {
		$response = [];
		foreach ($filters as $filterGroup) {
			$hasSelectedItems = in_array(1, $filterGroup["checkedStatuses"]);
			foreach ($filterGroup["codes"] as $index => $code) {
				if ($filterGroup["type"] == FILTER_RANGE) $response[] = [$code, $filterGroup["values"][0], $filterGroup["values"][1]];
				else {
					$amount = $filterGroup["amounts"][$index];
					$amount = ($hasSelectedItems && $amount) ? "+" . $amount : $amount;
					$response[] = [$code, $amount];
				}
			}
		}
		return $response;
	}

	static function get_sortMode_perPage_and_setCookie() {
		$class = get_called_class();
		[$sortMode, $elementsPerPage] = get_sortMode_perPage($class::$sortModeName, $class::$perPageName, $class::getSortModes());
		set_cookie("sort_mode", 0, 0);
		set_cookie("per_page", 0, 0);
		set_cookie($class::$sortModeName, $sortMode, 15000);
		set_cookie($class::$perPageName, $elementsPerPage, 15000);
		return [$sortMode, $elementsPerPage];
	}
	// ---   the end of the class definition    ---------------------------------------------------
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪  вспомогательные функции  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪


