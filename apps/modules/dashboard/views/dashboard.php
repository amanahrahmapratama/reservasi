<div class="page-title">
	<h3><?php echo $title; ?></h3>
</div>

<div id="container">
	<div class="row">
		<div class="col-md-3 spacing-bottom">
			<div class="tiles blue">
				<div class="tiles-body">
					<div class="tiles-title"> TOTAL RUANGAN </div>
					<div class="heading"> <span class="animate-number" data-value="<?php echo $countRuangan ?>" data-animation-duration="1200">0</span></div>
					<div class="description">
						<a href="<?php echo site_url('admin/catalog') ?>" class="text-white mini-description">
							Selengkapnya <span class="fa fa-arrow-circle-right"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 spacing-bottom">
			<div class="tiles green">
				<div class="tiles-body">
					<div class="tiles-title"> TOTAL RESERVASI </div>
					<div class="heading"> <span class="animate-number" data-value="<?php echo $countReservasi ?>" data-animation-duration="1000">0</span></div>
					<div class="description">
						<a href="<?php echo site_url('admin/sale') ?>" class="text-white mini-description">
							Selengkapnya <span class="fa fa-arrow-circle-right"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 spacing-bottom">
			<div class="tiles red">
				<div class="tiles-body">
					<div class="tiles-title"> TOTAL PENGUNJUNG RESERVASI </div>
					<div class="heading"> <span class="animate-number" data-value="<?php echo $countCustomer ?>" data-animation-duration="1200">0</span></div>
					<div class="description">
						<a href="<?php echo site_url('admin/customer') ?>" class="text-white mini-description">
							Selengkapnya <span class="fa fa-arrow-circle-right"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 spacing-bottom">
			<div class="tiles purple">
				<div class="tiles-body">
					<div class="tiles-title"> TOTAL HARI RESERVASI </div>
					<div class="row-fluid">
						<div class="heading"> <span class="animate-number" data-value="<?php echo $reservasiDayCount ?>" data-animation-duration="700">0</span></div>
					</div>
					<div class="description">
						<a href="<?php echo site_url('admin/posting') ?>" class="text-white mini-description">
							Selengkapnya <span class="fa fa-arrow-circle-right"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="grid simple">
				<div class="grid-title no-border">
					<h4>RESERVASI BELUM DIPROSES</h4>
				</div>
				<div class="grid-body no-border">

					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Nama Ruangan</th>
									<th>Pemohon</th>
									<th>Tanggal Submit</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($latestNewReservasi as $row): ?> 
									<tr>
										<td >
											<a href="<?php echo site_url('admin/reservasi/view/' . $row['reservasi_id']); ?>" >
												<?php echo $row['catalog_name']; ?>
											</a>
										</td>
										<td ><?php echo $row['customer_full_name']; ?></td>
										<td ><?php echo pretty_date($row['reservasi_created_at'], 'd F Y', false) ?></td>
										<td>
											<a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/reservasi/view/' . $row['reservasi_id']); ?>" ><i class="fa fa-eye"></i></a>
										</td>
									</tr>
								<?php endforeach ?> 
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="row 2col">
		<div class="col-md-6">
			<div class="grid simple">
				<div class="grid-title no-border">
					<h4>RESERVASI TERBARU</h4>
				</div>
				<div class="grid-body no-border">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Nama Ruangan</th>
									<th>Pemohon</th>
									<th>Tanggal</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($latestReservasi as $row): ?> 
									<tr>
										<td >
											<a href="<?php echo site_url('admin/reservasi/view/' . $row['reservasi_id']); ?>" >
												<?php echo $row['catalog_name']; ?>
											</a>
										</td>
										<td ><?php echo $row['customer_full_name']; ?></td>
										<td ><?php echo pretty_date($row['reservasi_date_start'], 'd F Y', false) . ' s.d. ' . pretty_date($row['reservasi_date_end'], 'd F Y', false) ?></td>
										<td ><?php echo $row['status_name']; ?></td>
									</tr>
								<?php endforeach ?> 
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="grid simple">
				<div class="grid-title no-border">
					<h4>NEWS TERBARU</h4>
				</div>
				<div class="grid-body no-border">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Judul</th>
									<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($latestNews as $key): ?>
									<tr>
										<td><?php echo $key['posting_title'] ?></td>
										<td><?php echo pretty_date($key['posting_created_date'], 'd-m-Y', FALSE) ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="grid simple">
				<div class="grid-title no-border">
					<h4>KALENDER RESERVASI</h4>
				</div>
				<div class="grid-body no-border">
					
					<div id="calendar"></div>

				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<br>
					<h4 id="myModalLabel" class="semi-bold">Konfirmasi Penghapusan</h4>
				</div>
				<?php echo form_open(site_url('admin/sale/delExpiredTransaction')) ?>
				<div class="modal-body">
					<p>Apakah anda yakin ingin menghapus data ini?</p>
					<input type="hidden" name="id" id="getId">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Hapus</button>
				</div>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>

	<script>
		function removeExpiredTransaction($id) {
			$('#getId').val($id);
		}
	</script>

	<link href="<?php echo base_url('media/fullcalendar/fullcalendar.min.css') ?>" rel="stylesheet" />
	<link href="<?php echo base_url('media/fullcalendar/fullcalendar.print.min.css') ?>" rel="stylesheet" media="print" />
	<script src="<?php echo base_url('media/fullcalendar/moment.min.js') ?>"></script>
	<script src="<?php echo base_url('media/fullcalendar/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('media/fullcalendar/fullcalendar.min.js') ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#calendar').fullCalendar({
				defaultDate: "<?php echo date('Y-m-d') ?>",
				editable: false,
				eventLimit: true, 
				events: <?php echo $date ?>,
				eventClick: function(calEvent, jsEvent, view) {
					location.href = "<?php echo site_url('admin/reservasi/view/') ?>" + calEvent.id
				}
			});

		});

	</script>
