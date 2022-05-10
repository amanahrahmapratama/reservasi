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
			<div class="col-md-4">
				<?php echo $this->load->view('templates/groot/sidebar') ?>
			</div>
			<div class="col-md-8">
				<h3 class="page-title"><?php echo $title; ?></h3>
				
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<thead>
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
											<td><?php echo 'Rp. ' . $key['sale_price'] ?></td>
											<td><?php echo 'Rp. ' . $key['sale_total_price'] ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
								<tr>
									<td colspan="3">Ongkos Kirim</td>
									<td>
										<?php echo 'Rp. ' . $history['sale_ongkir'] ?>
									</td>
								</tr>
								<tr>
									<td colspan="3">Total</td>
									<td><?php echo 'Rp. ' . ($history['sale_total_price'] + $history['sale_ongkir'] ) ?></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								<address>
									<strong class="text-warning"><h4><span class="ion-person"></span> Nama Penerima</h4></strong>
									<hr>
									<p class="text-success">
										<?php echo $history['sale_recipient_name'] ?>
									</p>
									<br>
									<strong class="text-warning"><h4><span class="ion-home"></span> Alamat Tujuan</h4></strong>
									<hr>
									<p class="text-success">
										<?php echo $history['sale_shipping_address'] ?>
									</p>
									<br>
									<strong class="text-warning"><h4><span class="ion-home"></span> Kurir</h4></strong>
									<hr>
									<p class="text-success">
										<?php echo $history['sale_courier'] ?>
									</p>
								</address>
							</div>
							<div class="col-md-4 col-sm-4">
								<address>
									<strong class="text-warning"><h4><span class="ion-card"></span> Nomor Telepon</h4></strong>
									<hr>
									<p class="text-success"> 
										<?php echo $history['sale_recipient_phone'] ?>
									</p>
									<br>
									<strong class="text-warning"><h4><span class="ion-email"></span> Kode Pos</h4></strong>
									<hr>
									<p class="text-success">
										<?php echo $history['sale_postal_code'] ?>
									</p>
									<br>
									<strong class="text-warning"><h4><span class="ion-home"></span> Layanan</h4></strong>
									<hr>
									<p class="text-success">
										<?php echo $history['sale_courier_service'] ?>
									</p>
								</address>
							</div>
							<div class="col-md-4 col-sm-4">
								<address>
									<strong class="text-warning"><h4><span class="ion-location"></span> Provinsi</h4></strong>
									<hr>
									<p class="text-success"><?php echo $history['sale_province'] ?></p>
									<br>
									<strong class="text-warning"><h4><span class="ion-location"></span> Kota/Kabupaten</h4></strong>
									<hr>
									<p class="text-success"><?php echo $history['sale_kabupaten'] ?></p>
									<br>
									<strong class="text-warning"><h4><span class="ion-home"></span> Tracking Id</h4></strong>
									<hr>
									<p class="text-success">
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