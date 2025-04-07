<?php
$colorClass = ["email_picture_bg_blue", "email_picture_bg_gray", "email_picture_bg_pink", "email_picture_bg_emerald"][mt_rand(0, 3)];
if (config('app.debug')) {
	$senderEmail = fake()->email();
	$subject = "тема письма " . fake()->sentence();
	$messageValue = implode("\n\n",fake()->paragraphs(mt_rand(1,7)));
} else {
	$senderEmail = "";
	$subject = "";
	$messageValue = "";
}

?>
<form action="/contacts" method="POST" class="contacts_send_message_form" enctype="multipart/form-data" id="contacts_send_message_form">
	@csrf
	<div class="container-fluid contacts_container">
		<div class="contacts">
			<div class="row justify-content-center">
				{{-- YELLOW VERTICAL WAVY DECORATION --}}
				<div class="col-12 col-sm-3 email_picture_holder {{$colorClass}}">
					<img src="{{asset('/img/contacts/email.svg')}}" alt="" class="img-fluid">
				</div>
				{{-- ELEMENTS FOR DATA INPUT --}}
				<div class="col-12 col-sm-9">
					<div class="row p-4">
						<h2 class="pb-4" style="color:var(--bs-gray-600);">{{__("Write me a message")}}</h2>
						{{-- EMAIL                                                             --}}
						<div class="col-12">
							<x-input_with_label name="contacts_sender_email" title='{{__("Your email")}}' type="email" placeholder="example@mail.com" value="{{$senderEmail}}" required/>
						</div>
						{{-- SUBJECT                                                           --}}
						<div class="col-12">
							<x-input_with_label name="contacts_subject" title='{{__("Subject")}}' type="text" placeholder="{{__('Subject')}}" value="{{$subject}}" minlength="2" maxlength="200" required/>
						</div>
						{{-- MESSAGE                                                           --}}
						<div class="col-12">
							<div class="form-group d-flex flex-wrap justify-content-center">
								<label for="contacts_message" class="flex-grow-1 align-items-start">{{__("Your message")}}</label>
								<textarea class="form-control flex-grow-1 align-items-stretch" placeholder="{{__('Input your message here')}}" name="contacts_message" id="contacts_message" rows="8" minlength="10" maxlength="5000" required>{{$messageValue}}</textarea>
							</div>
						</div>
						{{-- SEND button --}}
						<div class="col-12 mt-4 text-center">
							<button type="submit" class="btn btn-warning btn_send_data me-3" style="width: 100%;">{{__("Send message")}}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>