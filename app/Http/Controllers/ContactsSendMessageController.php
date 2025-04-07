<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactsSendMessageRequest;

class ContactsSendMessageController extends __BaseController {
	public function __invoke(ContactsSendMessageRequest $request) {
		$data = $request->validated();
		$this->service->contacts_SendMessageByEmail($data);
		return redirect()->route("contacts.message_sent");
	}
}
