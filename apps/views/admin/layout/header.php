<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($title) ? $title : null ?></title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link href="<?php echo media_url('css/style.min.css');?>" rel="stylesheet" type="text/css" media="screen" />
    <link rel="shortcut icon" href="<?php echo media_url('img/favicon-portal.png');?>" type="Image">
    
    <link href="<?php echo media_url('css/pace-theme-flash.min.css');?>" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo media_url('css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo media_url('css/bootstrap-theme.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo media_url('css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo media_url('css/animate.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo media_url('css/jquery.scrollbar.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo media_url('css/jquery-ui.min.css');?>" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo media_url('css/webarch.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo media_url('css/admin.css');?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo media_url('js/jquery-1.11.3.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo media_url('js/jquery-ui.min.js');?>" type="text/javascript"></script>
</head>
<body class="">
    <div class="header navbar navbar-inverse ">
        <div class="navbar-inner">
            <div class="header-seperation">
                <ul class="nav pull-left notifcation-center visible-xs visible-sm">
                    <li class="dropdown">
                        <a href="#main-menu" data-webarch="toggle-left-side">
                            <i class="material-icons">menu</i>
                        </a>
                    </li>
                </ul>
                <a href="<?php echo site_url('admin');?>">
<!--                     <img src="<?php echo media_url('img/text_portal.png');?>" class="logo img-responsive" alt=""
                    data-src="<?php echo media_url('img/text_portal.png');?>"
                    data-src-retina="<?php echo media_url('img/text_portal.png');?>" width="220px"  /> -->
                </a>

            </div>
            <div class="header-quick-nav">
                <div class="pull-left">
                    <ul class="nav quick-section">
                        <li class="quicklinks">
                            <a href="#" class="" id="layout-condensed-toggle">
                                <i class="material-icons">menu</i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav quick-section">

                        <li class="m-r-10 input-prepend inside search-form no-boarder">
                            <span class="add-on"> <i class="material-icons">search</i></span>
                            <input name="" type="text" class="no-boarder " placeholder="Search" style="width:250px;">
                        </li>
                    </ul>
                </div>

                <div id="notification-list" style="display:none">
                    <div style="width:300px">
                        <div class="notification-messages info">
                            <div class="user-profile">
                                <img src="<?php echo media_url('img/profiles/d.jpg');?>" alt=""
                                data-src="<?php echo media_url('img/profiles/d.jpg');?>"
                                data-src-retina="<?php echo media_url('img/profiles/d2x.jpg');?>"
                                width="35" height="35">
                            </div>
                            <div class="message-wrapper">
                                <div class="heading">
                                    Resha antoni - Pembelian Baru
                                </div>
                                <div class="description">
                                    2 Snack, 3 sambal, 2 baju
                                </div>
                                <div class="date pull-left">
                                    A min ago
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="pull-right">

                    <ul class="nav quick-section ">
                        <li class="quicklinks">
                            <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                                <i class="material-icons">tune</i>
                            </a>
                            <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                                <li>
                                    <a href="<?php echo site_url('admin/profile');?>"> My Account</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('admin/profile/cpw');?>"> Change Password</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo site_url('user/auth/logout');?>" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                                        <i class="material-icons">power_settings_new</i>&nbsp;&nbsp;Log Out
                                    </a>

                                    <form id="form-logout" action="<?php echo site_url('user/auth/logout') ?>" method="POST" style="display: none;">
                                        <?php $this->load->view('widgets/csrf');?>
                                        <input type="hidden" name="location" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
