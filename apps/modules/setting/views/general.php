<?php 

$appname = $setting['app_name']['setting_value'];
$address = $setting['address']['setting_value'];
$app_tagline = $setting['app_tagline']['setting_value'];
$fb = $setting['socmed_fb']['setting_value'];
$fb_id = $setting['fb_id']['setting_value'];
$instagram = $setting['socmed_instagram']['setting_value'];
$twitter = $setting['socmed_twitter']['setting_value'];
$bank_1 = $setting['bank_1']['setting_value'];
$bank_2 = $setting['bank_2']['setting_value'];
$bank_3 = $setting['bank_3']['setting_value'];
$cp_phone = $setting['cp_phone']['setting_value'];
$cp_bbm = $setting['cp_bbm']['setting_value'];
$cp_whatsapp = $setting['cp_whatsapp']['setting_value'];
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
                	<label class="col-sm-2 control-label">Nama Aplikasi</label>
                	<div class="col-sm-10">
                		<input type="text" name="app_name" value="<?php echo $appname ?>" placeholder="Nama Aplikasi" class="form-control">
                	</div>
                </div>
                <div class="form-group">
                	<label class="col-sm-2 control-label">Tagline</label>
                	<div class="col-sm-10">
                		<input type="text" name="app_tagline" value="<?php echo $app_tagline ?>" placeholder="Tagline" class="form-control">
                	</div>
                </div>
                <div class="form-group">
                	<label class="col-sm-2 control-label">Alamat</label>
                	<div class="col-sm-10">
                		<textarea name="address" placeholder="Alamat" class="form-control"><?php echo $address ?></textarea>
                	</div>
                </div>
                <div class="form-group">
                	<label class="col-sm-2 control-label">Media Sosial</label>
                	<div class="col-sm-10">
                		<input type="text" value="<?php echo $fb ?>" name="socmed_fb" placeholder="Facebook" class="form-control"><br>
                		<input type="text" value="<?php echo $twitter ?>" name="socmed_twitter" placeholder="Twitter" class="form-control"><br>
                		<input type="text" value="<?php echo $instagram ?>" name="socmed_instagram" placeholder="Instagram" class="form-control">
                	</div>
                </div>
                <hr>
                <div class="form-group">
                	<label class="col-sm-2 control-label">Rekening Bank 1</label>
                	<div class="col-sm-10">
                		<div class="row">
                			<div class="col-md-4">
                				<textarea name="bank_1" placeholder="Rekening 1" class="form-control"><?php echo $bank_1 ?></textarea>
                			</div>
                			<div class="col-md-4">
                				<textarea name="bank_2" placeholder="Rekening 1" class="form-control"><?php echo $bank_2 ?></textarea>
                			</div>
                			<div class="col-md-4">
                				<textarea name="bank_3" placeholder="Rekening 1" class="form-control"><?php echo $bank_3 ?></textarea>
                			</div>
                		</div>
                	</div>
                </div>
                <hr>
                <div class="form-group">
                	<label class="col-sm-2 control-label">Contact Person</label>
                	<div class="col-sm-10">
                		<input type="text" name="cp_phone" value="<?php echo $cp_phone ?>" placeholder="Telepon" class="form-control"><br>
                		<input type="text" name="cp_bbm" value="<?php echo $cp_bbm ?>" placeholder="Bbm" class="form-control"><br>
                		<input type="text" name="cp_whatsapp" value="<?php echo $cp_whatsapp ?>" placeholder="Whatsapp" class="form-control">
                	</div>
                </div>

                <hr>
                <div class="form-group">
                	<label class="col-sm-2 control-label">Facebook ID</label>
                	<div class="col-sm-10">
                		<input type="text" name="fb_id" value="<?php echo $fb_id ?>" class="form-control" placeholder="Facebook ID">
                	</div>
                </div>
                <button class="btn btn-success">Simpan</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>