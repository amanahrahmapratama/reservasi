<?php 
if (isset($page)) {
    $inputJudulValue = $pages['page_name'];
    $inputTextValue = $pages['page_content'];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <?php echo validation_errors() ?>
            <?php echo form_open(current_url()); ?>
            <div class="grid-body no-border">
                <h3 class="page-header"><?php echo $title; ?></h3>

                <div class="row">
                    <div class="col-md-8">
                        <label >Judul Halaman *</label>
                        <input name="page_name" placeholder="Judul Halaman" type="text" class="form-control" value="<?php echo $inputJudulValue; ?>"><br>
                        <label >Konten *</label>
                        <textarea name="page_content" class="tinymce-init" style="width: 100%" rows="15"><?php echo $inputTextValue; ?></textarea><br />
                    </div>
                    <div class="col-md-4">
                        <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                        <a href="<?php echo site_url('admin/page'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>

                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<script type="text/javascript">
    var token_name = "<?php echo $this->security->get_csrf_token_name() ?>";
    var csrf_hash = "<?php echo $this->security->get_csrf_hash() ?>";
</script>


