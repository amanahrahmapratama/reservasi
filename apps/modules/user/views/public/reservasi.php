<section class="contact-page-area section-gap mb-20">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php echo $this->load->view('templates/groot/sidebar') ?>
			</div>
			<div class="col-md-9">
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
						<thead>
							<th>Nama Ruangan</th>
							<th>Tanggal</th>
							<th>Status</th>
							<th></th>
						</thead>
						<tbody>
							<?php foreach ($reservasi as $key): ?>
								<tr>
									<td><?php echo $key['catalog_name'] ?></td>
									<td><?php echo pretty_date($key['reservasi_date_start'], 'd F Y', false) . ' s.d. ' . pretty_date($key['reservasi_date_end'], 'd F Y', false) ?></td>
									<td><?php echo $key['status_name'] ?></td>
									<td>
										<a href="<?php echo site_url('user/reservasi/view/' .  $key['reservasi_id']) ?>" class="btn btn-sm btn-info"> View</a>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>

					<?php echo $this->pagination->create_links() ?>
				</div>				

			</div>
		</div>
	</div>
</section>

