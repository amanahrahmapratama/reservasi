<script type="text/javascript">
    var token_name = "<?php echo $this->security->get_csrf_token_name() ?>";
    var csrf_hash = "<?php echo $this->security->get_csrf_hash() ?>";
</script>

<script src="<?php echo media_url('mediamanager/js/modalpopup.js'); ?>"></script>
<link href="<?php echo media_url('mediamanager/css/modalpopup.css'); ?>" rel="stylesheet">
<link href="<?php echo media_url('mediamanager/css/jasny-bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
<script src="<?php echo media_url('mediamanager/js/jasny-bootstrap.min.js'); ?>"></script>