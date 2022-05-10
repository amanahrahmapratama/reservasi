<?php
if (isset($brand)) {
    $inputName = $brand['brand_name'];
} else {
    $inputName = set_value('brand_name');
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header"><?php echo $title; ?></h3>

                <?php if (!isset($brand)) echo validation_errors(); ?>
                <?php echo form_open_multipart(current_url()); ?>

                <div class="row">
                    <div class="col-sm-9 col-md-9">
                        <?php if (isset($brand)): ?>
                            <input type="hidden" name="brand_id" value="<?php echo $brand['brand_id']; ?>" />
                        <?php endif; ?>
                        <label >Nama *</label>
                        <input name="brand_name" placeholder="Nama" type="text" class="form-control" value="<?php echo $inputName; ?>"><br>
                        <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
                    </div>
                    <div class="col-sm-9 col-md-3">
                        <div class="form-group">
                            <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                            <a href="<?php echo site_url('admin/brand'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                            <?php if (isset($brand)): ?>
                                <a href="#confirm-del" data-toggle="modal" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($brand)): ?>
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
                <?php echo form_open('admin/brand/delete/' . $brand['brand_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $brand['brand_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $brand['brand_name'] ?>" />
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