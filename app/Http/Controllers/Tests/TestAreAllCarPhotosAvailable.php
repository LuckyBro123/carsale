<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicSearchRequest;
use App\Jobs\TestJob;
use App\Mail\TestMailWithAttachments;
use App\Models\Car\Car;
use App\Models\Car\CarBrand;
use App\Models\Car\CarPhoto;
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
class TestAreAllCarPhotosAvailable extends Controller {

	public function __invoke() {
		$brokenPhotosCount = 0;
		$cars = [];
		foreach (CarPhoto::all() as $photo) {
			$filename = "cars_photos/" . $photo->filename;

			if (Storage::disk('public')->exists($filename)) {
//					echo 'Файл ' . $filename . ' существует в диске public.';
			} else {
				$brokenPhotosCount++;
				$brand = $photo->car->brandName->name;
				if (isset($cars[$photo->car_id])) $cars[$photo->car_id]++; else $cars[$photo->car_id] = 1;
//				dump('Файл ' . $filename . ' не существует');
			}

		}
		dump($brokenPhotosCount . " нету фоток"," машины без фоток:", $cars);

	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

}
