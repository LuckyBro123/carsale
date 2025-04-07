<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VisitFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		$name = $this->faker->name();
		return [
			"ip"     => $this->faker->ipv4,
			"url"    => removeWordsFromStr($this->faker->url, ["https://", "http://"]),
			"method" => mt_rand(0, 1) ? "GET" : "POST",
			"time"   => $this->faker->dateTime
		];
	}
}
