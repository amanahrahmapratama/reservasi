<div class=" bg-breadcrumbs">
	<div class="container">
		<ul class="breadcrumbs">
			<li class="breadcrumbs__item">
				<a href="<?php echo site_url() ?>" class="breadcrumbs__url">Home</a>
			</li>
			<li class="breadcrumbs__item breadcrumbs__item--current">
				<?php echo $title; ?>
			</li>
		</ul>
	</div>
</div>


<div class="main-container container" id="main-container">
	<div class="blog__content mb-72 ">
		<div class="row justify-content-left">
			<div class="col-lg-8">
				<div class="entry__article">
					<h1 class="page-title"><?php echo $title; ?> Portal Bumdes</h1>
					<p>
						Portal BUMDes adalah portal yang ditujukan untuk mendukung perkembangan BUMDes di 227 desa di Kabupaten Musi Banyuasin. Kabupaten Musi Banyuasin memiliki komitmen yang kuat untuk mendukung tumbuh dan berkembangkan BUMDes yang menjadi pendorong pertumbuhan aktivitas ekonomi desa.
					</p>

					<p>
						Walaupun pada perjalanan pengembangan BUMDes di seluruh Kabupaten Musi Banyuasin mengalami pasang surut, namun bukan berarti dukungan terhadap perkembangan BUMDes juga ikut surut. Pembentukan Portal BUMDes ini adalah salah satu bentuk komitmen pemerintah Kabupaten Musi Banyuasin untuk terus mendorong pertumbuhan dan perkembangan BUMDes di wilayah Kabupaten Musi Banyuasin pada khususya, dan BUMDes di seluruh Indonesia pada umumnya.
					</p>

					<p>
						Portal ini memuat data dan informasi yang berkaitan dengan pertumbuhan dan perkembangan dari setiap BUMDes di wilayah Kabupaten Musi Banyuasin. Misalnya data-data mengenai jumlah penjualan yang sudah dilakukan, berapa banyak produk yang dihasilkan, dan data-data penjualan lainnya. Menampilkan data-data ini bertujuan agar Portal BUMDes bisa menjadi alat untuk mengukur dan memonitor perkembangan setiap BUMDes yang ada di Kabupaten Musi Banyuasin.
					</p>

					<p>
						Selain itu, tujuan kedua, portal ini juga berfungsi untuk pertukaran informasi sehingga bisa saling menginspirasi dari setiap BUMDes. Ide-ide dan solusi-solusi diliput dalam portal ini sehingga bisa menjadi inspirasi dari setiap masalah yang dihadapi. Selain itu, pertukaran informasi ini berfungsi untuk melakukan membentuk kerjasama antar BUMDes, karena peluang-peluang strategis bisa tercipta dari saling mengenalnya karakter setiap BUMDes.
					</p>

					<p>
						Tujuan terakhir, adalah Portal BUMDes bisa menjadi etalase produk dari semua BUMDes yang ada. Masyarakat umum bisa melakukan pemesanan dan pembelian dari produk-produk yang ditampilkan dalam portal ini. Dengan demikian, portal ini diharapkan membuka pintu-pintu penjualan kepada masyarakat luas, tidak hanya di dalam Kabupaten Musi Banyuasin, namun juga dari masyarakat luas.
					</p>

					<p>
						Dengan tujuan-tujuan tersebut, berarti Portal BUMDes ini melibatkan semua pengelola BUMDes yang ada di Kabupaten Musi Banyuasin untuk secara aktif terlibat dalam pengelolaan Portal ini. Setiap BUMDes memiliki akun sendiri dalam portal ini yang bisa dikelola secara mandiri untuk menampilkan data-data penjualan, mengisi informasi seputar BUMDes mereka, serta secara mandiri mampu menerima order dari masyarakat umum yang berkunjung pada portal ini.
					</p>

					<p>
						Secara khusus, Portal BUMDes ini didesain dan dikembangkan oleh Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Musi Banyuasin.
					</p>
				</div>
			</div>
			<aside class="col-lg-4 sidebar sidebar--1 sidebar--right">
				<aside class="widget widget-rating-posts mt-72">
					<h4 class="widget-title">Berita Populer</h4>
					<?php foreach ($popularNews as $key): ?>
					<article class="entry">
						<div class="entry__img-holder">
							<a href="<?php echo posting_url($key) ?>">
								<div class="thumb-container thumb-60">
									<?php if ($key['posting_image'] != NULL): ?>
										<img data-src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" class="entry__img lazyload" alt="">
									<?php else: ?>
										<img data-src="<?php echo template_media_url('img/content/review/review_post_1.jpg') ?>" src="<?php echo template_media_url('img/empty.png') ?>" class="entry__img lazyload" alt="">
									<?php endif ?>
								</div>
							</a>
						</div>

						<div class="entry__body">
							<div class="entry__header">
								<h2 class="entry__title">
									<a href="<?php echo posting_url($key) ?>"><?php echo $key['posting_title'] ?></a>
								</h2>
								<ul class="entry__meta">
									<li class="entry__meta-author">
										<span>by</span>
										<a href="<?php echo posting_url($key) ?>"><?php echo $key['user_name']; ?></a>
									</li>
									<li class="entry__meta-date">
										<?php echo pretty_date($key['posting_created_date'], 'd M Y', FALSE) ?>
									</li>
								</ul>
							</div>
						</div>
					</article>
					<?php endforeach ?>
				</aside>
				<aside class="widget widget_categories ">
					<h4 class="widget-title">Kategori</h4>
					<ul>
						<?php foreach ($category as $key): ?>
							<li><a href="<?php echo site_url('posting/category/'.$key['posting_category_id']) ?>"><?php echo $key['posting_category_name']; ?></a></li>
						<?php endforeach ?>
					</ul>
				</aside>
			</aside>
		</div>
	</div>
</div>
