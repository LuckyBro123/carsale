<script type="text/javascript">
	$myApp = {};
  $myApp.productName = "phones";
  $myApp.productCardClassName = "phone_card";
  $myApp.calculateFiltersUrl = '/phones/calculate_filters';
  $myApp.sortModes = {};
  $myApp.perPages = {};
  let cookie = $.cookie("what_is_it_message_appeared");
  if (cookie) $myApp.what_is_it_message_appeared = true;
  else $myApp.what_is_it_message_appeared = false;
</script>