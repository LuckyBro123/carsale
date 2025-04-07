<?php

namespace App\Http\Controllers\Tests;

use App\Helpers\QueryCloneHelper;
use App\Http\Controllers\Car\DynamicSearchController;
use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicSearchRequest;
use App\Jobs\TestJob;
use App\Mail\TestMailWithAttachments;
use App\Models\_filters\CarFilter;
use App\Models\Car\Car;
use App\Models\Car\CarDescription;
use App\Models\Car\CarPhoto;
use App\Models\Laptop\Laptop;
use App\Models\Phone\Phone;
use App\Models\Ssd\Ssd;
use App\Models\User;
use App\Models\Visit;
use App\Services\CarService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use PHPUnit\Logging\Exception;

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
class Test extends Controller {

	public function __invoke(CarService $service, CarFilter $filter) {
		$words = ["ibiza", "nis", "mer", "rento"];

		$cars = Car::query()
			->where(function ($query) use ($words) {
				$query->whereHas('brandName', function ($subQuery) use ($words) {
					$subQuery->where(function ($q) use ($words) {
						foreach ($words as $word) {
							$q->orWhere('name', 'LIKE', '%' . $word . '%');
						}
					});
				})
					->orWhereHas('modelName', function ($subQuery) use ($words) {
						$subQuery->where(function ($q) use ($words) {
							foreach ($words as $word) {
								$q->orWhere('name', 'LIKE', '%' . $word . '%');
							}
						});
					});
			});
		$count = $cars->count();
		$cars = array_map(function ($item) {
			return $item["brand_name"]["name"] . " " . $item["model_name"]["name"];
		}, $cars->select(["id", "brand_id", "model_id", "production_year", "price"])->with(["brandName", "modelName"])->get()->toArray());
		natcasesort($cars);
		dd($count, $cars);
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public
	function __construct() {
		echo_tag_head(true);
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

}
