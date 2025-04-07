<script type="text/javascript">
	$myApp = {};
  $myApp.productName = "laptops";
  $myApp.productCardClassName = "laptop_card";
  $myApp.calculateFiltersUrl = '/laptops/calculate_filters';
  $myApp.sortModes = {};
  $myApp.perPages = {};
  let cookie = $.cookie("what_is_it_message_appeared");
  if (cookie) $myApp.what_is_it_message_appeared = true;
  else $myApp.what_is_it_message_appeared = false;
</script>