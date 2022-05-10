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
				<?php echo validation_errors() ?>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="edit" aria-selected="true">Edit Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="pass-tab" data-toggle="tab" href="#pass" role="tab" aria-controls="pass" aria-selected="false">Ganti Password</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active mt-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<?php if ($user['customer_full_name'] == '' OR $user['customer_phone'] == '' OR $user['customer_address'] == ''): ?>

							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								Lengkapi data anda.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif ?>

						<div class="tabel-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td>Nama Lengkap</td>
										<td><?php echo $user['customer_full_name']; ?></td>
									</tr>
									<tr>
										<td>No Telepon</td>
										<td><?php echo $user['customer_phone']; ?></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><?php echo $user['customer_email']; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $user['customer_address']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade mt-3" id="edit" role="tabpanel" aria-labelledby="edit-tab">
						<?php echo form_open_multipart(current_url(), array('class' => "form-area contact-form text-right")); ?>
						<input type="hidden" name="edit" value="1">
						<input type="text" name="inputName" id="name" placeholder="Nama Lengkap" value="<?php echo $user['customer_full_name'] ?>" class="form-control common-input mb-20" required>

						<input type="text" name="inputHp" id="phone" placeholder="No Telepon" value="<?php echo $user['customer_phone'] ?>" class="form-control common-input mb-20" required>

						<input name="inputEmail" type="email" id="email" placeholder="Email Address" value="<?php echo $user['customer_email'] ?>" class="form-control common-input mb-20" required>

						<textarea name="inputAlamat" class="form-control common-input mb-20" id="address" placeholder="Alamat"><?php echo $user['customer_address'] ?></textarea>

						<button type="submit" class="primary-btn primary float-left">Simpan</button>
						<?php echo form_close() ?>
					</div>
					<div class="tab-pane fade mt-3" id="pass" role="tabpanel" aria-labelledby="pass-tab">
						<?php echo form_open(current_url(),array('class' => "form-area contact-form text-right")); ?>
						<input type="hidden" name="cpw" value="1">
						<input name="inputPasswordOld" id="currentPassword" type="password" placeholder="Password Lama" class="form-control common-input mb-20" required>

						<input name="inputPassword" id="password" type="password" placeholder="Password Baru" class="form-control common-input mb-20" required>

						<input name="inputPasswordConf" id="passconf" type="password" placeholder="Konfirmasi Password" class="form-control common-input mb-20" required>

						<button type="submit" class="primary-btn primary float-left">Simpan</button>
						<?php echo form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

