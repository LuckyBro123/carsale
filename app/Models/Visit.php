<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Visit extends Model {
	use HasFactory;

	public $timestamps = false;
	protected $guarded = [];

	static function saveNewVisit() {

		$ip = get_request_IP();
		if ($ip == "0.0.0.0") return;
		$url = removeWordsFromStr(Request::url(), ["https://", "http://"]);
		if (isStrContainsWordFromArray($url, [".map", "_debugbar", "favicon", "visits"])) return;
		$method = Request::method();
		$time = Carbon::now("UTC");
		$data = ["ip" => $ip, "url" => $url, "method" => $method, "time" => $time];
		Visit::create($data);
	}
}
