<?php

namespace App\Http\Controllers;

class AdminController extends Controller {
	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function deploy() {
		$parameter = "deploy";
		include base_path('deploy.php');
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function deploylog() {
		$parameter = "display deploy log";
		include base_path('deploy.php');
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function debuglog() {
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
            line-height: 1.5;
        }
        * {
            box-sizing: border-box;
        }
    </style>';

		echo '<head><title>LOG debug</title></head>';
		echo $styles;

		$filename = base_path('storage/logs/for_debug.log');
		if (!file_exists($filename)) {
			echo "<span style='font-weight: bold; color: #a40000'>НЕТУ файла $filename</span><br>";
			return;
		}
		$log_content = file_get_contents($filename);
		$log_content = nl2br(htmlspecialchars($log_content, ENT_QUOTES, 'UTF-8'));
		echo "▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀<br>";
		echo "--------------------   for_debug.log   --------------------------<br>";
		echo "▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀<br>";
		echo "$log_content<br>";
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function test() {

//		эта функция не нужна, можно УДАЛИТЬ
		$data = ["url" => "AdminController test()", "ip" => "100", "method" => "xxx", "time" => \Carbon\Carbon::now()];
		\App\Models\Visit::create($data);

		dd("выполняется AdminController->test");
	}
	public function index() {
	}
}
