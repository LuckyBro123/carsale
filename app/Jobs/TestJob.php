<?php

namespace App\Jobs;

use App\Mail\TestMailWithAttachments;
use App\Models\Car\Car;
use App\Models\Testtest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestJob implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(public $param = "") {

	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		dump($this->param);

		$count = 0;
		$rowsTotal = Car::count();
		Cache::put('get_progress', 0, 30);

		Car::chunk(1000, function ($cars) use (&$count, $rowsTotal) {
			foreach ($cars as $car) {
				for ($i = 0; $i < 60; $i++)
					if ($car->brand_id > 0) {
						$ttt = mt_rand();
					}
				$count++;
			}
			Cache::put('get_progress', round($count * 100 / $rowsTotal), 30);

			//			Log::channel('test')->notice("готово на " . round($count * 100 / $rowsTotal) . "%" . " " . now_time());
			dump("готово на __ " . " __ " . round($count * 100 / $rowsTotal) . "%" . " " . now_time());

		});
		dump(" ** джоб выполнен " . now_time());
//		Log::channel('test')->notice(" ** джоб выполнен " . now_time());
//		Log::channel('test')->notice("");

	}
}
