{{--<h3>message -
	<span>{{$data["message"]}}</span>
</h3>
<h3>price -
	<span>{{$price}}</span>
</h3>
<style>
  .tabs {
    font-size: 0;
    max-width: 570px;
    margin-left: auto;
    margin-right: auto
  }
  .tabs > input[type="radio"] {
    display: none
  }
  .tabs > div {
    font-family: system-ui;
    display: none;
    border: 1px solid #e0e0e0;
    padding: 10px 15px;
    font-size: 16px
  }
  #tab-btn-1:checked ~ #content-1, #tab-btn-2:checked ~ #content-2, #tab-btn-3:checked ~ #content-3, #tab-btn-4:checked ~ #content-4 {
    display: block
  }
  .tabs > label {
    font-family: system-ui;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: #f5f5f5;
    border: 1px solid #e0e0e0;
    padding: 2px 20px;
    font-size: 16px;
    line-height: 1.5;
    transition: color .15s ease-in-out, background-color .15s ease-in-out;
    cursor: pointer;
    position: relative;
    top: 1px
  }
  .tabs > label:not(:first-of-type) {
    border-left: none
  }
  .tabs > input[type="radio"]:checked + label {
    font-weight: 600;
    background-color: #fff;
    border-bottom: 1px solid #fff
  }
  #flag-icon-css-ee, #flag-icon-css-lv, #flag-icon-css-ru, #flag-icon-css-us {
    width: 20px;
    position: relative;
    top: 2px;
    left: -3px
  }
</style>
<div class="tabs">
	<input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
	<label for="tab-btn-1">
		<svg xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-lv" viewBox="0 0 640 480">
			<g fill-rule="evenodd">
				<path fill="#fff" d="M0 0h640v480H0z"/>
				<path fill="#981e32" d="M0 0h640v192H0zm0 288h640v192H0z"/>
			</g>
		</svg>
		LV
	</label>
	<input type="radio" name="tab-btn" id="tab-btn-2" value="">
	<label for="tab-btn-2">
		<svg xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-us" viewBox="0 0 640 480">
			<g fill-rule="evenodd">
				<g stroke-width="1pt">
					<path fill="#bd3d44" d="M0 0h972.8v39.4H0zm0 78.8h972.8v39.4H0zm0 78.7h972.8V197H0zm0 78.8h972.8v39.4H0zm0 78.8h972.8v39.4H0zm0 78.7h972.8v39.4H0zm0 78.8h972.8V512H0z" transform="scale(.9375)"/>
					<path fill="#fff" d="M0 39.4h972.8v39.4H0zm0 78.8h972.8v39.3H0zm0 78.7h972.8v39.4H0zm0 78.8h972.8v39.4H0zm0 78.8h972.8v39.4H0zm0 78.7h972.8v39.4H0z" transform="scale(.9375)"/>
				</g>
				<path fill="#192f5d" d="M0 0h389.1v275.7H0z" transform="scale(.9375)"/>
				<path fill="#fff" d="M32.4 11.8L36 22.7h11.4l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.3-6.7H29zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7h11.4zm64.8 0l3.6 10.9H177l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.3-6.7h11.5zm64.9 0l3.5 10.9H242l-9.3 6.7 3.6 11-9.3-6.8-9.3 6.7 3.6-10.9-9.3-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.2-6.7h11.4zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.6 11-9.3-6.8-9.3 6.7 3.6-10.9-9.3-6.7h11.5zM64.9 39.4l3.5 10.9h11.5L70.6 57 74 67.9l-9-6.7-9.3 6.7L59 57l-9-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.3 6.7 3.6 10.9-9.3-6.7-9.3 6.7L124 57l-9.3-6.7h11.5zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 10.9-9.2-6.7-9.3 6.7 3.5-10.9-9.2-6.7H191zm64.8 0l3.6 10.9h11.4l-9.3 6.7 3.6 10.9-9.3-6.7-9.2 6.7 3.5-10.9-9.3-6.7H256zm64.9 0l3.5 10.9h11.5L330 57l3.5 10.9-9.2-6.7-9.3 6.7 3.5-10.9-9.2-6.7h11.4zM32.4 66.9L36 78h11.4l-9.2 6.7 3.5 10.9-9.3-6.8-9.2 6.8 3.5-11-9.3-6.7H29zm64.9 0l3.5 11h11.5l-9.3 6.7 3.5 10.9-9.2-6.8-9.3 6.8 3.5-11-9.2-6.7h11.4zm64.8 0l3.6 11H177l-9.2 6.7 3.5 10.9-9.3-6.8-9.2 6.8 3.5-11-9.3-6.7h11.5zm64.9 0l3.5 11H242l-9.3 6.7 3.6 10.9-9.3-6.8-9.3 6.8 3.6-11-9.3-6.7h11.4zm64.8 0l3.6 11h11.4l-9.2 6.7 3.5 10.9-9.3-6.8-9.2 6.8 3.5-11-9.2-6.7h11.4zm64.9 0l3.5 11h11.5l-9.3 6.7 3.6 10.9-9.3-6.8-9.3 6.8 3.6-11-9.3-6.7h11.5zM64.9 94.5l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.3 6.7 3.6 11-9.3-6.8-9.3 6.7 3.6-10.9-9.3-6.7h11.5zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7H191zm64.8 0l3.6 10.9h11.4l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.3-6.7H256zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7h11.4zM32.4 122.1L36 133h11.4l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.3-6.7H29zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 10.9-9.2-6.7-9.3 6.7 3.5-10.9-9.2-6.7h11.4zm64.8 0l3.6 10.9H177l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.3-6.7h11.5zm64.9 0l3.5 10.9H242l-9.3 6.7 3.6 11-9.3-6.8-9.3 6.7 3.6-10.9-9.3-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.2-6.7h11.4zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.6 11-9.3-6.8-9.3 6.7 3.6-10.9-9.3-6.7h11.5zM64.9 149.7l3.5 10.9h11.5l-9.3 6.7 3.5 10.9-9.2-6.8-9.3 6.8 3.5-11-9.2-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.3 6.7 3.6 10.9-9.3-6.8-9.3 6.8 3.6-11-9.3-6.7h11.5zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 10.9-9.2-6.8-9.3 6.8 3.5-11-9.2-6.7H191zm64.8 0l3.6 10.9h11.4l-9.2 6.7 3.5 10.9-9.3-6.8-9.2 6.8 3.5-11-9.3-6.7H256zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 10.9-9.2-6.8-9.3 6.8 3.5-11-9.2-6.7h11.4zM32.4 177.2l3.6 11h11.4l-9.2 6.7 3.5 10.8-9.3-6.7-9.2 6.7 3.5-10.9-9.3-6.7H29zm64.9 0l3.5 11h11.5l-9.3 6.7 3.6 10.8-9.3-6.7-9.3 6.7 3.6-10.9-9.3-6.7h11.4zm64.8 0l3.6 11H177l-9.2 6.7 3.5 10.8-9.3-6.7-9.2 6.7 3.5-10.9-9.3-6.7h11.5zm64.9 0l3.5 11H242l-9.3 6.7 3.6 10.8-9.3-6.7-9.3 6.7 3.6-10.9-9.3-6.7h11.4zm64.8 0l3.6 11h11.4l-9.2 6.7 3.5 10.8-9.3-6.7-9.2 6.7 3.5-10.9-9.2-6.7h11.4zm64.9 0l3.5 11h11.5l-9.3 6.7 3.6 10.8-9.3-6.7-9.3 6.7 3.6-10.9-9.3-6.7h11.5zM64.9 204.8l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.3 6.7 3.6 11-9.3-6.8-9.3 6.7 3.6-10.9-9.3-6.7h11.5zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7H191zm64.8 0l3.6 10.9h11.4l-9.2 6.7 3.5 11-9.3-6.8-9.2 6.7 3.5-10.9-9.3-6.7H256zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.5 11-9.2-6.8-9.3 6.7 3.5-10.9-9.2-6.7h11.4zM32.4 232.4l3.6 10.9h11.4l-9.2 6.7 3.5 10.9-9.3-6.7-9.2 6.7 3.5-11-9.3-6.7H29zm64.9 0l3.5 10.9h11.5L103 250l3.6 10.9-9.3-6.7-9.3 6.7 3.6-11-9.3-6.7h11.4zm64.8 0l3.6 10.9H177l-9 6.7 3.5 10.9-9.3-6.7-9.2 6.7 3.5-11-9.3-6.7h11.5zm64.9 0l3.5 10.9H242l-9.3 6.7 3.6 10.9-9.3-6.7-9.3 6.7 3.6-11-9.3-6.7h11.4zm64.8 0l3.6 10.9h11.4l-9.2 6.7 3.5 10.9-9.3-6.7-9.2 6.7 3.5-11-9.2-6.7h11.4zm64.9 0l3.5 10.9h11.5l-9.3 6.7 3.6 10.9-9.3-6.7-9.3 6.7 3.6-11-9.3-6.7h11.5z" transform="scale(.9375)"/>
			</g>
		</svg>
		ENG
	</label>
	<input type="radio" name="tab-btn" id="tab-btn-3" value="">
	<label for="tab-btn-3">
		<svg xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-ru" viewBox="0 0 640 480">
			<g fill-rule="evenodd" stroke-width="1pt">
				<path fill="#fff" d="M0 0h640v480H0z"/>
				<path fill="#0039a6" d="M0 160h640v320H0z"/>
				<path fill="#d52b1e" d="M0 320h640v160H0z"/>
			</g>
		</svg>
		RU
	</label>
	<input type="radio" name="tab-btn" id="tab-btn-4" value="">
	<label for="tab-btn-4">
		<svg xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-ee" viewBox="0 0 640 480">
			<g fill-rule="evenodd" stroke-width="1pt">
				<rect width="640" height="477.9" rx="0" ry="0"/>
				<rect width="640" height="159.3" y="320.7" fill="#fff" rx="0" ry="0"/>
				<path fill="#1291ff" d="M0 0h640v159.3H0z"/>
			</g>
		</svg>
		EE
	</label>
	<div id="content-1">
		<br>
		<br>Labdien (lv),<br> Paldies par Jūsu pasūtījumu.<br> Jūsu apmaksa ir saņemta.<br><br> Prece: {|foreach from=$basketsArray item="b"|}<br> {|$b.name|} - {|$b.count|}<br> {|/foreach|}<br><br> Piegādes laiks 4-7 darba dienas.<br> Paziņosim, kad prece tiks nosūtīta, lūdzam pārbaudīt piegādes adresi un telefona numuru.<br> {|$clientaddress|} ; {|$clientphone|} ; {|$clientemail|}<br><br> Paldies par pirkumu,<br><br>
	</div>
	<div id="content-2">
		<br>
		<br>Labdien (en),<br> Paldies par Jūsu pasūtījumu.<br> Jūsu apmaksa ir saņemta.<br><br> Prece: {|foreach from=$basketsArray item="b"|}<br> {|$b.name|} - {|$b.count|}<br> {|/foreach|}<br><br> Piegādes laiks 4-7 darba dienas.<br> Paziņosim, kad prece tiks nosūtīta, lūdzam pārbaudīt piegādes adresi un telefona numuru.<br> {|$clientaddress|} ; {|$clientphone|} ; {|$clientemail|}<br><br> Paldies par pirkumu,<br><br>
	</div>
	<div id="content-3">
		<br>
		<br>Labdien (ru),<br> Paldies par Jūsu pasūtījumu.<br> Jūsu apmaksa ir saņemta.<br><br> Prece: {|foreach from=$basketsArray item="b"|}<br> {|$b.name|} - {|$b.count|}<br> {|/foreach|}<br><br> Piegādes laiks 4-7 darba dienas.<br> Paziņosim, kad prece tiks nosūtīta, lūdzam pārbaudīt piegādes adresi un telefona numuru.<br> {|$clientaddress|} ; {|$clientphone|} ; {|$clientemail|}<br><br> Paldies par pirkumu,<br><br>
	</div>
	<div id="content-4">
		<br>
		<br>Labdien (ee),<br> Paldies par Jūsu pasūtījumu.<br> Jūsu apmaksa ir saņemta.<br><br> Prece: {|foreach from=$basketsArray item="b"|}<br> {|$b.name|} - {|$b.count|}<br> {|/foreach|}<br><br> Piegādes laiks 4-7 darba dienas.<br> Paziņosim, kad prece tiks nosūtīta, lūdzam pārbaudīt piegādes adresi un telefona numuru.<br> {|$clientaddress|} ; {|$clientphone|} ; {|$clientemail|}<br><br> Paldies par pirkumu,<br><br>
	</div>
</div>--}}
<p></p>
<p> ----------------- </p>
<h2>--- ТЕСТОВОЕ ПИСЬМО ---</h2>
<p> вот текст сообщения:</p>
<p>price -> {{$price}}</p>
<p>{{$data["message"]}}</p>
<p> ----------------- </p>
<p></p>
