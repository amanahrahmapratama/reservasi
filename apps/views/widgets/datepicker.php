<link href="<?php echo media_url('css/datepicker.min.css');?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo media_url('js/bootstrap-datepicker.min.js');?>" type="text/javascript"></script>

<script>
$(document).ready(function() {
	$('.input-append.date').datepicker({
		autoclose: true,
		todayHighlight: true
	});
});
</script>
