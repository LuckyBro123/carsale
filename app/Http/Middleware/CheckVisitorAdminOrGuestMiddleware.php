<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class CheckVisitorAdminOrGuestMiddleware {
	public function handle(Request $request, Closure $next) {
//		echo "начало CheckVisitorAdminOrGuestMiddleware <br>";

		// Получаем токен из запроса
		$token = request()->input('token') ?? $_COOKIE['token'] ?? "";
		if ($token) set_cookie("token", $token, 1200);// сохранить на 20 часов
		$isCorrectToken = $token === config('app.URL_ACCESS_TOKEN');

		// теперь надо сверить IP посетителя с моим или гитхабными
		// Удаляем кавычки из строки
		$str = str_replace('"', '', config('app.ALLOWED_IP'));
		// Разделяем строку на массив строк по пробелам
		$IPs = explode(' ', $str);
		// сравниваю
		$clientIP = get_request_IP();
		$isAllowedIP = !empty(array_filter($IPs, fn($IP) => IP_in_range($clientIP, $IP)));

		if ($isAllowedIP) $request->merge(['is_allowed_IP' => true]);
		if ($isCorrectToken && $isAllowedIP) $request->merge(['is_admin' => true]);
		else $request->merge(['is_admin' => false]);

//		echo "конец CheckVisitorAdminOrGuestMiddleware <br>";

		return $next($request);
	}
}
