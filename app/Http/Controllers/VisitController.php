<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

define('VISITS_PER_PAGE', 50);

class VisitController extends __BaseController {
	public function index() {
		[$visits, $sortMode] = $this->service->visitsSortAndPaginate();
		return view("visits.sections_index", compact(["visits", "sortMode"]));
	}

}


