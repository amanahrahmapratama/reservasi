<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
					<span class=" pull-right">
						<a href="<?php echo site_url('admin/contact'); ?>" class="btn btn-success">Kembali</a>
						<a href="#delModal" data-toggle="modal" class="btn btn-danger">Hapus</a>
					</span>
				</h3>

				<div class="table-responsive">
					<table class="table">
						<tr>
							<td>Nama</td>
							<td><?php echo $contact['contact_name'] ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $contact['contact_email'] ?></td>
						</tr>
						<tr>
							<td>Subject</td>
							<td><?php echo $contact['contact_subject'] ?></td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td><?php echo pretty_date($contact['contact_created_at'], 'd F Y - H:i:s', FALSE) ?></td>
						</tr>
						<tr>
							<td>Pesan</td>
							<td><?php echo $contact['contact_message'] ?></td>
						</tr>
					</table>
				</div>
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
            <?php echo form_open(site_url('admin/contact/delete')) ?>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini?</p>
                <input type="hidden" name="id" value="<?php echo $contact['contact_id'] ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Hapus</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>