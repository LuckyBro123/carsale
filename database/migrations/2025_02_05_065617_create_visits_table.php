<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('visits', function (Blueprint $table) {
			$table->id();
			$table->string('ip', 39)->nullable();
			$table->string('url');
			$table->string('method', 7);
			$table->dateTime('time');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('visits');
	}
};
