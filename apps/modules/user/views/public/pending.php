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
								<th>No Transaksi</th>
								<th>Tangal</th>
								<th>Total</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($pending as $key): ?>
								<tr>
									<td><?php echo $key['sale_inv_num'] ?></td>
									<td><?php echo pretty_date($key['sale_created_date'], 'd F Y', false) ?></td>
									<td><?php echo 'Rp. ' . ($key['sale_total_price'] + $key['sale_ongkir']) ?></td>
									<td>
										<a href="<?php echo site_url('user/view_pending/'.$key['sale_id']); ?>" class="btn btn-color btn-sm"><span>Detail</span></a>
									</td>
								</tr>
							<?php endforeach ?>
							<?php if (count($pending) == 0): ?>
								<tr>
									<td colspan="4" class="success">Data Kosong</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>