<section class="top-category-widget-area section-gap mb-20">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="main-title text-center mb-0">
					<h1>Seluruh Ruangan</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<?php foreach ($catalog as $key): ?>
				<div class="col-lg-4 mt-4">
					<div class="single-cat-widget">
						<div class="content relative">
							<div class="overlay overlay-bg"></div>
							<a href="<?php echo catalog_url($key) ?>">
								<div class="thumb">
									<?php if(isset($key['catalog_image'])) { ?>
									<div class="imgLiquidFill imgLiquid" style="width:auto; height:230px;">
										<img class="content-image img-fluid d-block mx-auto" src="<?php echo upload_url($key['catalog_image']) ?>">
									</div>
								<?php } else { ?>
									<div class="imgLiquidFill imgLiquid" style="width:auto; height:230px;">
										<img class="content-image img-fluid d-block mx-auto" src="<?php echo media_url('frontend/img/missing_image.png') ?>">
									</div>
								<?php } ?>
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
		<div class="text-center">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</section>