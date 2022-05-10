
<?php 
$CI =& get_instance();
$CI->load->model(array('reservasi/Reservasi_model')); 
$new = $CI->Reservasi_model->get(array('status_id' => STATUS_NEW));
?>

<div class="page-container row-fluid">
    <div class="page-sidebar " id="main-menu">
        <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
            <div class="user-info-wrapper sm">
                <div class="profile-wrapper sm">
                    <img src="<?php echo media_url('img/profiles/bd.jpg');?>" alt=""
                    data-src="<?php echo media_url('img/profiles/bd.jpg');?>"
                    data-src-retina="<?php echo media_url('img/profiles/bd2x.jpg');?>"
                    width="69" height="69" />
                    <div class="availability-bubble online"></div>
                </div>
                <div class="user-info sm">
                    <div class="username"><?php echo $this->session->userdata('user_full_name_admin') ?></div>
                    <div class="status"><?php echo $this->session->userdata('user_email_admin') ?></div>
                </div>
            </div>

            <p class="menu-title sm">MAIN MENU</p>
            <ul>
                <li class="start <?php if($this->router->fetch_class() == 'dashboard_admin') echo 'active';?>">
                    <a href="<?php echo site_url('admin');?>">
                        <i class="material-icons">home</i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li class="<?php if($this->router->fetch_class() == 'reservasi_admin') echo 'active';?>">
                    <a href="#">
                        <i class="material-icons">layers</i>
                        <span class="title">Reservasi</span>
                        <span class="badge label label-danger"><?php echo count($new) ?></span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo site_url('admin/reservasi');?>">Daftar Reservasi</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('admin/reservasi/add');?>">Tambah Reservasi</a>
                        </li>
                    </ul>
                </li>

                <li class="start <?php if($this->router->fetch_class() == 'calendar_admin') echo 'active';?>">
                    <a href="<?php echo site_url('admin/calendar');?>">
                        <i class="material-icons">calendar_today</i>
                        <span class="title">Kalender Reservasi</span>
                    </a>
                </li>

                <li class="<?php if($this->router->fetch_class() == 'catalog_admin' || $this->router->fetch_class() == 'brand_admin') echo 'active';?>">
                    <a href="#">
                        <i class="material-icons">layers</i>
                        <span class="title">Ruangan</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo site_url('admin/catalog');?>">Daftar Ruangan</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('admin/catalog/add');?>">Tambah Ruangan</a>
                        </li>
<!--                         <li>
                            <a href="<?php echo site_url('admin/catalog/category');?>">Kategori Produk</a>
                        </li> -->
                    </ul>
                </li>

                <li class="<?php if($this->router->fetch_class() == 'posting_admin') echo 'active';?>">
                    <a href="#">
                        <i class="material-icons">description</i>
                        <span class="title">Ulasan</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo site_url('admin/posting');?>">Daftar Ulasan</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('admin/posting/add');?>">Tambah Ulasan</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('admin/posting/category');?>">Kategori Ulasan</a>
                        </li>
                    </ul>
                </li>

                <li class="<?php if($this->router->fetch_class() == 'sliders_admin') echo 'active';?>">
                    <a href="#">
                        <i class="material-icons">collections</i>
                        <span class="title">Slider</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo site_url('admin/sliders');?>">Daftar Slider</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('admin/sliders/add');?>">Tambah Slider</a>
                        </li>
                    </ul>
                </li>

                <li class="<?php if($this->router->fetch_class() == 'customer_admin') echo 'active';?>">
                    <a href="<?php echo site_url('admin/customer');?>">
                        <i class="material-icons">supervisor_account</i>
                        <span class="title">Customer</span>
                    </a>
                </li>

                <li class="<?php if($this->router->fetch_class() == 'page_admin') echo 'active';?>">
                    <a href="<?php echo site_url('admin/page');?>">
                        <i class="material-icons">pages</i>
                        <span class="title">Halaman Statis</span>
                    </a>
                </li>

                <?php if ($this->session->userdata('user_role_admin') == USER_ADMIN): ?>


                    <li class="<?php if($this->router->fetch_class() == 'user_admin') echo 'active';?>">
                        <a href="<?php echo site_url('admin/user');?>">
                            <i class="material-icons">account_box</i>
                            <span class="title">Pengguna</span>
                        </a>
                    </li>

<!--                     <li class="<?php if($this->router->fetch_class() == 'setting_admin') echo 'active';?>">
                        <a href="#">
                            <i class="material-icons">settings</i>
                            <span class="title">Settings</span>
                            <span class="arrow"></span>
                        </a>

                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo site_url('admin/setting');?>">General</a>
                            </li>
                             <li>
                                <a href="<?php echo site_url('admin/setting/email');?>">Email</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/setting/image');?>">Image</a>
                            </li> 
                        </ul>
                    </li> -->

                <?php endif ?>

                <li class="<?php if($this->router->fetch_class() == 'activity_log_admin') echo 'active';?>">
                    <a href="<?php echo site_url('admin/activity_log');?>">
                        <i class="material-icons">history</i>
                        <span class="title">Log Aktivitas</span>
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
