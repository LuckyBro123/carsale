<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\Car\ExtendedProductCardRequest;
use App\Http\Requests\Car\GetStatisticsRequest;
use App\Http\Requests\DynamicSearchRequest;
use App\Models\_filters\CarFilter;
use Illuminate\Http\Request;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class GetStatisticsController extends __BaseController {

	public function __invoke(Request $request, CarFilter $filter) {

		[$selectedFilters, ,] = $filter->getSelectedFiltersFromRequest();
		$statistics = $this->service->getStatistics($selectedFilters);
		$html = view("components.statistics_content_for_POST", compact(["statistics"]))->render();
		return ["success" => 1, "html" => $html];
	}
}
