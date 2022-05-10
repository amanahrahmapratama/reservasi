<div class="page-content">
	<div class="content">
		<?php if(isset($page)) $this->load->view($page);?>
	</div>
</div>

</div>

<script src="<?php echo media_url('js/pace.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/bootstrap.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jqueryblockui.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.unveil.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.scrollbar.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.animateNumbers.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/jquery.validate.min.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/select2.min.js');?>" type="text/javascript"></script>

<script src="<?php echo media_url('js/webarch.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/chat.js');?>" type="text/javascript"></script>
<script src="<?php echo media_url('js/superbox.min.js');?>" type="text/javascript"></script>
<script src="<?php echo template_media_url('js/notify.min.js');?>"></script>

<?php if ($this->session->flashdata('success')): ?>
	<script>
		$.notify('<?php echo $this->session->flashdata('success') ?>', {
			className: 'success',
			globalPosition: 'top center',
		});
	</script>
<?php endif ?>

<script>
	$(function()
	{
	  // Call SuperBox - that's it!
	  $('.superbox').SuperBox();
	});
</script>
</script>

<?php
if(isset($widgets)) 
	foreach ($widgets as $widget) {
		$this->load->view($widget);
	}
	?>

</body>
</html>