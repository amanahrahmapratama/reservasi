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
							<?php if ($show_action_kabag_step_1): ?>
								<a class="btn btn-primary" data-toggle="modal" href='#modalKabag1'>Respon</a>
							<?php endif ?>
							<?php if ($show_action_kamus): ?>
								<a class="btn btn-primary" data-toggle="modal" href='#modalKamus'>Respon</a>
							<?php endif ?>
							<?php if ($show_action_kabag_step_2): ?>
								<a class="btn btn-primary" data-toggle="modal" href='#modalKabag2'>Respon</a>
							<?php endif ?>
							<?php if ($show_action_kabag_last_step): ?>
								<a class="btn btn-primary" data-toggle="modal" href='#modalKabagLastStep'>Respon</a>
							<?php endif ?>
							<a class="btn btn-danger" data-toggle="modal" href='#modalDelete'>Hapus</a>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-8">
						<div class="table-responsive">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td colspan="2">
											DATA RESERVASI
										</td>
									</tr>
									<tr>
										<td>Nama Ruangan</td>
										<td><?php echo $reservasi['catalog_name'] ?></td>
									</tr>
									<tr>
										<td>Jenis Pemakaian</td>
										<td><?php echo $reservasi['reservasi_type'] ?></td>
									</tr>
									<tr>
										<td>Tanggal Pinjam</td>
										<td><?php echo pretty_date($reservasi['reservasi_date_start'], 'd F Y', false) . ' s.d. ' . pretty_date($reservasi['reservasi_date_end'], 'd F Y', false) ?></td>
									</tr>
									<tr>
										<td>Estimasi Jumlah Orang Yang Datang / Panitia</td>
										<td><?php echo $reservasi['reservasi_attendance'] . ' Orang' ?></td>
									</tr>
									<tr>
										<td>Kebutuhan Lainnya</td>
										<td><?php echo $reservasi['reservasi_other_request'] ?></td>
									</tr>
									<?php if (!is_null($reservasi['reservasi_request_file'])): ?>
										<tr>
											<td>Scan File Permohonan Pinjam Ruangan</td>
											<td>
												<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_request_file']) ?>"><?php echo $reservasi['reservasi_request_file'] ?></a>
											</td>
										</tr>
									<?php endif ?>
									<?php if (!is_null($reservasi['reservasi_proposal_file'])): ?>
										<tr>
											<td>Scan File Proposal</td>
											<td>
												<a target="_blank" href="<?php echo reservasi_file($reservasi['reservasi_id'], $reservasi['reservasi_proposal_file']) ?>"><?php echo $reservasi['reservasi_proposal_file'] ?></a>
											</td>
										</tr>
									<?php endif ?>
									<tr>
										<td colspan="2">
											PEMOHON
										</td>
									</tr>
									<tr>
										<td>Nama</td>
										<td><?php echo $reservasi['customer_full_name'] ?></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><?php echo $reservasi['customer_email'] ?></td>
									</tr>
									<tr>
										<td>Telepon</td>
										<td><?php echo $reservasi['customer_phone'] ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $reservasi['customer_address'] ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-4">
						<div class="table-responsive">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td>Status</td>
										<td><?php echo $reservasi['status_name'] ?></td>
									</tr>
									<tr>
										<td>Posisi</td>
										<td><?php echo $reservasi['position_name'] ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Tanggal</th>
										<th>Dari</th>
										<th>Status</th>
										<th>Pesan</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($logs as $log): ?>
										<tr>
											<td><?php echo pretty_date($log['log_date'], 'd F Y H:i:s', false) ?></td>
											<td><?php echo $log['user_full_name'] ?></td>
											<td><?php echo $log['status_name'] ?></td>
											<td><?php echo $log['log_message'] ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalKabag1">
	<div class="modal-dialog">
		<?php echo form_open(current_url()); ?>

		<?php
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		?>

		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

		<input type="hidden" name="inputDisposisi" value="1">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Respon Permohonan Reservasi</h4>
			</div>
			<div class="modal-body">
				<label>Status Reservasi</label>
				<select name="inputStatus" class="form-control">
					<option value="<?php echo STATUS_PROCESS ?>">Diizinkan (Menunggu Persetujuan Kepala Museum)</option>
					<option value="<?php echo STATUS_REJECTED ?>">Tolak Reservasi</option>
				</select>
				<label>Pesan</label>
				<textarea class="form-control" name="inputMessage"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="modalKamus">
	<div class="modal-dialog">
		<?php echo form_open(current_url()); ?>

		<?php
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		?>

		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

		<input type="hidden" name="inputDisposisiFromKamus" value="1">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Respon Permohonan Reservasi</h4>
			</div>
			<div class="modal-body">
				<label>Status Reservasi</label>
				<select name="inputStatus" class="form-control">
					<option value="<?php echo STATUS_PROCESS ?>">Diizinkan (Menunggu Surat Persetujuan KASUBAG TU)</option>
					<option value="<?php echo STATUS_REJECTED ?>">Tolak Reservasi</option>
				</select>
				<label>Pesan</label>
				<textarea class="form-control" name="inputMessage"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="modalKabag2">
	<div class="modal-dialog">
		<?php echo form_open_multipart(current_url()); ?>

		<?php
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		?>

		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

		<input type="hidden" name="inputKabag2" value="1">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Respon Permohonan Reservasi</h4>
			</div>
			<div class="modal-body">
				<label>Pesan</label>
				<textarea class="form-control" name="inputMessage"></textarea>
				<br>
				<?php if ($reservasi['reservasi_status_status_id'] ==  STATUS_REJECTED): ?>
					<label>Scan Surat Penolakan</label>
					<?php else: ?>
						<label>Scan Surat Persetujuan</label>
					<?php endif ?>
					<input type="file" name="inputScan" class="form-control">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>

	<div class="modal fade" id="modalKabagLastStep">
		<div class="modal-dialog">
			<?php echo form_open_multipart(current_url()); ?>

			<?php
			$csrf = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			?>

			<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

			<input type="hidden" name="inputKabagLastStep" value="1">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Respon Permohonan Reservasi</h4>
				</div>
				<div class="modal-body">
					<label>Pesan</label>
					<textarea class="form-control" name="inputMessage"></textarea>
					<br>
					<?php if ($reservasi['reservasi_status_status_id'] ==  STATUS_REJECTED): ?>
						<label>Scan Surat Penolakan</label>
						<?php else: ?>
							<label>Scan Surat Persetujuan</label>
						<?php endif ?>
						<input type="file" name="inputScan" class="form-control">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="modal fade" id="modalDelete">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Hapus Reservasi</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger text-center">
							Anda yakin akan menghapus reservasi ini?
						</div>
					</div>
					<?php echo form_open('admin/reservasi/delete/' . $reservasi['reservasi_id'] ); ?>
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