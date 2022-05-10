<?php 

$from = $setting['email_from']['setting_value'];
$from_name = $setting['email_from_name']['setting_value'];
$protocol = $setting['email_protocol']['setting_value'];
$smtp_host = $setting['email_smtp_host']['setting_value'];
$smpt_pass = $setting['email_smtp_pass']['setting_value'];
$smtp_port = $setting['email_smtp_port']['setting_value'];
$timeout = $setting['email_smtp_timeout']['setting_value'];
$user = $setting['email_smtp_user']['setting_value'];

?>

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
				</h3>

				<?php echo form_open(current_url(), array('class' => 'form-horizontal')); ?>
				<div class="form-group">
					<label class="col-sm-5 control-label">Email</label>
					<div class="col-sm-7">
						<input type="text" name="email_from" value="<?php echo $from ?>" placeholder="Email" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Nama</label>
					<div class="col-sm-7">
						<input type="text" name="email_from_name" value="<?php echo $from_name ?>" placeholder="Nama" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Protocol</label>
					<div class="col-sm-7">
						<input type="text" name="email_protocol" value="<?php echo $protocol ?>" placeholder="Protocol" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">SMTP Host</label>
					<div class="col-sm-7">
						<input type="text" name="email_smtp_host" value="<?php echo $smtp_host ?>" placeholder="SMTP Host" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">SMTP User</label>
					<div class="col-sm-7">
						<input type="text" name="email_smtp_user" value="<?php echo $user ?>" placeholder="SMTP User" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">SMTP Password</label>
					<div class="col-sm-7">
						<input type="password" name="email_smtp_pass" value="<?php echo $smpt_pass ?>" placeholder="SMTP Password" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">SMTP Port</label>
					<div class="col-sm-7">
						<input type="text" name="email_smtp_port" value="<?php echo $smtp_port ?>" placeholder="SMTP Port" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Timeout</label>
					<div class="col-sm-7">
						<input type="text" name="email_smtp_timeout" value="<?php echo $timeout ?>" placeholder="SMTP Timeout" class="form-control">
					</div>
				</div>

				<button class="btn btn-success">Simpan</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>