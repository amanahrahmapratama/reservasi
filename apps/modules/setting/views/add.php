<?php
if (isset($setting)) {
	$inputKey = $setting['setting_key'];
	$inputValue = $setting['setting_value'];
} else {
	$inputKey = set_value('inputKey');
	$inputValue = set_value('inputValue');
};

$uri_4 = ($this->uri->segment(4) == 'email_smtp_pass' ? 'password' : 'text') ;
?>

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
				</h3>

				<?php echo form_open_multipart(current_url()); ?>

				<?php echo validation_errors(); ?>
				<div class="row">
					<div class="col-sm-9 col-md-9">
						<label>Setting Key</label>
						<input type="text" name="inputKey" class="form-control" readonly="true" value="<?php echo $inputKey; ?>" />
						<br>
						<label>Setting Value</label>
						<input type="<?php echo $uri_4 ?>" name="inputValue" class="form-control" value="<?php echo $inputValue ?>">
						<input type="hidden" name="last_url" class="form-control" value="<?php echo $last_url ?>">
					</div>
					<div class="col-sm-9 col-md-3">
						<div class="form-group">
							<button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
							<a href="<?php echo site_url('admin/setting'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>