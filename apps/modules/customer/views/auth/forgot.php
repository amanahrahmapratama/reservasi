<section class="contact-page-area section-gap">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center">
					<h1>Lupa Kata Sandi</h1>
				</div>
			</div>
		</div>
		<div class="row mb-30">
			<div class="col-md-6 offset-md-3">
				<?php if ($this->session->flashdata('failed')) { ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Maaf!</strong> <?php echo $this->session->userdata('failed'); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } ?>

				<?php if ($this->session->flashdata('reset_success')) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Selamat!</strong> <?php echo $this->session->flashdata('reset_success') ?>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } ?>

				<form class="form-area contact-form text-right" action="<?php echo base_url(uri_string());?>" method="POST">
					<?php $this->load->view('widgets/csrf');?>
					<input name="email" class="common-input mb-20 form-control" type="email" placeholder="Alamat Email" required autofocus>
					<button type="submit" class="primary-btn primary float-left">Kirim</button>
					<p>Belum punya akun? <a href="<?php echo site_url('auth/register') ?>">Daftar</a></p>
				</div>
			</form>
		</div>
	</div>
</section>