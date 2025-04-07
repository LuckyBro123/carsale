<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedIpAccessOnlyMiddleware {
	public function handle(Request $request, Closure $next) {
		if (config('app.debug')) return $next($request);
		if (is_allowed_IP()) return $next($request);
		else abort(403);
	}
}
