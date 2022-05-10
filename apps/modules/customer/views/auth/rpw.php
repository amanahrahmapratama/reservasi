<section class="contact-page-area section-gap">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center">
					<h1>Atur Ulang Kata Sandi</h1>
				</div>
			</div>
		</div>
		<div class="row mb-30">
			<div class="col-md-6 offset-md-3">
				<?php if ($this->session->flashdata('failed')) { ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Maaf!</strong> Alamat Email atau Kata Sandi anda salah.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } ?>

				<?php if ($this->session->flashdata('register_success')) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Selamat!</strong> <?php echo $this->session->flashdata('register_success') ?>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } ?>
				<?php echo validation_errors() ?>
				<form class="form-area contact-form text-right" action="<?php echo current_query_string_url();?>" method="POST">
					<?php $this->load->view('widgets/csrf');?>
					<input name="password" class="common-input mb-20 form-control" id="password" type="password" placeholder="Kata Sandi Baru" required>
					<input name="passwordConf" class="common-input mb-20 form-control" id="password" type="password" placeholder="Ketik Ulang Kata Sandi" required>
					<button type="submit" class="primary-btn primary float-left">Atur Ulang Kata Sandi</button>
					<p>
						Belum punya akun? <a href="<?php echo site_url('auth/register') ?>">Daftar</a>
						|
						<a href="<?php echo site_url('auth/forgot') ?>">Lupa Password</a>
					</p>
				</div>
			</form>
		</div>
	</div>
</section>