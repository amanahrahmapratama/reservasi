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

				<div class="card mb-4">
					<div class="card-body">
						<h4 class="card-title">Kode History Transaksi : <?php echo $history['sale_inv_num'] ?></h4>

						<div class="table-responsive">
							<table class="table">
								<thead class="thead-light">
									<th>Nama Barang</th>
									<th>Jumlah</th>
									<th>Harga Satuan</th>
									<th>Sub Total</th>
								</thead>
								<tbody>
									<?php foreach ($sale_item as $key): ?>
										<tr>
											<td><?php echo $key['catalog_name'] ?></td>
											<td><?php echo $key['sale_count'] ?></td>
											<td><?php echo idr_format($key['sale_price']) ?></td>
											<td><?php echo idr_format($key['sale_total_price']) ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
								<tr>
									<td colspan="3">Ongkos Kirim</td>
									<td><?php echo idr_format($history['sale_ongkir']) ?></td>
								</tr>
								<tr>
									<td colspan="3"><b>Total</b></td>
									<td><b><?php echo idr_format($history['sale_total_price'] + $history['sale_ongkir'] ) ?></b></td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<address>
									<h4>Nama Penerima</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold mb-5">
										<?php echo $history['sale_recipient_name'] ?>
									</p>

									<h4>Alamat Tujuan</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold mb-5">
										<?php echo $history['sale_shipping_address'] ?>
									</p>

									<h4>Kurir</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold">
										<?php echo $history['sale_courier'] ?>
									</p>
								</address>
							</div>
							<div class="col-md-4">
								<address>
									<h4>Nomor Telepon</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold mb-5"> 
										<?php echo $history['sale_recipient_phone'] ?>
									</p>

									<h4>Kode Pos</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold mb-5">
										<?php echo $history['sale_postal_code'] ?>
									</p>

									<h4>Layanan</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold">
										<?php echo $history['sale_courier_service'] ?>
									</p>
								</address>
							</div>
							<div class="col-md-4">
								<address>
									<h4>Provinsi</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold mb-5">
										<?php echo $history['sale_province'] ?>
									</p>
									
									<h4>Kota/Kabupaten</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold mb-5">
										<?php echo $history['sale_kabupaten'] ?>
									</p>
									
									<h4>Tracking Id</h4>
									<hr class="mt-0">
									<p class="text-success font-weight-bold">
										<?php echo $history['sale_tracking_id'] ?>
									</p>
								</address>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>