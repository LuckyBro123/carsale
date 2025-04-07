<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/*********************************************************************
 * удаление записи / машины / row
 */
class DeleteController extends __BaseController {

	public function __invoke() {
		$this->service->delete(request()->id);
		return response()->redirectToRoute("cars.index");
	}
}
