<div class="container">
	<ul class="breadcrumbs">
		<li class="breadcrumbs__item">
			<a href="<?php echo site_url() ?>" class="breadcrumbs__url">Home</a>
		</li>
		<li class="breadcrumbs__item breadcrumbs__item--current">
			<?php echo $title; ?>
		</li>
	</ul>
</div>

<div class="main-container container" id="main-container">
	<div class="blog__content mb-72">
		<div class="row">
			<div class="col-md-3">
				<?php echo $this->load->view('templates/groot/sidebar') ?>
			</div>
			<div class="col-md-9">
				<h3 class="page-title"><?php echo $title; ?></h3>

				<div class="table-responsive">
					<table class="table">
						<thead class="thead-light">
							<tr>
								<th>Invoice</th>
								<th>Tanggal</th>
								<th>Total</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($transaction) > 0): ?>
								<?php foreach ($transaction as $key): ?>
									<tr <?php if ($key['sale_status_sale_status_id'] == 2 && $key['customer_customer_id'] == $this->session->userdata('user_id_customer')): ?>
										class="table-warning"
									<?php endif ?>>
										<td><?php echo $key['sale_inv_num'] ?></td>
										<td><?php echo pretty_date($key['sale_created_date'], 'd F Y', FALSE) ?></td>
										<td><?php echo idr_format($key['sale_total_price'] + $key['sale_ongkir']) ?></td>
										<td>
											<?php if ($key['sale_status_sale_status_id'] == 1): ?>
												<span class="badge badge-danger">Menunggu ongkos kirim</span>
											<?php elseif ($key['sale_status_sale_status_id'] == 2): ?>
												<span class="badge badge-warning">Menunggu pembayaran</span>
											<?php elseif ($key['sale_status_sale_status_id'] == 3): ?>
												<span class="badge badge-secondary">Pending payment verification</span>
											<?php elseif ($key['sale_status_sale_status_id'] == 4): ?>
												<span class="badge badge-primary">Pembayaran dikonfirmasi</span>
											<?php elseif ($key['sale_status_sale_status_id'] == 5): ?>
												<span class="badge badge-info">Barang sudah dikirim</span>
											<?php else: ?>
												<span class="badge badge-success">Transaksi selesai</span>
											<?php endif ?>
										</td>
										<td>
											<?php if ($key['sale_status_sale_status_id'] == 2): ?>
												<a href="<?php echo site_url('user/transaction/view/'.$key['sale_id']) ?>" class="btn btn-color btn-sm"><span>Konfirmasi Pembayaran</span></a>
											<?php elseif ($key['sale_status_sale_status_id'] == 5): ?>
												<a href="#confirm-accepted" data-toggle="modal" onclick="getId(<?php echo $key['sale_id'] ?>)" class="btn btn-color btn-sm"><span>Konfirmasi Diterima</span></a>
											<?php else: ?>
												<a href="<?php echo site_url('user/transaction/view/'.$key['sale_id']) ?>" class="btn btn-color btn-sm"><span>Detail</span></a>
											<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>	
							<?php else: ?>
								<tr>
									<td colspan="5">Data transaksi kosong</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>

				<?php echo $this->pagination->create_links() ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-accepted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Konfirmasi Barang Diterima</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open(site_url('user/confirmAccepted')) ?>
			<div class="modal-body">
				Klik tombol konfirmasi jika anda sudah menerima barang.
				<input type="hidden" name="sale_id" id="setId">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span>Tutup</span></button>
				<button type="submit" class="btn btn-color btn-sm"><span>Konfirmasi</span></button>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>

<script>
	function getId(id) {
		$('#setId').val(id)
	}
</script>