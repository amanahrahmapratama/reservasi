<script type="text/javascript">
    var token_name = "<?php echo $this->security->get_csrf_token_name() ?>";
    var csrf_hash = "<?php echo $this->security->get_csrf_hash() ?>";
</script>
<script src="<?php echo base_url('/media/js/modalpopup.js'); ?>"></script>
<link href="<?php echo base_url('/media/css/modalpopup.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('media/css/jasny-bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
<script src="<?php echo base_url('media/js/jasny-bootstrap.min.js'); ?>"></script>

<?php $this->load->view('admin/tinymce_init'); ?>
<?php $this->load->view('admin/datepicker'); ?>

<?php
if (isset($banner)) {
    $inputName = $banner['banner_title'];
    $inputDesc = $banner['banner_desc'];
} else {
    $inputName = set_value('banner_title');
    $inputDesc = set_value('banner_desc');
}
?>
<div class="col-sm-9 col-md-10 main">
    <?php if (!isset($banner)) echo validation_errors(); ?>
    <?php echo form_open_multipart(current_url()); ?>
    <div class="row page-header">
        <div class="col-sm-9 col-md-6">
            <h3 class="page-title"><?php echo $operation; ?> Banner</h3>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-9 col-md-9">
            <?php if (isset($banner)): ?>
                <input type="hidden" name="banner_id" value="<?php echo $banner['banner_id']; ?>" />
            <?php endif; ?>
            <label >Judul *</label>
            <input name="banner_title" placeholder="Judul" type="text" class="form-control" value="<?php echo $inputName; ?>"><br>
            <label>Deskripsi</label>
            <textarea name="banner_desc" class="tinymce-init"><?php echo $inputDesc ?></textarea>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            <div class="form-group">
                <div class="box4">
                    <label for="image">Unggah File Gambar</label>
                    <!--<input id="image" type="file" name="inputGambar">-->
                    <a name="action" id="openmm"type="submit" value="save" class="btn btn-info"><i class="icon-ok icon-white"></i> Upload</a>
                    <div style="display: none;" ><a href="" id="opentiny">Open</a></div>
                    <input type="hidden" name="inputGambarExisting">
                    <input type="hidden" name="inputGambarExistingId">

                    <?php if (isset($banner) AND !empty($banner['banner_image'])): ?>
                        <div class="thumbnail mt10">
                            <img class="previewTarget" src="<?php echo $banner['banner_image']; ?>" style="width: 280px !important" >
                        </div>
                        <input type="hidden" name="inputGambarCurrent" value="<?php echo $banner['banner_image']; ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-3">
            <div class="form-group">
                <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                <a href="<?php echo site_url('admin/banner'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                <?php if (isset($banner)): ?>
                    <a href="<?php echo site_url('admin/banner/delete/' . $banner['banner_id']); ?>" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<?php if (isset($banner)): ?>
    <!-- Delete Confirmation -->
    <div class="modal fade" id="confirm-del">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b>Konfirmasi Penghapusan</b></h4>
                </div>
                <div class="modal-body">
                    <p>Data yang dipilih akan dihapus&hellip;</p>
                </div>
                <?php echo form_open('admin/banner/delete/' . $banner['banner_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $banner['banner_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $banner['banner_title'] ?>" />
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php if ($this->session->flashdata('delete')) { ?>
        <script type="text/javascript">
            $(window).load(function() {
                $('#confirm-del').modal('show');
            });
        </script>
    <?php }
    ?>
<?php endif; ?>