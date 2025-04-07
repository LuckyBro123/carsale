<div class="container-fluid px-3 text-bg-dark">
	<div class="row justify-content-center">
		<div class="col-auto switch_language_wrapper">
			<div class="current_lang_div">
				<span>{{__("Current language:")}}</span>
				<span>{{Config::get('languages')[App::getLocale()]}}</span>
			</div>
			<div class="another_lang_div">
				<span class="select_lang">{{__("Select language:")}}</span>
				@foreach (Config::get('languages') as $lang => $language)
					@if ($lang != App::getLocale())
						<a href="{{ route('lang.switch', $lang) }}" class="another_language_name"> {{$language}}</a>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
@if(is_admin())
	<div style="line-height: 1rem; background-color: #051373; color: #ffffff; font-size: 0.9rem;text-align:center;">admin</div>
@endif

