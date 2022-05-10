<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
				</h3>
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right">
							<a class="btn btn-danger" data-toggle="modal" href='#modalDelete'>Hapus</a>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td>Caption</td>
										<td><?php echo $sliders['slider_caption'] ?></td>
									</tr>
									<tr>
										<td>Photo</td>
										<td>
											<img src="<?php echo base_url('uploads/sliders/' . $sliders['slider_photo'] ) ?>" class="img img-responsive">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modalDelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Hapus Slider</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger text-center">
					Anda yakin akan menghapus slider ini?
				</div>
			</div>
			<?php echo form_open('admin/sliders/delete/' . $sliders['slider_id'] ); ?>
			<?php 
			$csrf = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			?>
			<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
			<input type="hidden" name="inputDelete" value="1">
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>