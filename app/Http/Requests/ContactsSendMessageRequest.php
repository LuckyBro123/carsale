<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsSendMessageRequest extends FormRequest {
	public function rules(): array {
		return ["contacts_sender_email" => ["required", "email", "max:255"],
		        "contacts_subject"      => ["string", "max:255"],
		        "contacts_message"      => ["required", "string", "min:4", "max:5000"]];
	}

	public function authorize(): bool {
		return true;
	}
}
