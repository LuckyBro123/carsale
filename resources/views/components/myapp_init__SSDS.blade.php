<script type="text/javascript">
	$myApp = {};
  $myApp.productName = "ssds";
  $myApp.productCardClassName = "ssd_card";
  $myApp.calculateFiltersUrl = '/ssds/calculate_filters';
  $myApp.sortModes = {};
  $myApp.perPages = {};
  let cookie = $.cookie("what_is_it_message_appeared");
  if (cookie) $myApp.what_is_it_message_appeared = true;
  else $myApp.what_is_it_message_appeared = false;
</script>