<?php
$divAttribs = 'class="modal fade error_modal"';
$id = $id ?? "error_modal";
?>
<div {!! $divAttribs !!} id="{{$id}}" tabindex="-1" aria-modal="true" aria-labelledby="">
	<div class="modal-dialog modal-dialog-centered" style="">
		<div class="modal-content">
			<div class="modal-body text-center">
				<span class="bg-danger text-white rounded-circle  top-circle" style=""><i>&#x2715;</i></span>
				<h1>{{__("Error")}}</h1>
				<p class="error_modal_text">{{__($message)}}</p>
				<button type="button" class="btn btn-primary btn_error_modal_close" data-bs-dismiss="modal">{{__("Close")}}</button>
			</div>
		</div>
	</div>
	<i class="error_message_no_photos d-none">{{__("There are no photos. Upload photos please")}}</i>
</div>

@if($show == "true")
	<script>
    $(function () {
      $('#{{$id}}').modal('show');
    });
	</script>
@endif


