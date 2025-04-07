<?php

namespace App\Http\Controllers\Tests;

use App\Exports\AnyTableExport;
use App\Http\Controllers\Controller;
use App\Imports\AnyTableImport;
use Maatwebsite\Excel\Facades\Excel;

class Test_CSV_ExportImport extends Controller {

	// отдаёт список CSV-файлов на сервере
	public function __invoke() {
		$csvFiles = get_sorted_files_from_storage("local", "CSV-files//", "date", "desc");
		return view("test.sections_test_csv", compact(["csvFiles"]));
	}

	public function exportTable() {

//		Excel::store(new AnyTableExport("App\Models\Car\Car"), 'CSV-files/cars.csv', 'local', "Csv");
		Excel::store(new AnyTableExport("App\Models\Ssd\Ssd"), 'CSV-files/ssds.csv', 'local', "Csv");
//		Excel::store(new AnyTableExport("App\Models\Laptop\Laptop"), 'CSV-files/phones.csv', 'local', "Csv");
//		Excel::store(new AnyTableExport("App\Models\Phone\Phone"), 'CSV-files/phones.csv', 'local', "Csv");
		return ["reply" => "OK"];
	}

	public function importTable() {
		$res = Excel::import(new AnyTableImport, 'CSV-files/laptops_brands.csv', 'local', 'Csv');
		return ["reply" => "OK", "success" => 1];

		/*		$data = request()->all();
		return ["reply" => $data["filename"] . " - файл для импорта"];*/
	}

}
