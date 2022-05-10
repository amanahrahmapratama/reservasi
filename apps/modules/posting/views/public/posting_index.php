<section class="post-content-area mt-5 mb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 posts-list">
				<?php if (count($posting) == 0): ?>
					<div class="alert alert-success">
						Data tidak ditemukan
					</div>
				<?php endif ?>
				<?php foreach ($posting as $key): ?>
					<div class="single-post row">
						<div class="col-lg-3  col-md-3 meta-details">
							<ul class="tags">
								<li><a href="#"><?php echo $key['posting_category_name']; ?></a></li>
							</ul>
							<div class="user-details row">
								<p class="user-name col-lg-12 col-md-12 col-6"><?php echo $key['user_name']; ?> <span class="lnr lnr-user"></span></p>
								<p class="date col-lg-12 col-md-12 col-6"><?php echo pretty_date($key['posting_created_date'], 'd-M-Y', FALSE); ?> <span class="lnr lnr-calendar-full"></span></p>
								<p class="view col-lg-12 col-md-12 col-6"><a href="#"><?php echo $key['posting_viewer'] ?> Kali Dilihat</a> <span class="lnr lnr-eye"></span></p>
							</div>
						</div>
						<div class="col-lg-9 col-md-9 ">
							<div class="feature-img">
								<img class="img-fluid" src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" alt="">
							</div>
							<a class="posts-title" href="<?php echo posting_url($key); ?>"><h3><?php echo $key['posting_title']; ?></h3></a>
							<p class="excert">
								<?php echo strip_tags(character_limiter($key['posting_desc'], 150)) ?>
							</p>
							<a href="<?php echo posting_url($key); ?>" class="primary-btn">Lihat lebih rinci</a>
						</div>
					</div>
				<?php endforeach ?>


				<nav class="blog-pagination justify-content-center d-flex">
					<?php echo $this->pagination->create_links(); ?>
				</nav>
			</div>

			<?php $this->load->view('posting/public/sidebar_post'); ?>
		</div>
	</div>
</section>