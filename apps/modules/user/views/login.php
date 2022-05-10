<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>Login</title>

    <link rel="stylesheet" href="<?php echo media_url('css/login.min.css');?>">
    <link rel="stylesheet" href="<?php echo media_url('css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo media_url('css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo media_url('css/main.login.css');?>">
</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" method="POST" action="<?php echo base_url(uri_string());?>">
                    <?php $this->load->view('widgets/csrf');?>
                    <div class="sign-avatar">
                        <img src="<?php echo media_url('img/avatar-sign.png');?>" alt="">
                    </div>
                    <header class="sign-title">Masuk</header>

					<?php if ($this->session->flashdata('failed')) { ?>
						<div class="alert alert-danger alert-dismissible">
							<h5><i class="fa fa-ban"></i> Nama Pengguna atau Kata Sandi salah!</h5>
						</div>
					<?php } ?>

                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Nama Pengguna" autofocus />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Kata Sandi" />
                    </div>
                    <button type="submit" class="btn btn-rounded">Masuk</button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo media_url('js/jquery-1.11.3.min.js');?>"></script>
    <script src="<?php echo media_url('js/popper.min.js');?>"></script>
    <script src="<?php echo media_url('js/tether.min.js');?>"></script>
    <script src="<?php echo media_url('js/bootstrap.min.js');?>"></script>
    <script src="<?php echo media_url('js/login.plugins.js');?>"></script>
    <script type="text/javascript" src="<?php echo media_url('js/jquery.matchHeight.min.js');?>"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
    <script src="<?php echo media_url('js/login.app.js');?>"></script>
</body>
</html>