<section class="" id="home">
	<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner" role="listbox">

			<?php $active = 'active' ?>
			<?php foreach ($sliders as $key): ?>
				<div class="carousel-item <?php echo $active ?>" style="background-image: url('<?php echo base_url('uploads/sliders/' . $key['slider_photo'] ) ?>')">
					<div class="caption d-none d-sm-block">
						<?php echo $key['slider_caption'] ?>
					</div>
				</div>
				<?php $active = null ?>
			<?php endforeach ?>

		</div>
		
	</div>
</section>
<section class="top-category-widget-area section-gap mb-20">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center">
					<h1>Mari Ke Museum</h1>
					<p>
						Kami terbuka pada masyarakat luas untuk menggunakan ruangan dalam Museum Kebangkitan Nasional.
					</p>
				</div>
			</div>
		</div>
		<div class="row">
			<?php foreach ($catalog as $key): ?>
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative">
							<div class="overlay overlay-bg"></div>
							<a href="<?php echo catalog_url($key) ?>">
								<div class="thumb">
									<div class="imgLiquidFill imgLiquid" style="width:auto; height:230px;">
										<img class="content-image img-fluid d-block mx-auto" src="<?php echo upload_url($key['catalog_image']) ?>">
									</div>
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase"><?php echo $key['catalog_name']; ?></h4>
									<span></span>
									<p><?php echo strip_tags(character_limiter($key['catalog_desc'],20)); ?></p>
								</div>
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="latest-blog-area section-gap">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center">
					<h1>Ulasan</h1>
					<p>
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<?php foreach ($posting as $key): ?>
				<div class="col-lg-3 col-md-6 single-blog">
					<a href="<?php echo posting_url($key); ?>">
						<div class="thumb">
							<?php if(isset($key['posting_image'])) { ?>
								<img class="img-fluid w-100" src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" alt="">
							<?php } else { ?>
								<img class="img-fluid w-100" src="<?php echo media_url('templates/groot/img/content/single/single_post_featured_img.jpg') ?>" alt="">
							<?php } ?>
						</div>
						<p class="date"><?php echo pretty_date($key['posting_created_date'], 'd M Y', FALSE); ?></p>
						<h4>
							<?php echo $key['posting_title']; ?>
						</h4>
						<p>
							<?php echo strip_tags(character_limiter($key['posting_desc'], 50)) ?>
						</p>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
