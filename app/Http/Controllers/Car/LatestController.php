<?php

namespace App\Http\Controllers\Car;

use App\Models\_filters\CarFilter;
use App\Models\Car\Car;

use Illuminate\Support\Facades\Redirect;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class LatestController extends __BaseController {

	public function __invoke() {
		set_cookie(CarFilter::$sortModeName, "latest", 15000);
		return redirect()->route('cars.index');;
//		return Redirect::route('cars.index');
//		return response()->redirectToRoute("cars.index");
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

