<?php

namespace App\Services;

use App\Libraries\CarsaleMail;
use App\Mail\ContactsMail;
use App\Models\VehicleDriveType;
use App\Models\Visit;

use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommonService extends __BaseService {

	public function contacts_SendMessageByEmail($data) {
		$letterData = [
			"from"         => "CARSALE.CONTACTS@sandboxfed2eb0645d5451fb99590f72bc7c02a.mailgun.org",
			"to"           => "xlamspam123@gmail.com",
			"subject"      => "CAR-SALE / CONTACTS / " . $data["contacts_subject"],
			"sender_email" => $data["contacts_sender_email"],
			"message"      => $data["contacts_message"]
		];

		try {
			CarsaleMail::mailer('mailgun')->send($letterData);
			Log::channel('for_debug')->debug('Письмо отправлено');
		} catch (\Exception $e) {
			Log::channel('for_debug')->error('Ошибка отправки: ' . $e->getMessage());
		}
	}

	public function visitsSortAndPaginate() {
		$sortMode = request()->visits_sort_mode ?? ($_COOKIE["visits_sort_mode"] ?? "time_desc");
		set_cookie("visits_sort_mode", $sortMode, 10000);
		switch ($sortMode) {
			case "ip_asc" :
				$visits = Visit::orderBy("ip")->orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "ip_desc" :
				$visits = Visit::orderByDesc("ip")->orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "method_asc" :
				$visits = Visit::orderBy("method")->orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "method_desc" :
				$visits = Visit::orderByDesc("method")->orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "url_asc" :
				$visits = Visit::orderBy("url")->orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "url_desc" :
				$visits = Visit::orderByDesc("url")->orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "time_asc" :
				$visits = Visit::orderByDesc("time")->paginate(VISITS_PER_PAGE);
				break;
			case "time_desc" :
				$visits = Visit::orderBy("time")->paginate(VISITS_PER_PAGE);
				break;
			default:
				$visits = Visit::orderByDesc("time")->paginate(VISITS_PER_PAGE);
		}

		return [$visits, $sortMode];
	}

}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function test($search_str, $limit = 100000) {
}

