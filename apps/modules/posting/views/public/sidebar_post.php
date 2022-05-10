<div class="col-lg-4 sidebar-widgets">
	<div class="widget-wrap">
		<div class="single-sidebar-widget search-widget">
			<form class="search-form" action="<?php echo site_url('posting') ?>">
				<input placeholder="Cari Ulasan" name="q" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Cari Ulasan'">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		
		<div class="single-sidebar-widget popular-post-widget">
			<h4 class="popular-title">Ulasan Terbaru</h4>
			<div class="popular-post-list">
				<?php foreach ($posting_other as $key): ?>
					<div class="single-post-list d-flex flex-row align-items-center">
						<div class="details">
							<a href="<?php echo posting_url($key) ?>"><h6><?php echo $key['posting_title']; ?></h6></a>
							<p><?php echo pretty_date($key['posting_created_date'], 'd F Y', FALSE); ?> </p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
<!-- 		<div class="single-sidebar-widget post-category-widget">
			<h4 class="category-title">Post Catgories</h4>
			<ul class="cat-list">
				<?php foreach($category as $row): ?>
					<li>
						<a href="<?php echo site_url('posting/category/'.$row['posting_category_id']) ?>" class="d-flex justify-content-between">
							<p><?php echo $row['posting_category_name'] ?></p>
							<p>37</p>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div> -->
	</div>
</div>