<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Paginator::useBootstrapFive();
		Paginator::queryStringResolver(function () {
			return collect(request()->query())
				->except(['is_admin', 'is_allowed_IP'])
				->all();
		});
	}
}
