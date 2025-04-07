<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Car\DynamicSearchController;
use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicSearchRequest;
use App\Jobs\TestJob;
use App\Mail\TestMailWithAttachments;
use App\Models\Car\Car;
use App\Models\Car\CarPhoto;
use App\Models\Laptop\Laptop;
use App\Models\Phone\Phone;
use App\Models\Ssd\Ssd;
use Illuminate\Database\Eloquent\Model;
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

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
class TestAjax extends Controller {

	public function __invoke() {
		$productTablesLastIDs = [
			"cars"    => Car::max('id'),
			"laptops" => Laptop::max('id'),
			"phones"  => Phone::max('id'),
			"ssds"    => Ssd::max('id')
		];
// Преобразуем массив в JSON
		$jsonData = json_encode($productTablesLastIDs, JSON_PRETTY_PRINT);
// Указываем путь к файлу
		$filePath = Str::finish(base_path(), '/') . 'database/productTablesLastIDs.json';
// Записываем JSON в файл
		if (file_put_contents($filePath, $jsonData) !== false) {
			echo "Данные успешно записаны в файл $filePath.";
		} else {
			echo "Ошибка при записи данных в файл.";
		}
	}
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
		public
		function __construct() {
			echo_tag_head(true);
		}

		// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

	}
