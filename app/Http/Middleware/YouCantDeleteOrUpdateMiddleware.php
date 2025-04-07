<?php

namespace App\Http\Middleware;

use App\Exceptions\YouCantDeleteOrUpdateException;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class YouCantDeleteOrUpdateMiddleware {

	public function handle(Request $request, Closure $next, string $actionType, int $secondParam) {
//		if (config('app.debug')) return $next($request);

		/* если это админ, то можно редактировать и удалять любую запись, если это гость, то только созданные пользователями, а сгенерированные нельзя */
		if (is_admin()) return $next($request);

		$productTablesLastIDs = get_product_tables_last_IDs();
		switch ($actionType) {
			case "update" :  // это POST запрос
				// если это кемто созданныя запись, то удаляю и редирект...
				if (request()->id > $productTablesLastIDs["cars"]) return $next($request);

				// ... а сгенерированные записи нельзя модифицировать
				$errorMessage = __("You can modify only a user-created car");
				throw new YouCantDeleteOrUpdateException($errorMessage);

			case "delete" :  // это GET запрос


				// если это кемто созданныя запись, то удаляю и редирект...
				if (request()->id > $productTablesLastIDs["cars"]) return $next($request);

				// ... а сгенерированные записи нельзя удалять
				// Сохраняем сообщение об ошибке в сессии
				Session::flash('error', __("You can delete only a user-created car"));
				// Перенаправляем пользователя обратно на предыдущую страницу
				return redirect()->back();
		}
	}

}
