<section class="contact-page-area section-gap">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center">
					<h1>Reservasi Ruangan</h1>
				</div>
			</div>
		</div>
		<div class="row mb-10">
			<div class="col-md-6">
				<div class="single-post row">
					<div class="col-lg-12">
						<div class="feature-img">
							<?php if ($catalog['catalog_image'] != ''): ?>
								<img src="<?php echo upload_url($catalog['catalog_image']); ?>" alt="" class="img-thumbnail">
								<?php else: ?>
									<img src="<?php echo media_url('templates/groot/img/content/single/single_post_featured_img.jpg') ?>" alt="" class="img-thumbnail">
								<?php endif ?>
							</div>
						</div>
						<div class="col-lg-9 col-md-9">
							<h3 class="mt-3"><?php echo $catalog['catalog_name']; ?></h3>
						</div>
						<div class="col-lg-12">
							<div class="">
								<?php echo $catalog['catalog_desc'] ?>
							</div>

						</div>
					</div>
				</div>
				<div class="col-md-6">
					<?php echo validation_errors() ?>
					<?php echo form_open_multipart(current_url(), array('class' => "form-area contact-form text-right")); ?>

					<?php 
					$csrf = array(
						'name' => $this->security->get_csrf_token_name(),
						'hash' => $this->security->get_csrf_hash()
					);
					?>
					<input type="text" name="inputJenis" class="form-control common-input mb-20" placeholder="Jenis Acara *" value="<?php echo set_value('inputJenis') ?>" required>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="inputDateStart" class="form-control common-input mb-20 dates" placeholder="Dari Tanggal *"  value="<?php echo set_value('inputDateStart') ?>" required readonly>
						</div>
						<div class="col-md-6">
							<input type="text" name="inputDateEnd" class="form-control common-input mb-20 dates" placeholder="Sampai Tanggal *"  value="<?php echo set_value('inputDateEnd') ?>" required readonly>
						</div>
					</div>
					<input type="number" name="inputAttendance" class="form-control common-input mb-20" placeholder="Estimasi Peserta & Panitia *"  value="<?php echo set_value('inputAttendance') ?>" required>
					<textarea name="inputOtherRequest" placeholder="Kebutuhan lainnya yang tidak terdapat dalam deskripsi ruangan" class="form-control common-input mb-20"><?php echo set_value('inputOtherRequest') ?></textarea>
					<label class="float-left">Scan Surat Permohonan *</label>
					<input type="file" name="inputFile" id="inputFile" class="form-control common-input mb-20" required>
					<label class="float-left">Scan Proposal *</label>
					<input type="file" name="inputProposal" id="inputProposal" class="form-control common-input mb-20" required>
					<div class="alert alert-primary">
						<em>
							File yang diperbolehkan: Doc, Docx, PDF, jpg, png
						</em>
					</div>
					<button type="submit" class="primary-btn primary float-left">Submit</button>
					<?php echo form_close(); ?>
				</div>
			</div>
		</section>

		<script type="text/javascript">
			$('#inputFile').bind('change', function() {
				var iSize = $('#inputFile')[0].files[0].size;
				iSize = (Math.round((iSize / 1024)) / 1000)
				if (iSize > 2) {
					alert("File tidak boleh lebih dari 2Mb");
					$('#inputFile').val("")
				}
			});

			$('#inputProposal').bind('change', function() {
				var iSize = $('#inputProposal')[0].files[0].size;
				iSize = (Math.round((iSize / 1024)) / 1000)
				if (iSize > 2) {
					alert("File tidak boleh lebih dari 2Mb");
					$('#inputProposal').val("")
				}
			});
		</script>