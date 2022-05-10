<div class="nav-logo">
	<div class="container">
		<div class="logo-kiri">
			<a href="<?php echo site_url();?>" class="logo">
				<img src="<?php echo base_url('uploads/meta/'.$img_logo) ?>" alt="" class="img-responsive img-logo logo__img" hight="30px">
				<h1 class="text-logo"><?php echo $app_name ?></h1>
			</a>
		</div>
		<div class="navigation__column right">

		</div>
	</div>
</div>

<header class="nav ">
	<div class="nav__holder nav--sticky">
		<div class="container relative">
			<div class="flex-parent">
				<button class="nav-icon-toggle nav-mobile" id="nav-icon-toggle" aria-label="Open side menu">
					<span class="nav-icon-toggle__box ">
						<span class="nav-icon-toggle__inner"></span>
					</span>
				</button>
				<nav class="flex-child nav__wrap d-none d-lg-block">
					<ul class="nav__menu">
						<li class="<?php echo $this->uri->segment(1) == '' ? 'active': '' ?>">
							<a href="<?php echo site_url() ?>">Beranda</a>
						</li>
						<li class="<?php echo $this->uri->segment(1) == 'catalog' ? 'active': '' ?>">
							<a href="<?php echo site_url('catalog') ?>">Ruangan</a>
						</li>
						<li class="<?php echo $this->uri->segment(1) == 'about' ? 'active': '' ?>">
							<a href="<?php echo site_url('about') ?>">Tentang Kami</a>
						</li>
						<li class="<?php echo $this->uri->segment(1) == 'work' ? 'active': '' ?>">
							<a href="<?php echo site_url('work') ?>">Cara Kerja</a>
						</li>

						<li class="<?php echo $this->uri->segment(1) == 'faq' ? 'active': '' ?>">
							<a href="<?php echo site_url('faq') ?>">FAQ</a>
						</li>
						<?php if ($this->session->userdata('logged_customer')): ?>
							<li class="nav__dropdown <?php echo $this->uri->segment(1) == 'user' && $this->uri->segment(2) != 'cart' ? 'active' : '' ?>">
								<a href="<?php echo site_url('user') ?>">Akun Saya</a>
								<ul class="nav__dropdown-menu">
									<li>
										<a href="<?php echo site_url('user') ?>">Profil</a>
									</li>
									<li>
										<a href="<?php echo site_url('user/reservasi') ?>">Reservasi</a>
									</li>
									<li>
										<a href="<?php echo site_url('auth/logout') ?>" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Keluar</a>

										<form id="form-logout" action="<?php echo site_url('auth/logout') ?>" method="POST" style="display: none;">
											<?php $this->load->view('widgets/csrf');?>
											<input type="hidden" name="location" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
										</form>
									</li>
								</ul>
							</li>
						<?php endif ?>
					</ul>
				</nav>

				<div class="nav__right">
					<div class="nav__right-item nav__search">
						<a href="#" class="nav__search-trigger" id="nav__search-trigger">
							<i class="ui-search nav__search-trigger-icon"></i>
						</a>
						<div class="nav__search-box" id="nav__search-box">
							<form action="<?php echo site_url('search') ?>" method="GET" class="nav__search-form">
								<input type="text" name="q" placeholder="Cari artikel..." class="nav__search-input" required>
								<button type="submit" class="search-button btn btn-lg btn-color btn-button">
									<i class="ui-search nav__search-icon"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
