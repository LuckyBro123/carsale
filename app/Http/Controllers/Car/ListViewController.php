<?php

namespace App\Http\Controllers\Car;

use App\Models\_filters\CarFilter;
use App\Models\Car\Car;

use Illuminate\Support\Facades\Redirect;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class ListViewController extends __BaseController {

	public function __invoke() {
		set_cookie("cars_card_or_row_viewmode", "row", 15000);

		return redirect()->route('cars.index', request()->except(['is_allowed_IP', 'is_admin']));
//		return Redirect::route('cars.index');
//		return response()->redirectToRoute("cars.index");
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

