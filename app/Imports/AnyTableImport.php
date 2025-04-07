<?php

namespace App\Imports;

use App\Models\Car\Car;
use App\Models\Laptop\LaptopBrand;
use App\Models\Ssd\Ssd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class AnyTableImport implements ToModel, WithUpserts {

	public function __construct() {
	}

	/* @param array $row
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row) {
		/*		return new Car([
					"id"               => $row[0],
					"brand_id"         => $row[1],
					"model_id"         => $row[2],
					"body_type_id"     => $row[3],
					"color_id"         => $row[4],
					"gearbox_id"       => $row[5],
					"engine_type_id"   => $row[6],
					"engine_capacity"  => $row[7],
					"engine_power"     => $row[8],
					"fuel_consumption" => $row[9],
					"production_year"  => $row[10],
					"clearance"        => $row[11],
					"wheelbase"        => $row[12],
					"number_doors"     => $row[13],
					"number_places"    => $row[14],
					"length"           => $row[15],
					"width"            => $row[16],
					"height"           => $row[17],
					"mileage"          => $row[18],
					"was_in_accident"  => $row[19],
					"price"            => $row[20],
				]);*/
		return new LaptopBrand([
			"id"   => $row[0],
			"name" => $row[1]
		]);
/*		return new Ssd([
			"id"           => $row[0],
			"brand_id"     => $row[1],
			"model_id"     => $row[2],
			"type"         => $row[3],
			"capacity"     => $row[4],
			"interface_id" => $row[5],
			"speed_read"   => $row[6],
			"speed_write"  => $row[7],
			"price"        => $row[8],
		]);*/

	}

	public function uniqueBy() {
		return 'id';
	}

}
