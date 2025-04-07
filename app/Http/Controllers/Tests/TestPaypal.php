<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicSearchRequest;
use App\Jobs\TestJob;
use App\Mail\TestMailWithAttachments;
use App\Models\Car\Car;
use App\Models\Ssd\Ssd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
use Srmklive\PayPal\Services\PayPal as PayPalClient;

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
class TestPaypal extends Controller {

	public function __invoke() {
//		Cache::put('get_progress', 12334, 130);

		return view("test.sections_test_paypal");
	}

	public function checkout() {
		$provider = new PayPalClient;
		$provider->setApiCredentials(config('paypal'));
		$paypalToken = $provider->getAccessToken();

		$response = $provider->createOrder([
			"intent"         => "CAPTURE",
			"purchase_units" => [
				[
					"amount" => [
						"currency_code" => "USD",
						"value"         => "100.00"
					]
				]
			]
		]);

		if (isset($response['id']) && $response['id'] != null) {
			foreach ($response['links'] as $link) {
				if ($link['rel'] === 'approve') {
					return redirect()->away($link['href']);
				}
			}
		} else {
			dd("error", $response["error"]["name"], $response["error"]["message"]);
			return redirect()
				->route('paypal.home')
				->with('error', 'Something went wrong.');
		}
	}

	public function success(Request $request) {
		$provider = new PayPalClient;
		$provider->setApiCredentials(config('paypal'));
		$provider->getAccessToken();
		$response = $provider->capturePaymentOrder($request['token']);

		if (isset($response['status']) && $response['status'] == 'COMPLETED') {

			return redirect()
				->route('paypal.home')
				->with('success', 'Transaction complete.');
		} else {
			dd("error __ " . $response['message'] ?? 'Something went wrong.');
			return redirect()
				->route('paypal.home')
				->with('error', $response['message'] ?? 'Something went wrong.');
		}
	}

	public function cancel() {
		dd("error __ You have canceled the transaction.");
		return redirect()
			->route('paypal.home')
			->with('error', 'You have canceled the transaction.');
	}
	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

}
