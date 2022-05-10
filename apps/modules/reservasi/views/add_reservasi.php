<?php if(isset($reservasi)) {
	$inputJenis = $reservasi['reservasi_type'];
	$inputDateStart = $reservasi['reservasi_date_start'];
	$inputDateEnd = $reservasi['reservasi_date_end'];
	$inputAttendance = $reservasi['reservasi_attendance'];
	$inputOtherRequest = $reservasi['reservasi_other_request'];
	$inputCatalog = $reservasi['catalog_catalog_id'];
	$inputCustomer = $reservasi['customer_customer_id'];
	$inputFile = $reservasi['reservasi_request_file'];
	$inputProposal = $reservasi['reservasi_proposal_file'];
}else{
	$inputJenis = set_value('inputJenis');
	$inputDateStart = set_value('inputDateStart');
	$inputDateEnd = set_value('inputDateEnd');
	$inputAttendance = set_value('inputAttendance');
	$inputOtherRequest = set_value('inputOtherRequest');
	$inputCatalog = set_value('inputCatalog');
	$inputCustomer = set_value('inputCustomer');
	$inputFile = set_value('inputFile');
	$inputProposal = set_value('inputProposal');

} ?>

<script type="text/javascript" src="<?php echo base_url('media/select2/select2.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('media/select2/select2.css') ?>">

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
				</h3>

				<?php echo form_open_multipart(current_url()); ?>
				<div class="row">
					<div class="col-md-8">
						<?php echo validation_errors() ?>

						<?php 
						$csrf = array(
							'name' => $this->security->get_csrf_token_name(),
							'hash' => $this->security->get_csrf_hash()
						);
						?>
						<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

						<label>Pemohon *</label>
						<?php if (!isset($reservasi)): ?>
							<div id="select2" style="width:100%"></div>
							<input type="hidden" name="inputCustomer" value="<?php echo $inputCustomer ?>">
							<br>
							<?php else: ?>
								<label>
									<?php echo $reservasi['customer_full_name'] ?>
								</label>
							<?php endif ?>
							<br>
							<label>Ruangan *</label>
							<select name="inputCatalog" class="form-control">
								<option value="">Pilih Ruangan</option>
								<?php foreach ($catalog as $key): ?>
									<option value="<?php echo $key['catalog_id'] ?>" <?php echo $inputCatalog == $key['catalog_id'] ? 'selected' : null ?>><?php echo $key['catalog_name'] ?></option>
								<?php endforeach ?>
							</select>
							<br>
							<label>Jenis Acara *</label>
							<input type="text" name="inputJenis" class="form-control" placeholder="Jenis Acara" value="<?php echo $inputJenis ?>" required>
							<br>
							<label>Tanggal *</label>
							<div class="row">
								<div class="col-md-6">
									<input type="text" name="inputDateStart" class="form-control datepicker" placeholder="Dari Tanggal"  value="<?php echo $inputDateStart ?>" required>
								</div>
								<div class="col-md-6">
									<input type="text" name="inputDateEnd" class="form-control datepicker" placeholder="Sampai Tanggal"  value="<?php echo $inputDateEnd ?>" required>
								</div>
							</div>
							<br>
							<label>Estimasi Jumlah Orang Yang Datang / Panitia *</label>
							<input type="number" name="inputAttendance" class="form-control" placeholder="Estimasi Peserta"  value="<?php echo $inputAttendance ?>" required>
							<br>
							<label>Kebutuhan Lainnya</label>
							<textarea name="inputOtherRequest" class="form-control"><?php echo $inputOtherRequest ?></textarea>
							<br>
							<div class="alert alert-info">
								*) Required
							</div>
						</div>

						<div class="col-md-4">
							<label>File Surat Permohonan Pinjam Ruangan *</label>
							<input type="file" name="inputFile" class="form-control">
							<br>
							<label>File Proposal Permohonan *</label>
							<input type="file" name="inputProposal" class="form-control">
							<br>
							<label>Aksi</label>
							<button type="submit" class="btn btn-primary btn-block">Submit</button>
						</div>
					</div>
					<?php echo form_close(); ?>

				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('admin/datepicker'); ?>	

	<script type="text/javascript">
		$("#select2").select2({
			placeholder: "Pilih Customer",
			minimumInputLength: 2,
			ajax: { 
				url: "<?php echo base_url('admin/customer/getAjax') ?>",
				dataType: 'json',
				quietMillis: 250,
				data: function (term, page) {
					return {
						q: term, 
					};
				},
        results: function (data, page) { // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to alter the remote JSON data
            return { results: data.results };
        },
        cache: true
    },
}).on("select2-selecting", function(e) {
	$("input[name=inputCustomer]").val(e.val);
});
</script>
