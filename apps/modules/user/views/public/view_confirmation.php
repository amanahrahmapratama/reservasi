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
				<div class="card mb-4">
					<div class="card-body">
						<h4 class="card-table">Detail Transaksi</h4>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td>Invoice</td>
									<td><?php echo $sale['sale_inv_num'] ?></td>
								</tr>
								<tr>
									<td>Tanggal</td>
									<td><?php echo pretty_date($sale['sale_date'], 'l, d F Y', false) ?></td>
								</tr>
								<tr>
									<td>Nama Pembeli</td>
									<td><?php echo $sale['customer_full_name'] ?></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><?php echo $sale['customer_email'] ?></td>
								</tr>
								<tr>
									<td>Total Harga</td>
									<td>Rp <?php echo $sale['sale_total_price'] ?></td>
								</tr>
								<tr>
									<td>Status</td>
									<td><?php echo $sale['sale_status_name'] ?></td>
								</tr>
								<tr>
									<td>Nama Penerima</td>
									<td><?php echo $sale['sale_recipient_name'] ?></td>
								</tr>
								<tr>
									<td>Provinsi</td>
									<td><?php echo $sale['sale_province'] ?></td>
								</tr>
								<tr>
									<td>Kabupaten</td>
									<td><?php echo $sale['sale_kabupaten'] ?></td>
								</tr>
								<tr>
									<td>Alamat Pengiriman</td>
									<td><?php echo $sale['sale_shipping_address'] ?></td>
								</tr>
								<tr>
									<td>Kode Pos</td>
									<td><?php echo $sale['sale_postal_code'] ?></td>
								</tr>
								<tr>
									<td>Kurir</td>
									<td><?php echo $sale['sale_courier']; ?></td>
								</tr>
								<tr>
									<td>Layanan</td>
									<td><?php echo $sale['sale_courier_service']; ?></td>
								</tr>
								<?php if ($sale['sale_status_sale_status_id'] == STATUS_SHIPPED): ?>
									<tr>
										<td>No. Tracking</td>
										<td><?php echo $sale['sale_tracking_id']; ?></td>
									</tr>
								<?php endif ?>
							</table>
						</div>
					</div>
				</div>

				<div class="card mb-4">
					<div class="card-body">
						<h4 class="card-title">Daftar Barang</h4>
						
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>Nama Barang</th>
									<th>Qty</th>
									<th>Harga Satuan</th>
									<th>Subtotal</th>
								</thead>
								<tbody>
									<?php $count = 0; ?>
									<?php foreach ($sale_item as $key): ?>
										<tr>
											<td><?php echo $key['catalog_name'] ?></td>
											<td><?php echo $key['sale_count'] ?></td>
											<td><?php echo $key['sale_price'] ?></td>
											<td><?php echo $key['sale_total_price'] ?></td>
										</tr>
										<?php $count += $key['sale_total_price'] ?>
									<?php endforeach ?>
									<tr>
										<td colspan="3">Ongkos Kirim</td>
										<td><?php echo $sale['sale_ongkir'] ?></td>
									</tr>
									<tr>
										<td colspan="3"><strong>Total</strong></td>
										<td><strong>Rp. <?php echo $count+$sale['sale_ongkir'] ?>,-</strong></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php if ($sale['sale_status_sale_status_id'] == STATUS_NEW): ?>
					<div class="card mb-4">
						<div class="card-body">
							<h4 class="card-title">Daftar Rekening</h4>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<div class="alert alert-warning" role="alert"><?php echo $rekening_1 ?></div>
								</div>
								<div class="col-md-4">
									<div class="alert alert-warning" role="alert"><?php echo $rekening_2 ?></div>
								</div>
								<div class="col-md-4">
									<div class="alert alert-warning" role="alert"><?php echo $rekening_3 ?></div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mb-4">
						<div class="card-body">
							<h4 class="card-title">Konfirmasi Pembayaran</h4>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<?php echo form_open_multipart(current_url(), array('id' => 'candidatedata', 'class' => 'form-horizontal')); ?>

									<div class="form-group">
										<label class="control-label">Ke Bank</label>
										<input type="text" class="form-control" name="inputTransferTo" value="" placeholder="No. Rekening Tujuan">
									</div>
									<div class="form-group">
										<input type="hidden" name="confirmation" value="1">
										<label class="control-label" for="rut">Tanggal Transfer<span class="requerido"> *</span></label>
										<input class="form-control"
										id="datepicker"
										name="inputTransferDate"
										type="text" 

										oninput="setCustomValidity('')"
										placeholder="Tanggal Transfer" 
										required="required">
									</div>
									<div class="form-group">
										<label class="control-label" for="rut">Atas Nama<span class="requerido"> *</span></label>
										<input type="text"
										oninvalid="this.setCustomValidity('Input Atas Nama Wajib Diisi')"
										oninput="setCustomValidity('')"
										class="form-control rut"
										name="inputTransferName" 
										placeholder="Nama Pemilik Rekening"
										required="required">
									</div>
									<div class="form-group">
										<label class="control-label" for="textinput">Scan Bukti Transfer</label>
										<input type="file" class="form-control" name="inputFile">
									</div>
									<?php form_close(); ?>
								</div>

								<div class="col-md-6">
									<div class="alert alert-info" role="alert">
										<h4 class="alert-heading">Bagaimana Saya Tahu Bahwa Pembayaran Saya Telah Diterima?</h4>
										<hr>
										<p>
											Kami akan menginformasikan bahwa pembayaran Anda telah di terima oleh Jatayu Store melalui email “Konfirmasi Payment Approval”
											atau Anda dapat melihat melalui halaman order tracking yang terdapat di home page website Jatayu Store. Bila dalam 1 x 24 jam (terhitung pada hari kerja) Anda tidak mendapat informasi tersebut,
											silahkan menghubungi sales yang menangani pemesanan Anda.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		yearRange: ""
	});
</script>