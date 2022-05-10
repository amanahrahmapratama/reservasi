<?php
if (isset($supplier)) {
    $inputName = $supplier['supplier_name'];
    $inputEmail = $supplier['supplier_email'];
    $inputPhone = $supplier['supplier_phone'];
    $inputAddress = $supplier['supplier_address'];
} else {
    $inputName = set_value('supplier_name');
    $inputEmail = set_value('supplier_email');
    $inputPhone = set_value('supplier_phone');
    $inputAddress = set_value('supplier_address');
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header"><?php echo $operation; ?> Supplier</h3>

    <?php if (!isset($supplier)) echo validation_errors(); ?>
    <?php echo form_open_multipart(current_url()); ?>

    <div class="row">
        <div class="col-sm-9 col-md-9">
            <?php if (isset($supplier)): ?>
                <input type="hidden" name="supplier_id" value="<?php echo $supplier['supplier_id']; ?>" />
            <?php endif; ?>
            <label >Nama *</label>
            <input name="supplier_name" placeholder="Nama" type="text" class="form-control" value="<?php echo $inputName; ?>"><br>
            <label >Email *</label>
            <input name="supplier_email" placeholder="Email" type="text" class="form-control" value="<?php echo $inputEmail; ?>"><br>
            <label >No. Telepon *</label>
            <input name="supplier_phone" placeholder="No. Telepon" type="text" class="form-control" value="<?php echo $inputPhone; ?>"><br>
            <label >Alamat </label>
            <textarea name="supplier_address" class="tinymce-init" rows="15"><?php echo $inputAddress; ?></textarea>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
        <div class="col-sm-9 col-md-3">
            <div class="form-group">
                <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                <a href="<?php echo site_url('admin/supplier'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                <?php if (isset($supplier)): ?>
                    <a href="#confirm-del" data-toggle="modal" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>

<?php if (isset($supplier)): ?>
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
                <?php echo form_open('admin/supplier/delete/' . $supplier['supplier_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $supplier['supplier_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $supplier['supplier_name'] ?>" />
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

		</div>
		</div>
	</div>
</div>
