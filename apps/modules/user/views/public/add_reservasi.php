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

				<?php echo validation_errors() ?>
				<?php echo form_open_multipart(current_url(), array('class' => "form-area contact-form text-right")); ?>

				<?php 
				$csrf = array(
					'name' => $this->security->get_csrf_token_name(),
					'hash' => $this->security->get_csrf_hash()
				);
				?>
				<input type="text" name="inputJenis" class="form-control common-input mb-20" placeholder="Jenis Acara *" value="<?php echo $reservasi['reservasi_type'] ?>" required>
				<div class="row">
					<div class="col-md-6">
						<input type="text" name="inputDateStart" class="form-control common-input mb-20 dates" placeholder="Dari Tanggal *"  value="<?php echo $reservasi['reservasi_date_start'] ?>" required readonly>
					</div>
					<div class="col-md-6">
						<input type="text" name="inputDateEnd" class="form-control common-input mb-20 dates" placeholder="Sampai Tanggal *"  value="<?php echo $reservasi['reservasi_date_end'] ?>" required readonly>
					</div>
				</div>
				<input type="number" name="inputAttendance" class="form-control common-input mb-20" placeholder="Estimasi Peserta & Panitia *"  value="<?php echo $reservasi['reservasi_attendance'] ?>" required>
				<textarea name="inputOtherRequest" placeholder="Kebutuhan Lainnya" class="form-control common-input mb-20"><?php echo $reservasi['reservasi_other_request'] ?></textarea>
				<label class="float-left">Scan Surat Permohonan *</label>
				<input type="file" name="inputFile" class="form-control common-input mb-20">
				<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_request_file']) ?>"><?php echo $reservasi['reservasi_request_file'] ?></a>
				<br>
				<label class="float-left">Scan Proposal *</label>
				<input type="file" name="inputProposal" class="form-control common-input mb-20">
				<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_proposal_file']) ?>"><?php echo $reservasi['reservasi_proposal_file'] ?></a>
				<br>
				<button type="submit" class="primary-btn primary float-left">Submit</button>
				<?php echo form_close(); ?>

			</div>
		</div>
	</div>
</section>

