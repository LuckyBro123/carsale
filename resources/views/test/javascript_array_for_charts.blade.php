<?php
$arr1 = $chartsData["Chevrolet"][0];
$arr1x1 = $chartsData["Chevrolet"];
?>
<script type="text/javascript">
  $myApp.arr1 = <?php echo json_encode($arr1) ?>;
  $myApp.arr1x1 = <?php echo json_encode($arr1x1) ?>;
  $myApp.chartsdata = <?php echo json_encode($chartsData) ?>;
</script>









