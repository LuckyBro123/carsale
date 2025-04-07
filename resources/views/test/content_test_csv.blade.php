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
					{{-- *********** EXPORT *************** --}}
					<div class="row p-4">
						<div class="col-12">
							<h4 class="pb-4" style="color:var(--bs-gray-600);">Экспорт таблицы
								<i class="fst-italic text-success">cars</i> в файл CSV
							</h4>
						</div>
						{{-- EXPORT button --}}
						<div class="col-12 mt-4 text-center">
							<button type="button" class="btn btn-warning btn_export_data me-3" style="width: 100%;">Выполнить экспорт</button>
						</div>
					</div>
					<hr>
					{{-- *** IMPORT *** --}}
					<div class="row p-4">
						<div class="col-12">
							<h4 class="pb-4" style="color:var(--bs-gray-600);">Импорт данных из CSV файла в таблицу
								<i class="fst-italic text-success">cars</i>
							</h4>
						</div>
						{{-- a list of the available csv-files for import                --}}
						<div class="col-12">
							<ul id="csv_files_list">
								@foreach($csvFiles as $file)
									@php
										$checked = $loop->iteration == 1 ? "checked" : "";
									@endphp
									<div class="form-check">
										<input class="form-check-input csv_file_name" type="radio" name="csv_filename" id="csv_file_name{{$loop->iteration}}" {{$checked}} filename="{{$file}}">
										<label class="form-check-label" for="csv_file_name{{$loop->iteration}}">
											{{$file}}
										</label>
									</div>
								@endforeach
							</ul>
						</div>
						{{-- IMPORT button --}}
						<div class="col-12 mt-4 text-center">
							<button type="button" class="btn btn-warning btn_import_data me-3" style="width: 100%;">Выполнить импорт</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>


