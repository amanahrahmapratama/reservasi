<div class="list-group">
	<?php if ($this->session->userdata('logged_customer')): ?>
		<a href="<?php echo site_url('user') ?>" class="list-group-item list-group-item-action <?php echo $this->uri->segment(1) == 'user' && $this->uri->segment(2) == '' ? 'active' : '' ?>">
			<i class="lnr lnr-user"></i> Profil Saya
		</a>
		<a href="<?php echo site_url('user/reservasi') ?>" class="list-group-item list-group-item-action <?php echo $this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'reservasi' ? 'active' : '' ?>">
			<i class="lnr lnr-calendar-full"></i> Reservasi Saya
		</a>
	<?php endif ?>

</div>

<div class="mt-3">
	<!-- <?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?php echo $this->session->flashdata('success') ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php endif ?> -->
	</div>