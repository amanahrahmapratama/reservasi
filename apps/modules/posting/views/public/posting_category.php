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

<div class="main-container container" id="main-container">
    <div class="row">
        <!-- Posts -->
        <div class="col-lg-8 blog__content mb-72">
            <h1 class="page-title"><?php echo $title; ?></h1>

            <div class="row card-row">
                <?php foreach ($posting as $key): ?>
                    <div class="col-md-6">
                        <article class="entry card">
                            <div class="entry__img-holder card__img-holder">
                                <a href="<?php echo posting_url($key); ?>">
                                    <div class="thumb-container thumb-70">
                                        <?php if ($key['posting_image'] != ''): ?>
                                            <img data-src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" class="entry__img lazyload" alt="" />   
                                        <?php else: ?>
                                            <img data-src="<?php echo media_url('templates/groot/img/content/grid/grid_post_1.jpg') ?>" src="<?php echo media_url('templates/groot/img/empty.png') ?>" class="entry__img lazyload" alt="" />
                                        <?php endif ?>
                                    </div>
                                </a>
                                <a href="<?php echo site_url('posting/category/'.$key['posting_category_posting_category_id']) ?>" class="entry__meta-category entry__meta-category--label entry__meta-category--align-in-corner entry__meta-category--violet"><?php echo $key['posting_category_name']; ?></a>
                            </div>

                            <div class="entry__body card__body">
                                <div class="entry__header">

                                    <h2 class="entry__title">
                                        <a href="<?php echo posting_url($key) ?>"><?php echo $key['posting_title']; ?></a>
                                    </h2>
                                    <ul class="entry__meta">
                                        <li class="entry__meta-author">
                                            <span>by</span>
                                            <a href="<?php echo posting_url($key); ?>"><?php echo $key['user_name']; ?></a>
                                        </li>
                                        <li class="entry__meta-date">
                                            <?php echo pretty_date($key['posting_created_date'], 'd-m-Y', FALSE); ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="entry__excerpt">
                                    <p><?php echo $key['posting_short_desc'] ?></p>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- Pagination -->
            <nav class="pagination">
                <?php echo $this->pagination->create_links(); ?>
            </nav>
        </div> <!-- end posts -->

        <!-- Sidebar -->
        <aside class="col-lg-4 sidebar sidebar--right">
            <!-- Widget Popular Posts -->
            <aside class="widget widget-popular-posts">
                <h4 class="widget-title">Artikel Lainnya</h4>
                <ul class="post-list-small">
                    <?php foreach ($posting_other as $key): ?>
                        <li class="post-list-small__item">
                            <article class="post-list-small__entry clearfix">
                                <div class="post-list-small__img-holder">
                                    <div class="thumb-container thumb-100">
                                        <?php if ($key['posting_image'] != ''): ?>
                                            <a href="<?php echo posting_url($key) ?>">
                                                <img data-src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" src="<?php echo base_url('uploads/'.$key['posting_image']) ?>" alt="" class=" lazyload">
                                            </a>
                                        <?php else: ?>
                                            <a href="single-post.html">
                                                <img data-src="<?php echo media_url('templates/groot/img/content/post_small/post_small_1.jpg') ?>" src="<?php echo media_url('templates/groot/img/empty.png') ?>" alt="" class=" lazyload">
                                            </a>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="post-list-small__body">
                                    <h3 class="post-list-small__entry-title">
                                        <a href="<?php echo posting_url($key) ?>"><?php echo $key['posting_title']; ?></a>
                                    </h3>
                                    <ul class="entry__meta">
                                        <li class="entry__meta-author">
                                            <span>by</span>
                                            <a href="<?php echo posting_url($key) ?>"><?php echo $key['user_name'] ?></a>
                                        </li>
                                        <li class="entry__meta-date">
                                            <?php echo pretty_date($key['posting_created_date'], 'd-m-Y', FALSE); ?>
                                        </li>
                                    </ul>
                                </div>                  
                            </article>
                        </li>
                    <?php endforeach ?>
                </ul>           
            </aside> <!-- end widget popular posts -->

            <aside class="widget widget_categories">
                <h4 class="widget-title">Kategori Artikel</h4>
                <ul>
                    <?php foreach ($category as $key): ?>
                        <li><a href="<?php echo site_url('posting/category/'.$key['posting_category_id']) ?>"><?php echo $key['posting_category_name']; ?></a></li>
                    <?php endforeach ?>
                </ul>
            </aside>
        </aside> <!-- end sidebar -->
    </div>
</div>