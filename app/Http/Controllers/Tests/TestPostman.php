<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Tests\__BaseController;
use App\Http\Requests\DynamicSearchRequest;
use App\Models\Car\Car;
use App\Services\TestService;
use Illuminate\Http\JsonResponse;

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
class TestPostman extends __BaseController {
	const ONE_ROW = "one row", DATASET = "dataset", SEVERAL_ROWS = "several rows";

	public function __invoke() {
		$arr = ["type" => "one row", "data" => [11, 222, 33, 444, "names" => ["Grant", "Nick", "Max"], "numbers" => [12.34, 4.321, 567, 8.9]]];
		$clientData = request()["data"];
		return $arr;

		switch (request()["type"]) {
			case self::ONE_ROW :
				$result = $this->service->getOneRow(request()["data"]);
				break;
			case self::SEVERAL_ROWS :
				$result = $this->service->getSeveralRows(request()["data"]);
				break;
			case self::DATASET :
				$result = $this->service->getDataset(request()["data"]);
				break;
		}
		return $result;
	}

	public function ttttt(DynamicSearchRequest $request) {
		$str = $request->search_str;
		dd(Car::where("description", "like", "%$str%")->select(["brand_id", "model_id", "price"])->toSql());

		return;
		// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
		if (request()->test == 1) return ["success" => 1, "test_str" => "postman прикольный"];
		if (request()->test == 2) return ["success" => 1, "test_str" => "получил 2"];
		else return new JsonResponse([
			"filename" => "1234 хз что случилось",
			"message"  => __("There was an unknown problem uploading photo to the server. Please upload your photos again")
		], 551);

	}



// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

	public function __construct(TestService $service) {
		parent::__construct($service);
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

}
