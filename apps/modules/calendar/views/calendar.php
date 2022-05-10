<link href="<?php echo base_url('media/fullcalendar/fullcalendar.min.css') ?>" rel="stylesheet" />
<link href="<?php echo base_url('media/fullcalendar/fullcalendar.print.min.css') ?>" rel="stylesheet" media="print" />
<script src="<?php echo base_url('media/fullcalendar/moment.min.js') ?>"></script>
<script src="<?php echo base_url('media/fullcalendar/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('media/fullcalendar/fullcalendar.min.js') ?>"></script>
<script src="<?php echo base_url('media/fullcalendar/locale-all.js') ?>"></script>

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
				</h3>

				<div id="calendar"></div>

				<br>
				<label>Keterangan Warna : </label>
				<span style="color: #649DDD; background: #649DDD">Color</span> Reservasi Baru
				<span style="color: #4A4297; background: #4A4297">Color</span> Sedang dalam proses
				<span style="color: #51D045; background: #51D045">Color</span> Disetujui
				<span style="color: #BC2E00; background: #BC2E00">Color</span> Ditolak

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: "<?php echo date('Y-m-d') ?>",
			locale: 'id',
			editable: false,
			eventLimit: true, 
			events: <?php echo $date ?>,
			eventClick: function(calEvent, jsEvent, view) {
				location.href = "<?php echo site_url('admin/reservasi/view/') ?>" + calEvent.id
			}
		});

	});

</script>
