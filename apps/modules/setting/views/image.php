<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
				</h3>

				<?php echo form_open_multipart(current_url()) ?>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2">Favicon</label>
						<div class="col-sm-5">
							<input type="file" name="img_favicon" class="form-control">
						</div>
						<div class="col-md-5">
							<?php if ($setting['img_favicon']['setting_value'] != ''): ?>
								<img src="<?php echo base_url('uploads/meta/'.$setting['img_favicon']['setting_value']) ?>" class="img img-responsive">
							<?php endif ?>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2">Logo</label>
						<div class="col-sm-5">
							<input type="file" name="img_logo" class="form-control">
						</div>
						<div class="col-md-5">
							<?php if ($setting['img_logo']['setting_value'] != ''): ?>
								<img src="<?php echo base_url('uploads/meta/'.$setting['img_logo']['setting_value']) ?>" class="img img-responsive">
							<?php endif ?>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2">Brand</label>
						<div class="col-sm-5">
							<input type="file" name="img_brand" class="form-control">
						</div>
						<div class="col-md-5">
							<?php if ($setting['img_brand']['setting_value'] != ''): ?>
								<img src="<?php echo base_url('uploads/meta/'.$setting['img_brand']['setting_value']) ?>" class="img img-responsive">
							<?php endif ?>
						</div>
					</div>
				</div>


				<br>
				<button type="submit" class="btn btn-success">Simpan</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>