<nav class="btn_filters_container">
	<div class="container">
		<div class="row justify-content-between mt-3 mt-sm-4 align-items-stretch">
			{{-- SHOW FILTERS button --}}
			<div class="col-6 col-sm mb-sm-2 pe-0 pe-sm-1 show_filters_btn_holder">
				<a id="show_filters" class="w-100 btn btn-outline-secondary lh-sm filters_closed no_filters_selected mb-2 mb-sm-1" data-func="show_filters">
					<span closed>{{__("Show filters")}}</span><span showed>{{__("Close filters")}}</span><span selected_filters_cnt></span>
				</a>
			</div>
			{{-- WHAT IS IT button --}}
			<div class="col-12 col-sm-12 col-md mb-sm-2 what_is_it_btn_holder">
				<a id="what_is_it_btn" class="w-100 btn btn-outline-warning lh-sm mb-2 mb-sm-1" type="button"><span class="d-none d-md-inline">{{__("What is it ?")}}</span><span class="d-md-none">{{__("What is this site for?")}}</span></a>
			</div>
			{{-- STATISTICS button --}}
			<div class="col-6 col-sm mb-sm-2 ps-2 statistics_btn_holder">
				<a id="statistics_btn" class="w-100 btn btn-outline-secondary lh-sm mb-2 mb-sm-1" type="button"><span>{{__("Statistics")}}</span></a>
			</div>
			{{-- SETTINGS FOR extended CAR CARD button --}}
			@if($extProductCardSettings && $cardOrListViewMode == "card")
				<div class="d-none d-sm-block ps-2 settings_for_car_card_holder">
					<a id="settings_for_car_card_btn" class="btn lh-sm settings_closed" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('Car card tuning')}}" data-func="show_settings_for_car_card">
						<x-svg_icon iconname="i_settings_for_car_card" width="2.1875rem" height="2.1875rem"/>
						<x-svg_icon iconname="i_settings_for_car_card_on" width="2.1875rem" height="2.1875rem"/>
					</a>
				</div>
			@endif
		</div>
		<!-- ▪▪▪▪▪▪▪▪  modal  WHAT IS IT  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
		<div class="modal fade" id="what_is_it_modal" tabindex="-1" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" style="">
				<div class="modal-content">
					<div class="modal-header bottom_diagonal_cuts "></div>
					<div class="modal-body text-center">
						<h1>{{__("Hello :)")}}</h1>
						<div class="icon d-flex align-items-center justify-content-center">
							<img src="{{asset('/img/homepage/chip_dale_face.png')}}" class="img-fluid chip_dale_face" alt="">
						</div>
						<p class="what_is_it_text">{{__("Site description")}}</p>
						<button type="button" class="btn btn-primary btn_what_is_it_close" data-bs-dismiss="modal">{{__("Close")}}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>