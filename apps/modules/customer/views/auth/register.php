<section class="contact-page-area section-gap">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center">
					<h1>Daftar</h1>
				</div>
			</div>
		</div>
		<div class="row mb-10">
			<div class="col-md-6 offset-md-3">
				<?php echo validation_errors() ?>

				<form class="form-area contact-form text-right" action="<?php echo base_url(uri_string());?>" method="POST">
					<?php $this->load->view('widgets/csrf');?>

					<input class="common-input mb-20 form-control" type="text" name="customer_full_name" id="name" placeholder="Nama Lengkap *" required>

					<input class="common-input mb-20 form-control" type="text" name="customer_phone" id="phone" placeholder="No Telepon *" required>

					<input class="common-input mb-20 form-control" name="customer_email" type="email" id="email" placeholder="Alamat Email *" required>

					<input class="common-input mb-20 form-control" name="customer_password" id="password" type="password" placeholder="Kata Sandi *" required>

					<input class="common-input mb-20 form-control" name="passconf" id="passconf" type="password" placeholder="Konfirmasi Kata Sandi *" required>

					<textarea class="common-input mb-20 form-control" name="customer_address" id="address" placeholder="Alamat"></textarea>
					<button type="submit" class="primary-btn primary float-left">Kirim</button>
					<p>Sudah punya akun? <a href="<?php echo site_url('auth/login') ?>">Masuk</a></p>
				</form>
			</div>

		</div>
	</section>