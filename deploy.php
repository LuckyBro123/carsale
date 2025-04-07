<?php
init($parameter);
$log[] = "IP  " . getRequestIP();
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ ПРОВЕРКА ДОСТУПА ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
$accessStatus = checkAccessRights();
if ($accessStatus) {
	echo "<span style='font-weight: bold; color: #a40000'>НЕТ ПРАВ ДОСТУПА: $accessStatus</span><br>";
	$log[] = $accessStatus;
	logData($_SERVER['DOCUMENT_ROOT'] . '/deploy.log', ...$log);
	exit(401);
}

switch ($parameter) {
	case "verify" :
		break;
	case "display deploy log" :
		displayLog();
		exit();
	case "deploy":
		deploy($log);
		exit();
}

//▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function deploy(&$log) {
	echo "Доступ РАЗРЕШЕН <br>";

// Настройки ---------------------------------------------------
	$repository = 'LuckyBro123/XXXXXXXXXXXXX';
	$branch = 'main';
	$token_github = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';

	$targetDir = __DIR__;
	if (getRequestIP() == "127.0.0.1") $targetDir .= DIRECTORY_SEPARATOR . 'SITE_CLONE';

// Деплой из репозитория github
	echo "<br>Выполняю развёртывание из репозитория $repository ...<br>";
	$log[] = "Выполняю развёртывание из репозитория $repository ...";

	if (deployFromGithubPrivateRepository($repository, $branch, $token_github, $targetDir, $log)) {
		echo "Приватный репозиторий успешно загружен<br>";
		$log[] = "Приватный репозиторий успешно загружен";
	} else {
		echo "<span style='font-weight: bold; color: #a40000'>Чтото пошло не так и наверно деплой не состоялся</span><br>";
		$log[] = "Чтото пошло не так и наверно деплой не состоялся";
	}

	logData($_SERVER['DOCUMENT_ROOT'] . '/deploy.log', ...$log);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function deployFromGithubPrivateRepository($repo, $branch, $token_github, $targetDir, &$log) {
	// Создаем временную папку с уникальным именем
	$tempFolder = $targetDir . DIRECTORY_SEPARATOR . 'deploy_' . uniqid();
	if (!file_exists($tempFolder)) {
		mkdir($tempFolder, 0777, true);
	}

	// скачиваем zip-файл репозитория
	$zipUrl = "https://api.github.com/repos/{$repo}/zipball/{$branch}";
	$zipFile = $tempFolder . '/repo.zip';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $zipUrl);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Authorization: token {$token_github}",
		"Accept: application/vnd.github.v3+json"
	]);
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Script');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	echo "_ скачан zip-файл с содержимым github-репозитория <br>";
	$log[] = "_ скачан zip-файл с содержимым github-репозитория";

	if ($httpCode == 200) {
		file_put_contents($zipFile, $response);
		$zip = new ZipArchive();

		if ($zip->open($zipFile) === true) {
			// Находим имя подпапки внутри архива
			$firstEntry = $zip->getNameIndex(0);
			$rootFolder = explode('/', $firstEntry)[0];

			// Распаковываем содержимое во временную папку
			for ($i = 0; $i < $zip->numFiles; $i++) {
				$entry = $zip->getNameIndex($i);
				if (strpos($entry, $rootFolder . '/') === 0) {
					$newPath = $tempFolder . '/' . substr($entry, strlen($rootFolder) + 1);

					// Создаем директории если нужно
					$dir = dirname($newPath);
					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
					}

					// Если это не директория, копируем файл
					if (substr($entry, -1) != '/') {
						file_put_contents($newPath, $zip->getFromIndex($i));
					}
				}
			}
			$zip->close();
			unlink($zipFile);
			echo "_ zip-файл распакован во временную папку <br>";
			$log[] = "_ zip-файл распакован во временную папку";

			// Удаляем указанные файлы и папки
			$filesToBeDeleted = ["--- TMP", ".idea", "resources\\__other_sources", "public\\css\\scss", "_ide_helper.php", "1.cmd", "2.cmd", "config.cmd", "config_clear.cmd", "mi.cmd", "seed.cmd", "unpush.cmd"];
			foreach ($filesToBeDeleted as $fileToDelete) {
				$fullPath = $tempFolder . DIRECTORY_SEPARATOR . $fileToDelete;
				if (file_exists($fullPath)) {
					recursiveDeleteFileOrFolder($fullPath);
				}
			}
			echo "_ лишние файлы удалены, если надо было<br>";
			$log[] = "_ лишние файлы удалены, если надо было";

			/* надо переименовать. На бесплатном хостинге ножен специальный .htaccess потому что нельзя делать симлинк. Поэтому для запросов на /storage надо перенаправлять в /storage/app/public  */

			// Пример использования функции
			$directoryPath = $tempFolder . DIRECTORY_SEPARATOR; // Укажите путь к директории
			listFilesAndFolders($directoryPath);

			$sourceFile = $tempFolder . DIRECTORY_SEPARATOR . "htaccess FOR PRODUCTION.txt";
			$targetFile = $tempFolder . DIRECTORY_SEPARATOR . ".htaccess";
			renameFile($sourceFile, $targetFile);

			// Обновление настроек окружения LARAVEL
			//     infinityfree.com
			$env_file = $tempFolder . DIRECTORY_SEPARATOR . '.env';
			$env_content = file_get_contents($env_file);
			$env_updates = [
				'DB_HOST'          => 'XXXXXXXXX',
				'DB_PORT'          => '3306',
				'DB_DATABASE'      => 'XXXXXXXXXXXXXXX',
				'DB_USERNAME'      => 'XXXXXXX',
				'DB_PASSWORD'      => 'XXXXXXXXXXXX',
				'APP_URL'          => 'XXXXXXXXXXXX',
				'APP_ENV'          => 'production',
				'APP_DEBUG'        => 'true',
				'CACHE_DRIVER'     => 'database',
				'SESSION_DRIVER'   => 'file',
				'QUEUE_CONNECTION' => 'database',
				'FREE_HOSTING'     => 'true',
			];
			foreach ($env_updates as $key => $value) {
				$env_content = preg_replace(
					"/^$key=.*/m",
					"$key=$value",
					$env_content
				);
			}
			file_put_contents($env_file, $env_content);
			echo "_ изменены настройки в файле .env для продакшена<br>";
			$log[] = "_ изменены настройки в файле .env для продакшена";

			try {
				// Перемещаем файлы из временной папки в целевую
				$files = array_diff(scandir($tempFolder), ['.', '..']);
				foreach ($files as $file) {
					$sourcePath = $tempFolder . DIRECTORY_SEPARATOR . $file;
					$targetPath = $targetDir . DIRECTORY_SEPARATOR . $file;

					// Если в целевой директории уже есть такой файл/папка
					if (file_exists($targetPath)) {
						// Проверяем, не является ли путь protected storage или его родителем
						if (!is_dir($sourcePath)) recursiveDeleteFileOrFolder($targetPath);
						else if (!shouldPreservePath($targetPath)) recursiveDeleteFileOrFolder($targetPath);
					}

					// Перемещаем файл или папку
					if (is_dir($sourcePath)) {
						// Если директория существует и это protected path, пропускаем
						if (file_exists($targetPath) && shouldPreservePath($targetPath)) {
							echo "<b>$targetPath </b> <br> ";
							continue;
						}
						recursiveRenameFileOrFolder($sourcePath, $targetPath);
					} else {
						// Если файл существует и находится в protected path, пропускаем
						if (file_exists($targetPath) && shouldPreservePath($targetPath)) {
							echo "$targetPath<br>";
							continue;
						}
						recursiveRenameFileOrFolder($sourcePath, $targetPath);
					}
				}
			} catch (TypeError $e) {
				// Обработка ошибки типа (например, если передан неверный аргумент)
				echo "Ошибка типа: " . $e->getMessage() . "<br>";
			} catch (Error $e) {
				// Обработка других ошибок уровня Error
				echo "Ошибка: " . $e->getMessage() . "<br>";
			} catch (Exception $e) {
				// Обработка всех остальных исключений
				echo "Исключение: " . $e->getMessage() . "<br>";
			} finally { // Этот блок выполнится в любом случае
			}

			echo "_ новые файлы перенесён в папку назначения с замещением и без удаления старых, если их нету в новой версии сайта<br>";
			$log[] = "_ новые файлы перенесён в папку назначения с замещением и без удаления старых, если их нету в новой версии сайта";

			// Удаляем временную папку
			recursiveDeleteFileOrFolder($tempFolder, true);
			echo "_ временная папка удалена<br>";
			$log[] = "_ временная папка удалена";
			return true;
		}
	}

	// В случае ошибки удаляем временную папку
	if (file_exists($tempFolder)) {
		recursiveDeleteFileOrFolder($tempFolder);
	}
	return false;
}

// проверяет, нужно ли сохранить данный путь
function shouldPreservePath($path) {
	// Нормализуем путь для корректного сравнения
	$normalizedPath = str_replace('\\', '/', $path);
	$protectedPath = 'storage/app/public';
	// Проверяем, является ли путь protected directory или находится внутри неё
	return strpos($normalizedPath, $protectedPath) !== false;
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// переносит файл или папку со всем содержимым
function recursiveRenameFileOrFolder($sourcePath, $targetPath) {
	// Если это файл - просто переименовываем
	if (!is_dir($sourcePath)) {
		if (!file_exists($targetPath)) {
			return rename($sourcePath, $targetPath);
		}
		return false;
	}

	// Если целевая директория не существует - создаём её
	if (!file_exists($targetPath)) {
		mkdir($targetPath, 0777, true);
	}

	// Получаем список всех файлов и папок в исходной директории
	$files = array_diff(scandir($sourcePath), ['.', '..']);

	// Флаг успешности всей операции
	$success = true;

	// Перебираем все файлы и папки
	foreach ($files as $file) {
		$currentSource = $sourcePath . DIRECTORY_SEPARATOR . $file;
		$currentTarget = $targetPath . DIRECTORY_SEPARATOR . $file;

		if (is_dir($currentSource)) {
			// Рекурсивно обрабатываем поддиректории
			$success = recursiveRenameFileOrFolder($currentSource, $currentTarget) && $success;
		} else {
			// Перемещаем файл, если в целевой директории его еще нет
			if (!file_exists($currentTarget)) {
				$success = rename($currentSource, $currentTarget) && $success;
			}
		}
	}

	// После перемещения всего содержимого удаляем исходную папку
	if ($success && is_dir($sourcePath)) {
		return rmdir($sourcePath);
	}

	return $success;
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// удаляет файл или папку со всем содержимым
function recursiveDeleteFileOrFolder($path, $deleteAnyway = false) {
	try {
		// Проверяем, нужно ли сохранить этот путь
		if (shouldPreservePath($path) && !$deleteAnyway) return false;
		if (is_file($path)) return unlink($path);

		if (is_dir($path)) {
			$files = array_diff(scandir($path), ['.', '..']);
			foreach ($files as $file) {
				recursiveDeleteFileOrFolder($path . DIRECTORY_SEPARATOR . $file);
			}
			// Проверяем ещё раз перед удалением директории
			// (она может быть родителем protected path)
			if ($deleteAnyway) return rmdir($path);
			if (!shouldPreservePath($path)) return rmdir($path);
			return false;
		}
		return false;
	} catch (TypeError $e) {
		// Обработка ошибки типа (например, если передан неверный аргумент)
		echo "Ошибка типа: " . $e->getMessage() . "<br>";
	} catch (Error $e) {
		// Обработка других ошибок уровня Error
		echo "Ошибка: " . $e->getMessage() . "<br>";
	} catch (Exception $e) {
		// Обработка всех остальных исключений
		echo "Исключение: " . $e->getMessage() . "<br>";
	} finally { // Этот блок выполнится в любом случае
	}
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// первые строки, убрал чтобы не мешали на код смотреть
function init(&$parameter) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	if (!isset($parameter)) $parameter = "deploy";
	switch ($parameter) {
		case "verify" :
			break;
		case "display deploy log" :
			echo '<head><title>LOG deploy</title></head>';
			break;
		case "deploy":
			echo '<head><title>DEPLOY.php</title></head>';
			break;
	}
	addFontRobotoForHTMLBodyTag();
	date_default_timezone_set('Europe/Kiev');
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function getRequestIP() {
	// Проверяем, если запрос пришел через прокси-сервер
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		// Если в заголовке X-Forwarded-For несколько IP, то первый в списке — это реальный IP
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		// В случае использования другого типа прокси или серверов
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		// Если запрос напрямую с клиента
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	// Возвращаем первый IP из списка, если X-Forwarded-For содержит несколько
	$ipList = explode(',', $ip);
	return trim($ipList[0]);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function IPinRange($ip, $range) {
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

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function checkAccessRights() {
	$URLaccessToken = "XXXXXXXXXXXXXXXXXXXXXXX";

// Проверяем GET пара метр
	if (!isset($_GET['token']) || $_GET['token'] !== $URLaccessToken) return "доступ ЗАПРЕЩЕН, неверный токен";

	echo 'IP-адрес: ' . getRequestIP() . " ___ " . date("H:i _ d M Y") . "<br><br> ";
	// ▪▪▪▪▪▪ проверка по IP
	$allowedIPs = [
		'127.0.0.1',
		'127.0.0.1',
		'127.0.0.1',
		"127.0.0.1"];
	$clientIP = getRequestIP();
	$accessAllowed = !empty(array_filter($allowedIPs, fn($IP) => IPinRange($clientIP, $IP)));
	return $accessAllowed ? "" : "доступ ЗАПРЕЩЕН, чужой IP";
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
//// запись переменных в файл, для простого логирования
function logData($filename, ...$vars) {
	$vars = array_reverse($vars);
	array_unshift($vars, "------------------------------------------------\n");
	date_default_timezone_set('Europe/Paris');
	$timestamp = date("H:i _ d M Y");

	try {
		if (!file_exists($filename)) {
			// file_put_contents() создаст файл, если его нет,
			// и запишет в него пустую строку
			echo "<span style = 'font-weight: bold; color: #000ea4'> file_exists() не нашел файл $filename, поэтому создаю его:</span><br> ";
			file_put_contents($filename, '');
			echo "создан  $filename<br>";
		}
	} catch (TypeError $e) {
		// Обработка ошибки типа (например, если передан неверный аргумент)
		echo "Ошибка типа: " . $e->getMessage();
	} catch (Error $e) {
		// Обработка других ошибок уровня Error
		echo "Ошибка: " . $e->getMessage();
	} catch (Exception $e) {
		// Обработка всех остальных исключений
		echo "Исключение: " . $e->getMessage();
	}

	$currentData = file($filename);
	// Добавляем каждую переменную на отдельной строке
	foreach ($vars as $var) {
		array_unshift($currentData, $var . "\n");
	}
	// Добавляем новую строку с временной меткой в начало
	array_unshift($currentData, "(●) " . $timestamp . "\n");

	try {
		// Записываем обновленный массив обратно в файл
		file_put_contents($filename, $currentData);
	} catch (TypeError $e) {
		// Обработка ошибки типа (например, если передан неверный аргумент)
		echo "Ошибка типа: " . $e->getMessage();
	} catch (Error $e) {
		// Обработка других ошибок уровня Error
		echo "Ошибка: " . $e->getMessage();
	} catch (Exception $e) {
		// Обработка всех остальных исключений
		echo "Исключение: " . $e->getMessage();
	}
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function addFontRobotoForHTMLBodyTag() {
	// CSS стили
	$styles = '
    <style>
        body {
						padding: 1rem !important;
            font-family: "Roboto", sans-serif !important;
            font-size: 16px !important;
            color: #000000;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        * {
            box-sizing: border-box;
        }
    </style>';

	// Проверяем, если уже нет стилей в head, добавляем их
	echo $styles;
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// показать deploy.log
function displayLog() {
	$filename = $_SERVER['DOCUMENT_ROOT'] . '/deploy.log';

	if (!file_exists($filename)) {
		echo "<span style = 'font-weight: bold; color: #a40000'> НЕТУ файла $filename </span><br> ";
		return;
	}
	echo "_ читаю из $filename<br>";
	$log_content = file_get_contents($filename);
	$log_content = nl2br(htmlspecialchars($log_content, ENT_QUOTES, 'UTF-8'));
	echo "<br><br> ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀<br> ";
	echo "--------------------DEPLOY.LOG----------------------------<br>";
	echo "▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀<br>";
	echo "$log_content<br>";
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function renameFile($sourceFile, $targetFile) {
// Проверяем, существует ли исходный файл
	if (file_exists($sourceFile)) {
		// Если целевой файл уже существует, удаляем его для перезаписи
		if (file_exists($targetFile)) {
			if (!unlink($targetFile)) {
				echo "<span style = 'font-weight: bold; color: #a40000'> Ошибка: Не удалось удалить существующий файл '$targetFile' . </span><br> ";
			}
		}
		// Переименовываем исходный файл в целевой
		if (!rename($sourceFile, $targetFile))
			echo "<span style = 'font-weight: bold; color: #a40000'> Ошибка: Не удалось переименовать файл '$sourceFile' в '$targetFile' .</span><br> ";
	} else
		echo "<span style = 'font-weight: bold; color: #a40000'> Ошибка: Исходный файл '$sourceFile' не найден .</span><br> ";
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ДЛЯ ОТЛАДКИ, выводит содержимое папки на экран
function listFilesAndFolders($path) {
	echo "<br>==================================";
	// Проверяем, существует ли указанный путь
	if (!is_dir($path)) {
		echo "<span style = 'font-weight: bold; color: #a40000'> Ошибка: Указанный путь '$path' не существует или не является директорией .</span><br> ";
		return;
	}

	// Получаем содержимое директории
	$items = scandir($path);

	// Массивы для хранения папок и файлов
	$folders = [];
	$files = [];

	// Разделяем содержимое на папки и файлы
	foreach ($items as $item) {
		// Пропускаем специальные директории " . " и " .."
		if ($item === '.' || $item === '..') {
			continue;
		}

		$fullPath = $path . DIRECTORY_SEPARATOR . $item;

		if (is_dir($fullPath)) {
			$folders[] = $item;
		} else {
			$files[] = $item;
		}
	}

	// Сортируем папки и файлы в алфавитном порядке
	sort($folders);
	sort($files);

	// Выводим папки
	echo "<br><i> Папки:</i><br> ";
	foreach ($folders as $folder) {
		echo "<b> $folder</b><br> ";
	}

	// Выводим файлы
	echo "<br><i> Файлы:</i><br> ";
	foreach ($files as $file) {
		echo "$file <br>";
	}
	echo " ==================================<br><br> ";
}

