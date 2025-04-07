@php
	$openedFilterGroups = config('app.debug') ? [0,1,2] : [];
@endphp{{--	           FILTERS SECTION        --}}
<script type="text/javascript">
	<?php
	if ($isAnyFiltersSelected) echo '$myApp.isAnyFiltersSelected = true;';
	else echo '$myApp.isAnyFiltersSelected = false;';
	?>
  function pluralProducts(number) {
    var rus = <?php echo app()->getLocale() == "ru" ? "true" : "false" ?>;
    if (rus && number > 20) number %= 10;
    switch (number) {
      case 1 :
        return "{{$pluralWords[0]}}";
      case 2 :
      case 3 :
      case 4 :
        return "{{$pluralWords[1]}}";
      default:
        return "{{$pluralWords[2]}}";
    }
  }
</script>
<x-buttons_filters_whatIsIt_statistics :extProductCardSettings="$extProductCardSettings" cardOrListViewMode="{{$cardOrListViewMode}}"/>{{----}}
<!--▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀
      SETTINGS FOR EXTENDED CAR CARD
▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄-->
@if($extProductCardSettings)
	<section id="settings_for_ext_car_card_global_container" class="container-fluid bg-light collapse">
		<div class="container-fluid bg-light filters_fullscreen_block " id="filters_container">
			<div class="row g-0 filters_content flex-nowrap justify-content-center">
				<div id="editor_for_settings_layout" class="col">
					<h5 class="text-center">{{__("Ext card settings message")}}</h5>
					<br>
					<h6 class="pb-2 text-decoration-underline">{{__("What to show ?")}}</h6>
					<form id="checkboxes_ext_car_card_settings">
						@php
							$colors=["blue","orange","green","pink","yellow","purple","green2","red","cyan"];
						$mileageChecked = in_array("mileage",$extProductCardSettings) ? "checked" : "";
						$gearboxChecked = in_array("gearbox",$extProductCardSettings) ? "checked" : "";
						$engineCapacityChecked = in_array("engine_capacity",$extProductCardSettings) ? "checked" : "";
						$enginePowerChecked = in_array("engine_power",$extProductCardSettings) ? "checked" : "";
						$fuelConsChecked = in_array("fuel_consumption",$extProductCardSettings) ? "checked" : "";
						$wheelbaseChecked = in_array("wheelbase",$extProductCardSettings) ? "checked" : "";
						$numberDoorsChecked = in_array("number_doors",$extProductCardSettings) ? "checked" : "";
						$wasInAccidentChecked = in_array("was_in_accident",$extProductCardSettings) ? "checked" : "";
						$mileageLabel = __("Mileage");
						$gearboxLabel = __("Gearbox");
						$engineCapacityLabel = __("Engine capacity");
						$enginePowerLabel = __("Engine power");
						$fuelConsLabel = __("Mixed fuel cons");
						$wheelbaseLabel = __("Whellbase");
						$numberDoorsLabel = __("Number of doors");
						$wasInAccidentLabel = __("Was in accident");
						@endphp
						<x-checkbox_ON_OFF name="mileage" :color="$colors[0]" text="{{$mileageLabel}}" checked='{{$mileageChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="gearbox" :color="$colors[0]" text="{{$gearboxLabel}}" checked='{{$gearboxChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="engine_capacity" :color="$colors[0]" text="{{$engineCapacityLabel}}" checked='{{$engineCapacityChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="engine_power" :color="$colors[0]" text="{{$enginePowerLabel}}" checked='{{$enginePowerChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="fuel_consumption" :color="$colors[0]" text="{{$fuelConsLabel}}" checked='{{$fuelConsChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="wheelbase" :color="$colors[0]" text="{{$wheelbaseLabel}}" checked='{{$wheelbaseChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="number_doors" :color="$colors[0]" text="{{$numberDoorsLabel}}" checked='{{$numberDoorsChecked}}' classes="ext_car_card_setting_checkbox"/>
						<x-checkbox_ON_OFF name="was_in_accident" :color="$colors[0]" text="{{$wasInAccidentLabel}}" checked='{{$wasInAccidentChecked}}' classes="ext_car_card_setting_checkbox"/>
						{{--					<input type="checkbox" checked data-toggle="toggle" data-size="xl">--}}
					</form>
					<div class="filters_header">
						<div class="d-flex justify-content-center px-3 pb-3 p-sm-3 ">
							<hr>
							<button type="button" class="btn btn_color__var_main_menu_bg btn-sm mx-2 px-3   text-uppercase " data-func="all_on_settings_for_ext_car_card">{{__("All")}}</button>
							<button type="button" class="btn btn_color__var_main_menu_bg btn-sm mx-2 px-3 text-uppercase " data-func="all_off_settings_for_ext_car_card">{{__("Nothing")}}</button>
							<button type="button" class="btn btn_color__var_main_menu_bg btn-sm  mx-2 px-3 text-uppercase " data-func="reset_to_default_settings_for_ext_car_card">{{__("Default")}}</button>
							<button type="button" class="btn btn_color__gray_green btn-sm p mx-2 px-3 text-uppercase" data-func="apply_new_settings_for_ext_car_card">{{__("Apply")}}</button>
						</div>
					</div>
				</div>
				<div id="layout_ext_car_card__holder" class="col px-0 mt-0 ">{{-- layout_ext_car_card__holder--}}
					@php
						for ($i = 0; $i < 5; $i++) {
				$carPhotos[] = isset($car->photos[$i]) ? asset(Storage::disk("public")->url("cars_photos/small_duplicates/" . pathinfo($car->photos[$i]->filename,PATHINFO_FILENAME) . ".webp")) : "";
						$URLforCard = route("car.view", [$car->id]);
						$carPrice = number_format($car->price, 0, "", " ") . " $";
	if (app()->getLocale() == "ru") $carMileage = number_format($car->mileage, 0, "", " ") . " " . __("km");
	else $carMileage = number_format(round($car->mileage / 1.609), 0, "", " ") . " " . __("m");
	$wasInAccident = $car->was_in_accident ? "Yes" : "No";
						$isFavoriteIconChecked = in_array($car->id, $favoritesElems) ? " checked " : "";
						$isCompareIconChecked = in_array($car->id, $compareElems) ? " checked " : "";
	
		}        @endphp
					<div id="layout_ext_car_card" class="card car_card extended_car_card" card_id="">
						<a class="card_url position-relative" href="{{$URLforCard}}">
							<div class="ext_card_photo_holder">
								<img src="{{$carPhotos[0]}}" class="ext_car_card_photo" alt="car photo">
							</div>
							{{-- эти микрофотки будут только в макете в настройках--}}
							<div class="d-none ext_car_card_microphoto_set for_layout justify-content-between mt-2 mb-2 mx-2">
								@foreach($carPhotos as $photo)
									@if($photo == "")
										<div class="ext_card_empty_img"></div>
									@else
										<img src="{{$photo}}" class="ext_car_card_microphoto" alt="car photo">
									@endif
								@endforeach
							</div>
							{{-- эти заглушки микрофоток будут в клонированных карточках--}}
							<div class="ext_car_card_microphoto_set d-flex not_for_layout justify-content-between mt-2 mb-2 mx-2">
								@for ($i = 0; $i < 5; $i++)
									<div class="ext_card_empty_img"></div>
								@endfor
							</div>
							<div class="card-body pt-1 ">
								<h6 class="car_name bg-black text-white text-center">{{$car->fullName}}</h6>
								<h6 class="car_year_price">
									<span>{{$car->production_year}}</span><span>{{$carPrice}}</span>
								</h6>
								<p class="car_parameters" type="mileage" style="{{$mileageChecked ? "" : "height: 0px;"}}">
									<span>{{__("Mileage")}}</span><span>{{$carMileage}}</span>
								</p>
								<p class="car_parameters" type="gearbox" style="{{$gearboxChecked ? "" : "height: 0px;"}}">
									<span>{{__("Gearbox")}}</span><span>{{__($car->gearbox->name)}}</span>
								</p>
								<p class="car_parameters" type="engine_capacity" style="{{$engineCapacityChecked ? "" : "height: 0px"}}">
									<span>{{__("Engine capacity")}}</span><span>{{$car->engine_capacity}}</span>
								</p>
								<p class="car_parameters" type="engine_power" style="{{$enginePowerChecked ? "" : "height: 0px"}}">
									<span>{{__("Engine power")}}</span><span>{{$car->engine_power}}</span>
								</p>
								<p class="car_parameters" type="fuel_consumption" style="{{$fuelConsChecked ? "" : "height: 0px"}}">
									<span>{{__("Fuel consumption")}}</span><span>{{$car->fuel_consumption}}</span>
								</p>
								<p class="car_parameters" type="wheelbase" style="{{$wheelbaseChecked ? "" : "height: 0px"}}">
									<span>{{__("Wheelbase")}}</span><span>{{$car->wheelbase}}</span>
								</p>
								<p class="car_parameters" type="number_doors" style="{{$numberDoorsChecked ? "" : "height: 0px"}}">
									<span>{{__("Number of doors")}}</span><span>{{$car->number_doors}}</span>
								</p>
								<p class="car_parameters" type="was_in_accident" style="{{$wasInAccidentChecked ? "" : "height: 0px"}}">
									<span>{{__("Was in accident")}}</span><span>{{__($wasInAccident)}}</span>
								</p>
							</div>
							<div class="ext_card_footer">
								<a href="" class="btn btn-outline-success btn-sm" style="min-width: 6rem;line-height: 1.2;">{{__("Details")}}</a>
								<label class="car_card_icons icon_compare">
									<input {{$isCompareIconChecked}} type="checkbox" class="input_compare" carid="{{$car->id}}">
									<div class="icons">
										<x-svg_icon iconname="i_compare" width="1.15rem" height="1.15rem"/>
										<x-svg_icon iconname="i_compare_on" width="1.15rem" height="1.15rem"/>
									</div>
								</label>
								<label class="car_card_icons icon_favorite">
									<input {{$isFavoriteIconChecked}} type="checkbox" class="input_favorite" carid="{{$car->id}}">
									<div class="icons">
										<x-svg_icon iconname="i_favorite" width="1.15rem" height="1.15rem"/>
										<x-svg_icon iconname="i_favorite_on" width="1.15rem" height="1.15rem"/>
									</div>
								</label>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section> {{--END OF  SETTINGS FOR EXTENDED CAR CARD--}}
@endif
{{--	        FILTERS SECTION START	           --}}
<section class="container-fluid bg-light collapse" id="filters_global_container">
	<div class="modal-content container-md bg-light filters_fullscreen_block " id="filters_container">
		<div class="filters_header">
			<div class="d-flex d-sm-none justify-content-between align-items-center pt-3 px-4 pb-3">
				<div class="d-flex align-items-center text-secondary" found_X_objects__inscription>
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<button type="button" class="btn-close opacity-100 self" data-func="close_fullscreen_filters" aria-label="{{__("Close")}}"></button>
			</div>
			<div class="d-flex justify-content-between px-3 pb-3 p-sm-3 ">
				<div class="d-none d-sm-flex justify-content-start align-items-center text-secondary" found_X_objects__inscription>
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<div class="d-flex justify-content-between w-100 w_sm_auto">
					<?php
					$class_d_none_clear_all_filters = $isAnyFiltersSelected ? "" : " d-none ";
					?>
					<button type="button" class="btn btn-success btn-sm px-2 px-sm-3 ms-1 me-2 me-sm-3" data-func="apply_filters">{{__("APPLY FILTERS")}}</button>
					<button type="button" class="btn btn-danger btn-sm px-2 px-sm-3 me-1 ms-sm-3 {{$class_d_none_clear_all_filters}}" data-func="clear_all_filters">{{__("CLEAR ALL FILTERS")}}</button>
				</div>
			</div>
		</div>
		<div class="row modal-body g-0 filters_content">
			<div class="col px-0 mt-0">
				{{--	***********************************************************	--}}
				{{--	***********************************************************	--}}
				<form class="needs-validation" novalidate="">
					<div class="accordion" id="filters_accordion"><!-- accordion-item -->
						{{-- ······················································· --}}
						@foreach ($filters as $filterGroup)
							{{--  --}}
								<?php
								if (isset($filterGroup["belongs_to"])) $params = " dependent "; else $params = " ";

								//								если нету видимых фильтров внутри, то вообще отключить видимость у группы фильтров
								$class__accordion_item__d_none = "";
								if (isset($filterGroup["is_hidden"])) {
									$noVisibleFound = true;
									$class__accordion_item__d_none = "";
									foreach ($filterGroup["is_hidden"] as $item)
										if (!$item) {
											$noVisibleFound = false;
											break;
										}
									if ($noVisibleFound) $class__accordion_item__d_none = " d-none ";
								} ?>
							@if ($filterGroup["type"] == FILTER_RANGE)
								{{-- Diapason --}}
									<?php
									$f_type = FILTER_RANGE;
									$f_title = $filterGroup["name"];
									$f_code = $filterGroup["codes"][0];
									$params .= " f_type='$f_type' f_title='$f_title' code='$f_code'";
									$totalMin = $filterGroup["totalMin"];
									$totalMax = $filterGroup["totalMax"];
									$min = ($filterGroup["values"][0] <= $totalMin) ? $totalMin : $filterGroup["values"][0];
									$max = ($filterGroup["values"][1] >= $totalMax) ? $totalMax : $filterGroup["values"][1];
									$btnClearFilters__class_d_none = ($totalMin == $min && $totalMax == $max) ? "d-none" : "";
									$checkedFilterCount = 1;
									?>
							@elseif ($filterGroup["type"] == FILTER_MINI_RANGE)
								{{-- Mini Diapason --}}
									<?php
									$f_type = FILTER_MINI_RANGE;
									$f_title = $filterGroup["name"];
									$f_code = $filterGroup["codes"][0];
									$params .= " f_type='$f_type' f_title='$f_title' code='$f_code'";
									$checkedFilterCount = array_count_values($filterGroup["checkedStatuses"])[1] ?? "";
									if ($checkedFilterCount) {
										$btnClearFilters__class_d_none = "";
									} else {
										$btnClearFilters__class_d_none = "d-none";
										$checkedFilterCount = "";
									}
									?>
							@else
								@php
									$f_type = $filterGroup["type"];
									$f_title = $filterGroup["name"];
									$params.= " f_type='$f_type' f_title='$f_title'";
									$checkedFilterCount = array_count_values($filterGroup["checkedStatuses"])[1] ?? "";
									if ($checkedFilterCount) {
									$btnClearFilters__class_d_none = "";
									} else {
									$btnClearFilters__class_d_none = "d-none";
									$checkedFilterCount = "";
									}
								@endphp
							@endif
							<div class="accordion-item {{$class__accordion_item__d_none}}" <?php echo $params ?>>
								<!-- accordion-item -->
								@php
									// for debugging. Some filter groups are open
									$collapsedClass = (in_array($loop->index,$openedFilterGroups))  ? "" : " collapsed ";
									$areaExpanded = ($collapsedClass)  ? "false" : "true";
									$showClass = ($collapsedClass)  ? "" : " show ";
									$collapsId = "filters_accordion_collapse_" . ($loop->index + 1);
									$collapsTitle = $filterGroup["titleOnSite"];
									$accordionHeaderId = "filters_accordion_header_" . ($loop->index+1);
								@endphp
								<h2 class="accordion-header" id="{{$accordionHeaderId}}" {{--id="filters_accordion__header1"--}}>
									<button class="accordion-button {{$collapsedClass}}" type="button" data-bs-toggle="collapse" data-bs-target="#{{$collapsId}}" aria-expanded="{{$areaExpanded}}" aria-controls="{{$collapsId}}">{{__($collapsTitle)}}
									</button>
									<a type="button" class="btn btn_clear_filters {{$btnClearFilters__class_d_none}}" data-func="clear_filters">
										<span>{{$checkedFilterCount}}</span>
										<x-svg_icon iconname="i_close_circle_filled" width="1.15rem" height="1.15rem"/>
									</a>
								</h2>
								<div id="{{$collapsId}}" class="accordion-collapse collapse {{$showClass}}" aria-labelledby="{{$accordionHeaderId}}">
									<div class="accordion-body">
										@if ($filterGroup["type"] == FILTER_RANGE)
											{{--Diapason--}}
												<?php
												$class__d_none = ($filterGroup["is_hidden"][0] ?? false) ? " d-none " : "";
												$belongs_to = ($filterGroup["belongs_to"][0] ?? "") ? ' belongs_to="inputCheckbox' . $filterGroup["belongs_to"][0] . '" ' : "";
												$code = $filterGroup["codes"][0];
												?>
											<div class="filter_diapason_wrapper {{$class__d_none}}" code="{{$code}}" <?php echo $belongs_to; ?>>
												<span>{{__("From")}}</span>
												<input type="number" id="input_min_{{$code}}" name="min_{{$filterGroup["name"]}}" value="{{$min}}" {{--applied_value="{{$min}}"--}} placeholder="{{$totalMin}}">
												<span>{{__("to")}}</span>
												<input type="number" id="input_max_{{$code}}" name="max_{{$filterGroup["name"]}}" value="{{$max}}" {{--applied_value="{{$max}}"--}} placeholder="{{$totalMax}}">
												<span class="btn btn-secondary apply_diapason_filter" data-func="apply_diapason_filter">{{__("OK")}}</span>
											</div>
											<div class="range-slider">
												<input id="filter-range-slider_{{$code}}" type="text" value="">
											</div>
										@else
												<?php /* это для разделения зависимых фильтров по полосам с разными цветами, в соответствии с chief filter */
												if (isset($filterGroup["belongs_to"])) {
													$tag_ul_open = "<ul class='depended_filters_list'>";
													$tag_ul_close = "</ul>";
//													$tag_li_open = "<li>";
													$tag_li_close = "</li>";
												} else $tag_ul_open = $tag_ul_close = $tag_li_close = "";
												$prevChiefCode = "";
												echo $tag_ul_open;
												$number_of_depended_elements_string = 0;
												?>
											@foreach ($filterGroup["values"] as $index => $value)
													<?php
													// это для разделения зависимых фильтров по полосам с разными цветами, в соответствии с chief filter
													$chiefCode = $filterGroup["belongs_to"][$index] ?? "";
													if ($chiefCode && $prevChiefCode && $chiefCode != $prevChiefCode) echo $tag_li_close;
													if ($chiefCode && $chiefCode != $prevChiefCode) {
														$li_class_d_none = "d-none";
														foreach ($filters as $tmpFilterGroup) {
															$index22 = array_search($chiefCode, $tmpFilterGroup["codes"]);
															if ($index22 === false) continue;
															if ($tmpFilterGroup["checkedStatuses"][$index22]) $li_class_d_none = "";
															break;
														}
														if (!$li_class_d_none) $number_of_depended_elements_string++;
														if ($number_of_depended_elements_string % 2 == 0 && !$li_class_d_none) $li_class_d_none = " depended_even ";
														echo "<li class='$li_class_d_none' belongs_to='$chiefCode'>";
													}
													// ------------------------------------------------------------
													$classes__filter_color = " d-none "; $colorValue = "";
													switch ($filterGroup["type"]) {
														case FILTER_RELATIONSHIP :
															$value = $filterGroup["binded_table_values"][$index];
															break;
														case FILTER_COLOR :
															$classes__filter_color = "";
															[$value, $colorValue] = explode("--", $filterGroup["binded_table_values"][$index]);
															if ($colorValue == "#FFFFFF") $classes__filter_color = " filter_color_white "; else $classes__filter_color = "filter_color";
															break;
														case FILTER_YESNO :
															$value = ($value == 1) ? "Yes" : "No";
															break;
														default:
															break;
													}
													$code = $filterGroup["codes"][$loop->index];
													$inputCheckboxId = "input_checkbox" . $code;
													$class__d_none = "";
													$belongs_to = ($filterGroup["belongs_to"][$loop->index] ?? "") ? ' belongs_to="input_checkbox' . $filterGroup["belongs_to"][$loop->index] . '" ' : "";
													$amount = $filterGroup["amounts"][$loop->index];
													$checked = $filterGroup["checkedStatuses"][$loop->index] ? " checked" : "";
													$spanId = "f_" . $filterGroup["name"] . ($loop->index + 1);
													?>
												{{--        filter BTN     <label class="btn_checkbox btn_checkbox_filter">    --}}
												<label class="btn_checkbox btn_checkbox_filter {{$class__d_none}}" code="{{$code}}" <?php echo $belongs_to; ?>>
													<input type="checkbox" class="input_checkbox_filter" id={{$inputCheckboxId}} {{$checked}} code="{{$code}}">
													<div class="btn_checkbox_text">
														@if(!Str::contains($classes__filter_color, 'd-none'))
															<color class="{{$classes__filter_color}}" style="background-color: {{$colorValue}};"></color>
														@endif
														<span>{{__($value)}}</span><span id="span2{{$code}}">{{$amount}}</span>
													</div>
												</label>
												
												{{--                                                                   --}}
													<?php
													$prevChiefCode = $filterGroup["belongs_to"][$index] ?? "";
													?>
											@endforeach
												<?php
												echo $tag_ul_close;
												?>
										@endif
									</div>
								</div>
							</div>
						@endforeach
						{{-- ····················································· --}}
					</div>
				</form>
				{{--	***********************************************************	--}}
				{{--	***********************************************************	--}}
			</div>
		</div>
		<div class="filters_header">
			<div class="d-flex justify-content-between px-3 pb-3 p-sm-3 ">
				<div class="justify-content-start align-items-center text-secondary d-none d-sm-flex" found_X_objects__inscription>
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<div class="d-flex justify-content-between w-100 w_sm_auto">
					<button type="button" class="btn btn-success btn-sm px-2 px-sm-3 ms-1 me-2 me-sm-3" data-func="apply_filters">{{__("APPLY FILTERS")}}</button>
					<button type="button" class="btn btn-danger btn-sm px-2 px-sm-3 me-1 ms-sm-3 {{$class_d_none_clear_all_filters}}" data-func="clear_all_filters">{{__("CLEAR ALL FILTERS")}}</button>
				</div>
			</div>
			<div class="d-flex d-sm-none justify-content-between align-items-center pt-3 px-4 pb-3">
				<div class="d-flex align-items-center text-secondary" found_X_objects__inscription>
					<span>{{__("Found")}}</span>
					<span class="total_products_found">{{$totalProductsFound}}</span>
					<plural_products>{{plural_products($totalProductsFound, $pluralWords)}}</plural_products>
				</div>
				<button type="button" class="btn-close opacity-100 self" data-func="close_fullscreen_filters" aria-label="{{__("Close")}}"></button>
			</div>
		</div>
	</div>
</section>{{--	        FILTERS SECTION END	           --}}
