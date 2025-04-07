<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicSearchRequest;
use App\Mail\TestMailWithAttachments;
use App\Models\Car\Car;
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
class TestMail extends Controller {

	public function __invoke() {
		$car = Car::inRandomOrder()->first();
		Mail::mailer('gmx')->send(new TestMailWithAttachments(
			["from"           => 'CARSALE.CONTACTS@trial-pxkjn41pxeq4z781.mlsender.net',
			 "to"             => 'xlamspam123@gmail.com',
			 "subject"        => 'Тема LARAVEL test',
			 "message"        => 'Текст сообщения  TEST TEST TEST',
			 "car"            => $car,
			 "attached_files" => ["pic_1.webp", "photos.rar", "pic___2.jpg", "FAVICONS.rar"]]));
	}


// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

	public function __construct() {
		echo '<head><title>TEST</title>';
		echo "<link rel='icon' href='" . asset('/img/favicons/favicon_test.png') . "' type='image/x-icon'>";
		echo '<script src="' . asset('/plugins/jquery-3.7.1.min.js') . '" type="text/javascript"></script>';
		echo '<link href="' . asset('/css/test.css') . '" rel="stylesheet"/>';
		echo '<script src="' . asset('/plugins/live_only_JS_and_css.js') . '" type="text/javascript"></script>';
		echo '<script src="' . asset('/js/test.js') . '" type="text/javascript"></script>';
		echo '</head>';
		return;
//		cleanPhotosOfGarbage();
//		cleanDiskOf_temp_photos_Garbage(24 * 1);

	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

}
