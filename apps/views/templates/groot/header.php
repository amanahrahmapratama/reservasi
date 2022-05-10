<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="artikulpi">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Reservasi Ruangan <?php echo isset($title) ? ' | ' . $title : null;?></title>

	<script type="text/javascript" src="<?php echo media_url('frontend/js/vendor/jquery.min.js') ?>"></script>
	
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/linearicons.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/bootstrap.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/magnific-popup.css') ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/css/lightgallery.min.css">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/nice-select.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/animate.min.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/owl.carousel.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/main.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('fullcalendar/fullcalendar.min.css') ?>">
	<link rel="stylesheet" href="<?php echo media_url('frontend/css/bootstrap-datepicker.min.css') ?>">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129697800-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-129697800-1');
	</script>

</head>

<body>
	<header id="header" id="home" style="box-shadow: 0px 1px 15px #999;">
		<div class="container main-menu">
			<div class="row align-items-center justify-content-between d-flex">
				<div id="logo">
					<h3><a href="<?php echo site_url('/') ?>" class="text-dark">Reservasi</a></h3>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li class="<?php echo ($this->uri->segment(0)=='' AND $this->uri->segment(1)=='') ? 'menu-active' : '' ?>"><a href="<?php echo site_url('/') ?>">Beranda</a></li>
						<li class="<?php echo ($this->uri->segment(1)=='catalog') ? 'menu-active' : '' ?>"><a href="<?php echo site_url('catalog') ?>">Ruangan</a></li>
						<li class="<?php echo ($this->uri->segment(1)=='posting') ? 'menu-active' : '' ?>"><a href="<?php echo site_url('posting') ?>">Ulasan</a></li>
						<li class="<?php echo ($this->uri->segment(1)=='faq') ? 'menu-active' : '' ?>"><a href="<?php echo site_url('faq') ?>">Faq</a></li>
						<?php if ($this->session->userdata('logged_customer')) { ?>
							<li class="menu-has-children"><a href="#">Akun Saya</a>
								<ul>
									<li><a href="<?php echo site_url('user') ?>">Profil</a></li>
									<li><a href="<?php echo site_url('user/reservasi') ?>">Reservasi</a></li>
									<li><a href="<?php echo site_url('auth/logout') ?>">Keluar</a></li>
								</ul>
							</li>
						<?php } else { ?>
							<li class="<?php echo ($this->uri->segment(2)=='login') ? 'menu-active' : '' ?>"><a href="<?php echo site_url('auth/login') ?>">Login</a></li>
							<li class="<?php echo ($this->uri->segment(2)=='register') ? 'menu-active' : '' ?>"><a href="<?php echo site_url('auth/register') ?>">Daftar</a></li>
						<?php } ?>
					</ul>
				</nav>
			</div>
		</div>
	</header>
