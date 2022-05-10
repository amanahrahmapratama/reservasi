<?php if(isset($slider)) {
	$inputFile = $slider['slider_photo'];
	$inputCaption = $slider['slider_caption'];
}else{
	$inputFile = set_value('inputFile');
	$inputCaption = set_value('inputCaption');
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

						<label>Caption *</label>
						<input type="text" name="inputCaption" class="form-control" placeholder="Caption" value="<?php echo $inputCaption ?>" required>
						<label>Photo *</label>
						<input type="file" name="inputFile" class="form-control">
						<br>
						<?php if (isset($slider) && $slider['slider_photo'] != ''): ?>
							<img src="<?php echo base_url('uploads/sliders/' . $inputFile ) ?>" class="img img-responsive">
						<?php endif ?>
						<div class="alert alert-info">
							*) Required
						</div>
					</div>

					<div class="col-md-4">
						<label>Aksi</label>
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</div>
				</div>
				<?php echo form_close(); ?>

			</div>
		</div>
	</div>
</div>
