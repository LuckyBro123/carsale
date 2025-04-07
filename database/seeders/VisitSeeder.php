<?php

namespace Database\Seeders;

use App\Models\Car\Car;
use App\Models\User;
use App\Models\User\UserPhone;
use App\Models\Visit;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Visit::factory()->count(mt_rand(100, 150))->create();
	}
}

