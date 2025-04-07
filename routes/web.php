<?php

use Illuminate\Support\Facades\Route;
use App\Models\Visit;

// *** ДЛЯ ОТЛАДКИ
//log_clear();
if (config('app.debug') /*&& !config('app.FREE_HOSTING')*/) {
	// очистить лог отладки
	file_put_contents_my(storage_path("logs/for_debug.log"), "");
}
// надо записать факт посещения сайта в таблицу visits
Visit::saveNewVisit();

// ****  PAGES  **************************************************
Route::group(["namespace" => "\App\Http\Controllers\Car"], function () {
	Route::get('/', "IndexController")->name("cars.index");
	Route::get('/latest', "LatestController")->name("cars.latest");
	Route::get('/cardview', "CardViewController")->name("cars.cardview");
	Route::get('/listview', "ListViewController")->name("cars.listview");
	Route::get('/search', "SearchController")->name("cars.search");
	Route::post('/search', "DynamicSearchController")->name("cars.dynamic_search");
	Route::get('/compare', "CompareController")->name("cars.compare");
	Route::get('/favorites', "FavoritesController")->name("cars.favorites");
	Route::get('/categories', function () { return view("category_selection.sections_categories"); })->name("categories");
	Route::get('/view_car/{id}', "ViewController")->name("car.view");
	Route::post('/get_statistics', "GetStatisticsController")->name("cars.get_statistics");
	//                                                                    --
	Route::get('/create', "CreateController")->name("cars.create");/*->middleware("cars.create");*/
	Route::post('/create', "StoreController")->name("cars.store");/*->middleware("cars.create");*/
	Route::post('/photo-upload', "PhotoUploadController")->name("cars.photo-upload");/*->middleware("cars.create");*/
	Route::post('/delete-uploaded-photo', "DeleteUploadedPhotoController")->name("cars.delete-uploaded-photo");
//                                                                    --
	Route::get('/edit_car/{id}', "EditController")->name("cars.edit");/*->middleware("cars.update");*/
	Route::post('/edit_car/{id}', "UpdateController")->name("cars.update")
		->middleware("\App\Http\Middleware\YouCantDeleteOrUpdateMiddleware:update,12345");

	Route::get('/delete_car/{id}', "DeleteController")->name("cars.delete")
		->middleware("\App\Http\Middleware\YouCantDeleteOrUpdateMiddleware:delete,12345");

});

Route::group(["namespace" => "\App\Http\Controllers\Laptop"], function () {
	Route::get('/laptops/', "IndexController")->name("laptops.index");
});

Route::group(["namespace" => "\App\Http\Controllers\Phone"], function () {
	Route::get('/phones/', "IndexController")->name("phones.index");
});

Route::group(["namespace" => "\App\Http\Controllers\Ssd"], function () {
	Route::get('/ssds/', "IndexController")->name("ssds.index");
});

// ▪▪▪▪  FILTERS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::get('/create_filters', [\App\Http\Controllers\FilterController::class, "index"])->middleware("\App\Http\Middleware\AdminAccessOnlyMiddleware");;
Route::post('/calculate_filters', [\App\Http\Controllers\FilterController::class, "carsCalculateFilters"]);
Route::post('/laptops/calculate_filters', [\App\Http\Controllers\FilterController::class, "laptopsCalculateFilters"]);
Route::post('/phones/calculate_filters', [\App\Http\Controllers\FilterController::class, "phonesCalculateFilters"]);
Route::post('/ssds/calculate_filters', [\App\Http\Controllers\FilterController::class, "ssdsCalculateFilters"]);

// ▪▪▪▪  ERRORS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::group(["namespace" => "\App\Http\Controllers", "prefix" => "error"], function () {
	Route::get('/', "ErrorController@noPermission")->name("error.no_permission");
	Route::get('/', "ErrorController@cantCreateNewAd")->name("error.cant_create_new_ad");
});

// ▪▪▪▪  CONTACTS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::get('/contacts', function () { return view("contacts.sections_contacts"); })->name("contacts");
Route::post('/contacts', "\App\Http\Controllers\ContactsSendMessageController")->name("contacts.send_message");
// /contacts_mes_sent  -  криво, но для демки и так сойдёт :)
Route::get('/contacts_mes_sent', function () { return view("contacts.sections_message_is_sent"); })->name("contacts.message_sent");

// ▪▪▪▪  VISITS LIST ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::get('/visits', [\App\Http\Controllers\VisitController::class, "index"])->middleware("\App\Http\Middleware\AllowedIpAccessOnlyMiddleware");

// ▪▪▪▪  MISCELLANEOUS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
Route::get('/lang/{lang}', ["as" => "lang.switch", "uses" => "\App\Http\Controllers\LanguageController@swithLang"]);

Route::get('/deploy', [\App\Http\Controllers\AdminController::class, "deploy"]);
/*if (!config('app.debug')) {
	Route::get('/test', [\App\Http\Controllers\AdminController::class, "test"])->middleware("\App\Http\Middleware\AdminAccessOnlyMiddleware");
}*/

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪  DEBUG and TESTS  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

Route::get('/test', "\App\Http\Controllers\Tests\Test")->middleware("\App\Http\Middleware\AllowedIpAccessOnlyMiddleware");
if (config('app.debug')) {
	Route::get('/test_mail', "\App\Http\Controllers\Tests\TestMail");
	Route::get('/test_charts', "\App\Http\Controllers\Tests\TestCharts");

	// test csv export import
	Route::get('/test_csv', "\App\Http\Controllers\Tests\Test_CSV_ExportImport");
	Route::post('/table_export', "\App\Http\Controllers\Tests\Test_CSV_ExportImport@exportTable");
	Route::post('/table_import', "\App\Http\Controllers\Tests\Test_CSV_ExportImport@importTable");

	// get progress
	Route::get('/test_get_progress', "\App\Http\Controllers\Tests\TestGetProgressOfOperation");
	Route::post('/test_get_progress', "\App\Http\Controllers\Tests\TestGetProgressOfOperation@getProgress");

	Route::get('/test_some_html_problems', "\App\Http\Controllers\Tests\TestSomeHtmlProblems");

	Route::get('/test_are_all_car_photos_available', "\App\Http\Controllers\Tests\TestAreAllCarPhotosAvailable");

	Route::get('/test_paypal', "\App\Http\Controllers\Tests\TestPaypal")->name("paypal.home");
	Route::get('/test_paypal_checkout', "\App\Http\Controllers\Tests\TestPaypal@checkout")->name("paypal.checkout");
	Route::get('/test_paypal_success', "\App\Http\Controllers\Tests\TestPaypal@success")->name("paypal.success");
	Route::get('/test_paypal_cancel', "\App\Http\Controllers\Tests\TestPaypal@cancel")->name("paypal.cancel");
	Route::get('/deploylog', [\App\Http\Controllers\AdminController::class, "deploylog"]);
	Route::get('/debuglog', [\App\Http\Controllers\AdminController::class, "debuglog"])->middleware("\App\Http\Middleware\AllowedIpAccessOnlyMiddleware");

	// для postman
	Route::post('/test_postman', "\App\Http\Controllers\Tests\TestPostman");
	Route::get('/test_ajax', "\App\Http\Controllers\Tests\TestAjax");
//	clear_logs__for_debug();
	// 1-2-3 колоноки и 14 блоков
	Route::get('/test_3columns_14blocks', "\App\Http\Controllers\Tests\Test_3columns_14blocks");

}
