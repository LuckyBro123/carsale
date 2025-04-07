<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('cars_photos', function (Blueprint $table) {
			$table->id();
			$table->string("filename", 50)->index();
			$table->foreignId("car_id")->index();
			$table->tinyInteger("number")->default(1)->index();
			$table->string("description", 200);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('cars_photos');
	}
};
