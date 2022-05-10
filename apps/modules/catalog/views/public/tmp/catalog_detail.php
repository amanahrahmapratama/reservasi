<section class="post-content-area single-post-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 posts-list">
				
				<div class="single-post row">
					<div class="col-lg-12">
						<div id="myCarousel" class="carousel slide">
							<!-- main slider carousel items -->
							<div class="carousel-inner">
								<div class="active item carousel-item" data-slide-number="0">
									<?php if(isset($catalog['catalog_image'])) { ?>
										<img src="<?php echo upload_url($catalog['catalog_image']) ?>" class="img-fluid">
									<?php } else { ?>
										<img src="<?php echo media_url('frontend/img/missing_image.png') ?>" class="img-fluid" style="height: 450px">
									<?php } ?>
								</div>
								<?php $no = 1 ?>
								<?php foreach ($image as $key): ?>
									<div class="item carousel-item" data-slide-number="<?php echo $no ?>">
										<?php if(isset($key['catalog_image_path'])) { ?>
											<img src="<?php echo upload_url($key['catalog_image_path']) ?>" class="img-fluid">
										<?php } ?>
									</div>
									<?php $no++ ?>
								<?php endforeach ?>

							</div>
							<!-- main slider carousel nav controls -->

							<ul class="carousel-indicators list-inline">
								<li class="list-inline-item">
									<a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#myCarousel">
										<?php if(isset($catalog['catalog_image'])) { ?>
											<img src="<?php echo upload_url($catalog['catalog_image']) ?>" class="img-fluid" style="max-height: 80px; max-width: 80px;">
										<?php } else { ?>
											<img src="<?php echo media_url('frontend/img/missing_image.png') ?>" style="max-height: 80px; max-width: 80px;">
										<?php } ?>
									</a>
								</li>
								<?php $no = 1 ?>
								<?php foreach ($image as $key): ?>
									<li class="list-inline-item">
										<a id="carousel-selector-<?php echo $no ?>" data-slide-to="<?php echo $no ?>" data-target="#myCarousel">
											<img src="<?php echo upload_url($catalog['catalog_image']) ?>" class="img-fluid" style="max-height: 80px; max-width: 80px;">
										</a>
									</li>
									<?php $no++ ?>
								<?php endforeach ?>
							</ul>
						</div>

					</div>
					<div class="col-lg-9 col-md-9">
						<h3 class="mt-3"><?php echo $catalog['catalog_name']; ?></h3>
					</div>
					<div class="col-lg-12">
						<div class="quotes mt-0">
							<?php echo $catalog['catalog_desc'] ?>
						</div>
						<br>
						<h3>Jadwal Pemakaian Ruangan</h3>
						<div id="calendar"></div>
						<a href="<?php echo site_url('catalog') ?>" class="btn btn-back btn-secondary mt-3">Kembali</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 sidebar-widgets">
				<div class="widget-wrap">
					<div class="single-sidebar-widget popular-post-widget">
						<?php if (!$this->session->userdata('logged_customer')): ?>
							<div class="alert alert-success text-center">Anda harus login untuk melakukan reservasi ruangan. <span class="text-danger"><a href="<?php echo site_url('auth/login') ?>">Login / Register</a></span></div>
							<?php else: ?>
								<center>
									<a href="<?php echo site_url('reservasi/index/' . $catalog['catalog_id'] ) ?>" class="btn btn-success btn-reserv btn-block">Reservasi Sekarang</a>
								</center>
							<?php endif ?>
						</div>
						<div class="single-sidebar-widget popular-post-widget">
							<h4 class="popular-title">Ruangan Lainnya</h4>
							<div class="popular-post-list">
								<?php foreach ($catalog_other as $key): ?>
									<div class="single-post-list d-flex flex-row align-items-center">
										<div class="thumb">
											<?php if(isset($key['catalog_image'])) { ?>
												<img class="img-fluid img-thumbnail" src="<?php echo upload_url($key['catalog_image']) ?>" alt="" style="height: 100px;width: 200px;">
											<?php } else { ?>
												<img class="img-fluid img-thumbnail" src="<?php echo template_media_url('img/content/review/review_post_1.jpg') ?>" alt="" style="height: 100px;width: 200px;">
											<?php } ?>
										</div>
										<div class="details">
											<a href="<?php echo catalog_url($key) ?>"><h6><?php echo $key['catalog_name'] ?></h6></a>
											<p><?php echo pretty_date($key['catalog_last_update'],'d-M-y',false) ?></p>
										</div>
									</div>
								<?php endforeach ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript">
		$(document).ready(function() {

			$('#calendar').fullCalendar({
				defaultDate: "<?php echo date('Y-m-d') ?>",
				locale: 'id',
				editable: false,
				eventLimit: true, 
				events: <?php echo $date ?>
			});

		});

	</script>
