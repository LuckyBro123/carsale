<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class YouCantDeleteOrUpdateException extends Exception {
	/**
	 * Render the exception as an HTTP response.
	 */
	public function render(Request $request) {
		return new JsonResponse([
			"message" => __($this->getMessage())
		], 552);
	}
}
