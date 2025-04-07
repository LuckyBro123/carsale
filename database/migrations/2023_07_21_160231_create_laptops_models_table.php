<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('laptops_models', function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->constrained('laptops_brands');
			$table->string("name", 100);
		});
	}

	public function down(): void {
		Schema::dropIfExists('laptops_models');
	}
};
