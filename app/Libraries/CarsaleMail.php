<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Blade;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CarsaleMail {
	protected static $mailer;

	public static function mailer($name = null) {
		if (!self::$mailer) {
			$config = config('mail.mailers.mailgun'); // Берем настройки из config/mail.php

			self::$mailer = new PHPMailer(true);
			self::$mailer->isSMTP();
			self::$mailer->Host = $config['host'];
			self::$mailer->SMTPAuth = true;
			self::$mailer->Port = $config['port'];
			self::$mailer->Username = $config['username'];
			self::$mailer->Password = $config['password'];
			self::$mailer->SMTPSecure = $config['encryption'];

			// Устанавливаем кодировку UTF-8
			self::$mailer->CharSet = 'UTF-8';
		}
		return new static;
	}

	public function send($letterData) {
		try {
			// Рендерим Blade-шаблон
			$data = [
				'data' => [
					'message'      => $letterData['message'],
					'sender_email' => $letterData['sender_email']
				]
			];
			$htmlBody = Blade::render(
				file_get_contents(resource_path('views/emails/phpmail__contacts_letter_template.blade.php')),
				$data
			);

			// Настраиваем письмо
			self::$mailer->setFrom($letterData['from'], 'Car Sale Contacts');
			self::$mailer->addAddress($letterData['to']);
			self::$mailer->isHTML(true);
			self::$mailer->Subject = $letterData['subject'];
			self::$mailer->Body = $htmlBody;
			self::$mailer->AltBody = strip_tags($htmlBody);

			// Отправляем
			self::$mailer->send();
		} catch (Exception $e) {
			throw new \Exception("Ошибка отправки: " . self::$mailer->ErrorInfo);
		}
	}
}