<?php
$colorClass = ["email_picture_bg_blue", "email_picture_bg_gray", "email_picture_bg_pink", "email_picture_bg_emerald"][mt_rand(0, 3)];
?>
<style>
  #csv_files_list {
    background-color: #ffffff;
    color: #808080;
    border: 1px solid #ececec;
    border-radius: 5px;
    padding: 5px;
  }
  #csv_files_list li {
    background-color: #ffffff;
    color: #808080;
    line-height: 1.3;
    font-family: Roboto;
  }
  #csv_files_list li {
    background-color: #ffffff;
    color: #808080;
    line-height: 1.3;
    font-family: Roboto;
  }
  .btn_export_data, .btn_import_data {
    color: #FFFFFF;
    border: 0;
    border-radius: 0;
    transition-duration: 200ms;
    transition-property: color, background;
  }
  .btn_export_data {
    background: linear-gradient(to right, #add29f 0%, #3e8823 99%);
  }
  .btn_import_data {
    background: linear-gradient(to right, #f1da36 0%, #ec721d 99%);
  }
  .btn_export_data:hover, .btn_import_data:hover {
    color: #FFFFFF;
    background: linear-gradient(to right, #ff9ac5 0%, #bd1158 99%);
    border: 0;
    border-radius: 0;
  }
	.oparation_text {
    padding: 1rem 1rem 1rem 1rem;
		background-color: #ffffff;
    color: #1a1d20;
		font-weight: normal;
  }
  .oparation_percents {
    padding: 1rem 1rem 1rem 0rem;
    background-color: #ffffff;
    color: #1a1d20;
    font-weight: bold;
  }
</style>
<form method="POST" class="contacts_send_message_form" enctype="multipart/form-data" id="contacts_send_message_form">
	@csrf
	<div class="container-fluid contacts_container">
		<div class="contacts">
			<div class="row justify-content-center">
				{{-- VERTICAL DECORATION --}}
				<div class="col-12 col-sm-3 email_picture_holder {{$colorClass}}">
					<img src="{{asset('/img/contacts/email.svg')}}" alt="" class="img-fluid">
				</div>
				<div class="col-12 col-sm-9">
					{{-- *** PROGRESS *** --}}
					<div class="row p-4">
						<div class="col-12">
							<span class="oparation_text">НЕ НАЧАТО</span><span class="oparation_percents"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>


