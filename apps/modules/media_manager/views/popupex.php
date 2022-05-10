<html>
    <head>
    	<!-- <link href="<?php echo media_url('media/css/bootstrap.css');?>" rel="stylesheet">  -->
        <link href="<?php echo media_url('mediamanager/css/modalpopup.css');?>" rel="stylesheet">
        
        <script src="<?php echo media_url('js/jquery-1.11.3.min.js');?>"></script>
        <!--  
        <script src="<?php echo media_url('js/bootstrap.min.js');?>"></script>
         -->
        <script src="<?php echo media_url('mediamanager/js/modalpopup.js');?>"></script>
        <script type="text/javascript">
        	var BASEURL = '<?php echo base_url() ?>';
        	$(document).ready(function(){
        		medpop.init()
            });
        </script>
        
    </head>
    <body>
    	<div class="row-fluid">
    		<div class="span12 combox">
	    		<div id="poplist">
	        		<div id="loading"><div class="spinner"></div></div>
	            </div>
	            <div style="clear: both;"></div>
	            <div class="pagebox"></div>
            </div>
        </div>
   	</div>
    </body>
</html>
