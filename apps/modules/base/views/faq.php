<section class="post-content-area single-post-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 posts-list">
				<div class="single-post row">
					<div class="col-lg-3  col-md-3 meta-details">
						<ul class="tags">
							<li><a href="#"><?php echo $faq['page_name']; ?></a></li>
						</ul>
<!-- 						<div class="user-details row">
							<p class="user-name col-lg-12 col-md-12 col-6"><a href="#"><?php echo $posting['user_name']; ?></a> <span class="lnr lnr-user"></span></p>
							<p class="date col-lg-12 col-md-12 col-6"><a href="#"><?php echo pretty_date($posting['posting_created_date'], 'd-M-Y', FALSE); ?></a> <span class="lnr lnr-calendar-full"></span></p>
							<p class="view col-lg-12 col-md-12 col-6"><a href="#"><?php echo $posting['posting_viewer'] ?> Views</a> <span class="lnr lnr-eye"></span></p>
						</div> -->
					</div>
					<div class="col-lg-9 col-md-9">
						<a class="posts-title" href="#"><h3><?php echo $faq['page_name'] ?></h3></a>
						<?php echo $faq['page_content'] ?>
					</div>
				</div>
			</div>

			<?php $this->load->view('posting/public/sidebar_post'); ?>

		</div>
	</div>
</section>