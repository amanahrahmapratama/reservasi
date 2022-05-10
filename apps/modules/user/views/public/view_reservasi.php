<?php
$color = ''; 
$status = $reservasi['reservasi_status_status_id'];
if ($status == STATUS_NEW) {
	$color = 'badge-info';
}elseif ($status == STATUS_PROCESS) {
	$color = 'badge-primary';
}elseif ($status == STATUS_APPROVED) {
	$color = 'badge-success';
}else {
	$color = 'badge-danger';
}
?>

<section class="contact-page-area section-gap mb-20">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php echo $this->load->view('templates/groot/sidebar') ?>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-9">
						<h3 class="page-title">
							<?php echo $title; ?>
						</h3>	
					</div>
					<div class="col-md-3">
						<div class="pull-right">
							<span class="badge <?php echo $color ?>"><?php echo $reservasi['status_name'] ?></span>
							<?php if ($reservasi['reservasi_status_status_id'] == STATUS_NEW || $reservasi['reservasi_status_status_id'] == STATUS_PROCESS): ?>
								<a href="<?php echo site_url('user/reservasi/edit/' . $reservasi['reservasi_id'] ) ?>"><strong> Edit</strong></a>
							<?php endif ?>
						</div>
					</div>
				</div>
				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Selamat!</strong> <?php echo $this->session->flashdata('success') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
							<tr>
								<td>Nama Ruangan</td>
								<td><?php echo $reservasi['catalog_name'] ?></td>
							</tr>
							<tr>
								<td>Jenis Pemakaian</td>
								<td><?php echo $reservasi['reservasi_type'] ?></td>
							</tr>
							<tr>
								<td>Tanggal Pinjam</td>
								<td><?php echo pretty_date($reservasi['reservasi_date_start'], 'd F Y', false) . ' s.d. ' . pretty_date($reservasi['reservasi_date_end'], 'd F Y', false) ?></td>
							</tr>
							<tr>
								<td>Estimasi Jumlah Orang Yang Datang / Panitia</td>
								<td><?php echo $reservasi['reservasi_attendance'] . ' Orang' ?></td>
							</tr>
							<tr>
								<td>Kebutuhan Lainnya</td>
								<td><?php echo $reservasi['reservasi_other_request'] ?></td>
							</tr>
							<?php if (!is_null($reservasi['reservasi_request_file'])): ?>
								<tr>
									<td>Scan File Permohonan Pinjam Ruangan</td>
									<td>
										<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_request_file']) ?>"><?php echo $reservasi['reservasi_request_file'] ?></a>
									</td>
								</tr>
							<?php endif ?>
							<?php if (!is_null($reservasi['reservasi_proposal_file'])): ?>
								<tr>
									<td>Scan File Proposal Permohonan</td>
									<td>
										<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_proposal_file']) ?>"><?php echo $reservasi['reservasi_proposal_file'] ?></a>
									</td>
								</tr>
							<?php endif ?>
							<?php if ($reservasi['reservasi_status_status_id'] == STATUS_APPROVED || $reservasi['reservasi_status_status_id'] == STATUS_REJECTED): ?>
								<?php if (!is_null($reservasi['reservasi_response_file'])): ?>
									<tr>
										<td>
											<?php if ($reservasi['reservasi_status_status_id'] == STATUS_APPROVED): ?>
												Scan Surat Persetujuan Reservasi Gedung
												<?php else: ?>
													Scan Surat Penolakan Reservasi Gedung
												<?php endif ?>
											</td>
											<td>
												<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_response_file']) ?>"><?php echo $reservasi['reservasi_response_file'] ?></a>
											</td>
										</tr>
									<?php endif ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</section>

