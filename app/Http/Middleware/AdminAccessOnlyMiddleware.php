<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccessOnlyMiddleware {
	public function handle(Request $request, Closure $next) {
		if (is_admin()) return $next($request);
		else abort(403);
	}
}
