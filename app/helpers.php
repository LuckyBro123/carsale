<?php

use App\Models\_filters\AbstractFilter;
use App\Models\_filters\CarFilter;
use App\Models\_filters\LaptopFilter;
use App\Models\_filters\PhoneFilter;
use App\Models\_filters\SsdFilter;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use GeoIp2\Database\Reader;
use Illuminate\Support\Str;

/*
чтобы добавить в приложение свои хелперы:

- создал файл/файлы типа этого
- добавил его/их пути в файл composer.json:
	    "autoload": {
        "files": ["app/helpers.php"]
      },
- в консоли выполнил команду composer dump
*/

/*
// это от блогера oneCode, может потом буду использовать
if (!function_exists('active_link')) {
	function active_link(string $name, string $active = 'active'): string {
		return Route::is($name) ? $active : '';
	}
}
*/

if (!function_exists('validate')) {
	function validate(array $rules): array {
		return validator(request()->all(), $rules)->validate();
	}
}

/*
 * возвращает параметры sortMode и perPage из GET или COOKIE,
 * а также на всякий случай проверяет, исправляет и записывает в куки исправленное
 */
/*if (!function_exists('get_sortMode_perPage_and_setCookie')) {
	function get_sortMode_perPage_and_setCookie() {
		[$sortMode, $elementsPerPage] = get_sortMode_perPage();
		set_cookie("sort_mode", $sortMode, 15000);
		set_cookie("per_page", $elementsPerPage, 15000);
		return [$sortMode, $elementsPerPage];
	}
}*/

/*
 * возвращает параметры sortMode и perPage из GET или COOKIE
 */
if (!function_exists('get_sortMode_perPage')) {
	function get_sortMode_perPage($sortModeName, $perPageName, $sortModes) {
		$sortMode = request()->sort ?? ($_COOKIE["sort_mode"] ?? "");
		if (!in_array($sortMode, $sortModes)) $sortMode = $_COOKIE[$sortModeName] ?? "random";
		if (!in_array($sortMode, $sortModes)) $sortMode = "random";

		$elementsPerPage = request()->perpage ?? ($_COOKIE["per_page"] ?? "");
		if (!in_array($elementsPerPage, [15, 20, 30, 50, 100])) $elementsPerPage = $_COOKIE[$perPageName] ?? 15;
		if (!in_array($elementsPerPage, [15, 20, 30, 50, 100])) $elementsPerPage = 15;
		return [$sortMode, $elementsPerPage];
	}
}
/*
 * возвращает параметры sortMode и perPage из GET или COOKIE
 */
if (!function_exists('get_cardOrRow_viewMode')) {
	function get_cardOrRow_viewMode($viewModeName) {
		$viewMode = $_COOKIE[$viewModeName] ?? "card";
		if (isMobileViewport()) $viewMode = "card";
		if (!in_array($viewMode, ["card", "row"])) $viewMode = "card";
		return $viewMode;
	}
}

/*
 * возвращает параметры sortMode и perPage из GET или COOKIE
 */
if (!function_exists('plural_products')) {
	function plural_products($number, $pluralWords) {
		$rus = (app()->getLocale() == "ru");
		if ($rus && $number > 20) $number %= 10;
		switch ($number) {
			case 1 :
				return $pluralWords[0];
			case 2 :
			case 3 :
			case 4 :
				return $pluralWords[1];
			default:
				return $pluralWords[2];
		}
	}
}

// возвращает массив параграфов, из которых состоит текст
if (!function_exists('text2paragraphs')) {
	function text2paragraphs($text) {
		// Разделение текста на абзацы
		$paragraphs = preg_split('/\n+/', $text);

		// Удаление пустых абзацев и обрезка пробельных символов
		$paragraphs = array_filter(array_map('trim', $paragraphs));

		// Преобразование в массив абзацев
		$paragraphs = array_values($paragraphs);

		return $paragraphs;
	}
}

/*
 * делит строку на абзацы и помещает каждый из них внутрь тега <p>. И возвращает всё это в виде одной строки
 */
if (!function_exists('text2paragraphs_html')) {
	function text2paragraphs_html($strOrArrayOfStrings) {
		$filter_paragraph = function ($paragraphStr) {
			if (strlen($paragraphStr)) return "<p>$paragraphStr</p>";
			else return "";
		};
		switch (gettype($strOrArrayOfStrings)) {
			case "string" :
				return join(array_map($filter_paragraph, preg_split('~((\r)?\n){2,}~', $strOrArrayOfStrings)));
			case "array" :
				return join(array_map($filter_paragraph, $strOrArrayOfStrings));
			default:
				return $strOrArrayOfStrings;
		}
	}
}

if (!function_exists('set_flag_tableUpdated_in_cache')) {
	function set_flag_tableUpdated_in_cache($model) {
		$tableName = $model->getTable();
		Cache__tags("FILTERS $tableName")->forever("TABLE $tableName UPDATED", 1);
		Log::channel('for_debug')->info("__ProductModel::created() : TABLE $tableName UPDATED");
	}
}

if (!function_exists('create_all_filter_tables')) {
	function create_all_filter_tables() {
		// это только для себя. В реальном проекте таблица должна создаваться из ввода владельца / админа
		AbstractFilter::createFiltersBasicDataTable();

		$filterClasses = [CarFilter::class, LaptopFilter::class, PhoneFilter::class, SsdFilter::class];
		Cache__tags("FILTERS")->flush();

		foreach ($filterClasses as $filterClass) {
			$filterClass::createFilterTable();
		}
	}
}

if (!function_exists('move_file_between_disks')) {
	function move_file_between_disks($diskFrom, $filenameFrom, $diskTo, $filenameTo) {
		if (in_array($diskFrom, ["local", "public"]) && in_array($diskTo, ["local", "public"])) {
			$pathFrom = Storage::disk($diskFrom)->path("") . $filenameFrom;
			$pathTo = Storage::disk($diskTo)->path("") . $filenameTo;
			return rename($pathFrom, $pathTo);;
		} else if (in_array($diskFrom, ["local", "public"]) && $diskTo == "S3") {
			$pathFrom = Storage::disk($diskFrom)->path("") . $filenameFrom;
			return Storage::disk($diskTo)->put($filenameTo, file_get_contents($pathFrom));;
		}
		return false;
	}
}

if (!function_exists('get_compare_and_favorites_lists')) {
	function get_compare_and_favorites_lists($productTableName) {
		$compareElems = json_decode($_COOKIE[$productTableName . "_compare_elems"] ?? "[]");
		$favoritesElems = json_decode($_COOKIE[$productTableName . "_favorites_elems"] ?? "[]");
		return [$compareElems, $favoritesElems];
	}
}

// для отладки. Очищает файл w:\domains\car-sale\storage\logs\laravel.log
if (!function_exists('log_clear')) {
	function log_clear($channel = "laravel") {
		$logPath = storage_path('logs/' . $channel . '.log');

		if (file_exists($logPath)) {
			file_put_contents($logPath, '');
		}
	}
}

// ДЛЯ ОТЛАДКИ. Очищает файл w:\domains\car-sale\storage\logs\mail.log
if (!function_exists('clear_log_mail')) {
	function clear_log_mail() {
		$logPath = storage_path('logs/mail.log');

		if (file_exists($logPath)) {
			file_put_contents($logPath, '');
		}
	}
}

// возвращает отсортированный список только файлов из Storage:: $disk + $path
if (!function_exists('get_sorted_files_from_storage')) {
	function get_sorted_files_from_storage($disk, $path, $sortType, $sortAscDesc) {
		$files = Storage::disk($disk)->files($path); // Укажите путь к вашему хранилищу

		usort($files, function ($a, $b) use ($sortType, $sortAscDesc) {
			if ($sortType === 'name') {
				$result = Str::afterLast($sortAscDesc === 'asc' ? $a : $b, '/');
				$compare = Str::afterLast($sortAscDesc === 'asc' ? $b : $a, '/');
			} elseif ($sortType === 'size') {
				$result = Storage::size($sortAscDesc === 'asc' ? $a : $b);
				$compare = Storage::size($sortAscDesc === 'asc' ? $b : $a);
			} elseif ($sortType === 'date') {
				$result = Storage::lastModified($sortAscDesc === 'asc' ? $a : $b);
				$compare = Storage::lastModified($sortAscDesc === 'asc' ? $b : $a);
			} else {
				$result = Str::afterLast($sortAscDesc === 'asc' ? $a : $b, '/');
				$compare = Str::afterLast($sortAscDesc === 'asc' ? $b : $a, '/');
			}

			if ($result == $compare) {
				return 0;
			}

			return ($result < $compare) ? -1 : 1;
		});

		$sortedFileNames = array_map(function ($file) {
			return Str::afterLast($file, '/');
		}, $files);

		return $sortedFileNames;
	}
}

/* ******************************************************************
 Приблизительно определяет устройство и возвращает одно из 3х значений, учитывая, что размеры экрана и ориентацию экрана получить невозможно:
 "PHONE" - для телефона или мелкого планшета
 "TABLET" - для планшета побольше
 "DESKTOP" - для компьютера
 */
if (!function_exists('detectViewDevice')) {
	function detectViewDevice() {
		$PHONE = "PHONE";
		$DESKTOP = "DESKTOP";

		$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

		$hasMobileOS = preg_match('/android|ios|iphone|ipad|ipod|windows phone|webos|playbook/i', $userAgent);
		$hasLinuxOS = preg_match('/linux/i', $userAgent) && !preg_match('/android/i', $userAgent);
		$isDesktopOS = preg_match('/windows|win64|win32|macintosh/i', $userAgent) && !preg_match('/windows phone/i', $userAgent);

		if ($isDesktopOS) return $DESKTOP;
		if ($hasMobileOS) return $PHONE;
		if ($hasLinuxOS) return $DESKTOP;

		return $DESKTOP; // default
	}
}
if (!function_exists('isMobileViewport')) {
	function isMobileViewport() {
		return detectViewDevice() == "PHONE";
	}
}
if (!function_exists('isDesktopViewport')) {
	function isDesktopViewport() {
		return detectViewDevice() == "DESKTOP";
	}
}

// ДЛЯ ОТЛАДКИ.
if (!function_exists('echo_tag_head')) {
	function echo_tag_head($livejs = true) {
		if (is_admin()) $title = "TEST admin"; else $title = "TEST guest";
		echo "<head><title>$title</title>";
		echo "<link rel='icon' href='" . asset('/img/favicons/favicon_test.png') . "' type='image/x-icon'>";
		echo '<script src="' . asset('/plugins/jquery-3.7.1.min.js') . '" type="text/javascript"></script>';
		echo '<link href="' . asset('/css/test.css') . '" rel="stylesheet"/>';
		if ($livejs) echo '<script src="' . asset('/plugins/live_only_JS_and_css.js') . '" type="text/javascript"></script>';
		echo '<script src="' . asset('/js/test.js') . '" type="text/javascript"></script>';
		echo '</head>';
		return;
//		cleanPhotosOfGarbage();
//		cleanDiskOf_temp_photos_Garbage(24 * 1);
	}
}

// ДЛЯ ОТЛАДКИ. выводит время в формате  11 : 30 : 45
if (!function_exists('now_time')) {
	function now_time($livejs = true) {
		return Carbon::now()->format('H : i : s');
	}
}

// даёт IP входящего запроса
if (!function_exists('get_request_IP')) {
	function get_request_IP() {
		// Проверяем, если запрос пришел через прокси-сервер
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// Если в заголовке X-Forwarded-For несколько IP, то первый в списке — это реальный IP
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			// В случае использования другого типа прокси или серверов
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			// Если запрос напрямую с клиента
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			// Если не удалось определить IP
			$ip = '0.0.0.0';  // или throw new Exception('Could not determine IP address');
		}

		// Возвращаем первый IP из списка, если X-Forwarded-For содержит несколько
		$ipList = explode(',', $ip);
		return trim($ipList[0]);
	}
}

//
if (!function_exists('IP_in_range')) {
	function IP_in_range($ip, $range) {
		// Если это просто IP без маски
		if (strpos($range, '/') === false) {
			return $ip === $range;
		}

		// Разбиваем CIDR на IP и маску
		[$range, $netmask] = explode('/', $range, 2);

		// Конвертируем IP адреса в числа
		$ip_decimal = ip2long($ip);
		$range_decimal = ip2long($range);

		// Создаём битовую маску на основе CIDR
		$wildcard = pow(2, (32 - $netmask)) - 1;
		$netmask_decimal = ~$wildcard;

		// Проверяем, попадает ли IP в диапазон
		return ($ip_decimal & $netmask_decimal) === ($range_decimal & $netmask_decimal);
	}
}

// даёт страну по IP входящего запроса
if (!function_exists('getCountryByIp')) {
	function getCountryByIp($ipAddress = false) {
		if (!$ipAddress) $ipAddress = get_request_IP();
		if (in_array($ipAddress, ["127.0.0.1", "127.0.0.1"])) return "_ home _";
		// Путь к файлу базы данных GeoLite2-Country.mmdb в каталоге storage/app
		$databasePath = storage_path('app/GeoLite2-Country.mmdb');
		$reader = new Reader($databasePath);

		try {
			$record = $reader->country($ipAddress);
			return $record->country->name;
		} catch (Exception $e) {
			// Обработка исключения, например, когда IP не найден в базе данных
			return "►unknown country";
		}
	}
}

// возвращает true если token и allowed_IP правильные
if (!function_exists('is_admin')) {
	function is_admin(): bool {
		return request()->get('is_admin', false);
	}
}

// возвращает true если входящий IP из allowed_IP
if (!function_exists('is_allowed_IP')) {
	function is_allowed_IP(): bool {
		return request()->get('is_allowed_IP', false);
	}
}

// возвращает true если в строке $str есть хоть одно слово из массива $wordsArray
if (!function_exists('isStrContainsWordFromArray')) {
	function isStrContainsWordFromArray($str, $words) {
		$words = collect($words);

		$containsWord = $words->contains(function ($words) use ($str) {
			return Str::contains($str, $words);
		});

		return $containsWord;
	}
}

// удаляет слова $words из строки $str, если они в ней есть
if (!function_exists('removeWordsFromStr')) {
	function removeWordsFromStr($str, $words) {
		foreach ($words as $word) {
			$str = str_replace($word, '', $str);
		}
		return $str;
	}
}

// удаляет слова $words из строки $str, если они в ней есть
if (!function_exists('Cache__tags')) {
	function Cache__tags(...$tags) {
		return \App\Services\Cache\CacheService::tags(...$tags);
	}
}

// то же что file_put_contents, но создаёт папку и файт, если их нету 
if (!function_exists('file_put_contents_my')) {
	function file_put_contents_my(string $filePath, string $content): bool {
		// Получаем путь к директории файла
		$dirPath = dirname($filePath);

		// Проверяем существование директории и создаём её, если нужно
		if (!is_dir($dirPath)) {
			if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
				// Если создание директории не удалось, возвращаем false
				return false;
			}
		}

		// Пытаемся записать содержимое в файл
		if (file_put_contents($filePath, $content) === false) {
			// Если запись не удалась, возвращаем false
			return false;
		}

		// Всё успешно, возвращаем true
		return true;
	}
}

// устанавливает куку, на заданное колво минут
if (!function_exists('set_cookie')) {
	function set_cookie($name, $value, $minutes) {
		setcookie($name, $value, ['expires' => time() + $minutes * 60, 'path' => '/']);
	}
}

/*
 * считает количество файлов ТОЛЬКО указанной в папке, т.е. на первом уровне, внутрь папок не заходит
 */
if (!function_exists('count_files')) {
	function count_files($path) {
		$dir = scandir($path);
		$count = 0;
		foreach ($dir as $elem) if (!is_dir($elem)) $count++;
		return $count;
	}
}

// удаляет ВСЁ внутри указанной папки path, саму папку не трогает
if (!function_exists('erase_dir_tree_inside')) {
	function erase_dir_tree_inside($path) {
		static $start_path = "";
		if (!$start_path) $start_path = $path;
		$dir = opendir($path);
		while ($file = readdir($dir)) {
			if (($file != ".") && ($file != "..")) {
				$full_path = $path . "/" . $file;
				if (is_dir($full_path)) erase_dir_tree_inside($full_path);
				else unlink($full_path);
			}
		}
		closedir($dir);
		if ($start_path != $path) rmdir($path);
		else $start_path = "";
	}
}

// удаляет папку и всё внутри 
if (!function_exists('remove_dir')) {
	function remove_dir($path) {
		erase_dir_tree_inside($path);
		rmdir($path);
	}
}

// 
if (!function_exists('get_product_tables_last_IDs')) {
	function get_product_tables_last_IDs() {
		$filePath = Str::finish(base_path(), '/') . 'database/productTablesLastIDs.json';
		if (file_exists($filePath)) return json_decode(file_get_contents($filePath), true);
		else return ["cars"    => 1000000,
		             "laptops" => 1000000,
		             "phones"  => 1000000,
		             "ssds"    => 1000000];
	}
}

