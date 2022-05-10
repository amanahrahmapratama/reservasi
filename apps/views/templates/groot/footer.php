
<?php
$CI = &get_instance();
$CI->load->model('Posting_model');
$posting = $this->Posting_model->get(array('limit' => 5, 'status_publish' => 1));
?>

<footer class="footer-area section-gap">
	<div class="container">
		<div class="row">
			<div class="col-lg-6  col-md-6">
				<div class="single-footer-widget">
					<h6>Ulasan Terbaru</h6>
					<ul class="footer-nav">
						<?php foreach ($posting as $key): ?>
							<li><a href="<?php echo posting_url($key) ?>"><?php echo $key['posting_title'] ?></a></li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-3">
				<div class="single-footer-widget">
					<h6>Alamat Museum Kebangkitan Nasional</h6>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.644291760763!2d106.83590531425783!3d-6.178346662259366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f434569482cb%3A0xf63185f968d128ab!2sMuseum+Kebangkitan+Nasional!5e0!3m2!1sen!2sid!4v1541391039011" width="auto" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
			<div class="col-lg-3 col-md-3">
				<div class="single-footer-widget newsletter text-white" style="margin-left:50px;">
					<h6>&nbsp;</h6>
					<p>Jl. Abdul Rachman Saleh No.26, RT.4/RW.5, <br>
						Senen, Kota Jakarta Pusat, <br>
					Daerah Khusus Ibukota Jakarta 10410</p>
					<i class="fa fa-phone"></i> (021) 3847975
				</div>
			</div>
		</div>

		<div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">
			<p class="col-lg-8 col-sm-12 footer-text m-0">
				Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
			</p>
			<div class="footer-social d-flex align-items-center">
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-instagram"></i></a>
			</div>
		</div>
	</div>
</footer>

<script type="text/javascript" src="<?php echo media_url('frontend/js/vendor/jquery.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
crossorigin="anonymous"></script>
<script src="<?php echo media_url('frontend/js/vendor/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="<?php echo media_url('frontend/js/easing.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/hoverIntent.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/superfish.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/jquery.ajaxchimp.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/owl.carousel.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/isotope.pkgd.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/owl.carousel.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/jquery.nice-select.min.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/jquery.lightbox.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/main.js') ?>"></script>
<script src="<?php echo media_url('frontend/js/imgLiquid.js') ?>"></script>

<link href="<?php echo base_url('media/fullcalendar/fullcalendar.min.css') ?>" rel="stylesheet" />
<link href="<?php echo base_url('media/fullcalendar/fullcalendar.print.min.css') ?>" rel="stylesheet" media="print" />
<script src="<?php echo base_url('media/fullcalendar/moment.min.js') ?>"></script>
<script src="<?php echo base_url('media/fullcalendar/fullcalendar.min.js') ?>"></script>
<script src="<?php echo base_url('media/fullcalendar/locale-all.js') ?>"></script>

<script type="text/javascript">
	$(function() {
		$(".imgLiquidFill").imgLiquid({
			fill: true,
			horizontalAlign: "center",
			verticalAlign: "top"
		});
		$(".imgLiquidNoFill").imgLiquid({
			fill: false,
			horizontalAlign: "center",
			verticalAlign: "50%"
		});
	});
</script>
<script type="text/javascript">

	$(".dates").datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
</script>

</body>
</html>
