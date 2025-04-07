<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TestMailWithAttachments extends Mailable /*implements ShouldQueue*/
{
	use Queueable, SerializesModels;

	public $someData = 100;

	public function __construct(public array $data) {
	}

	public function envelope(): Envelope {
		return new Envelope(
			from: $this->data["from"],
			to: $this->data["to"],
			subject: $this->data["subject"]);
	}

	public function content(): Content {
		return new Content(
			view: 'emails.test_letter__car_card',
		);
	}

	public function attachments() {
		foreach ($this->data["attached_files"] as $file) {
// fromPath() ищет файл в ROOT\public\
//		$files[] = Attachment::fromPath("FAVICONS.rar");
			$filename = 'attached_files/' . $file;
			if (Storage::disk('local')->exists($filename)) $files[] = Attachment::fromStorageDisk("local", $filename);
		}
		return $files;

	}
}