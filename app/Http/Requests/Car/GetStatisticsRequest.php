<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class GetStatisticsRequest extends FormRequest {
	public function rules(): array {
		return ["checkedFilters" => ["required", "array"],
		        "diapasonFilters" => ["required", "array"]];
	}

	public function authorize(): bool {
		return true;
	}
}
