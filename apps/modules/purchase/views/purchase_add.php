<?php $this->load->view('admin/tinymce_init'); ?>
<?php $this->load->view('admin/datepicker'); ?>

<?php
if (isset($purchase)) {
    $inputDate = $purchase['purchase_date'];
    $inputSupplier = $purchase['supplier_supplier_id'];
} else {
    $inputDate = date('Y-m-d H:i');
    $inputSupplier = set_value('supplier_id');
}
?>
<div class="col-sm-9 col-md-10 main">
    <?php if (!isset($purchase)) echo validation_errors(); ?>
    <?php echo form_open_multipart(current_url()); ?>
    <div class="row page-header">
        <div class="col-sm-9 col-md-6">
            <h3 class="page-title"><?php echo $operation; ?> Pembelian</h3>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-9 col-md-9">
            <?php if (isset($purchase)): ?>
                <input type="hidden" name="purchase_id" value="<?php echo $purchase['purchase_id']; ?>" />
            <?php endif; ?>
            <label >Tanggal Pembelian *</label>
            <input name="purchase_date" placeholder="Tanggal Pembelian" type="text" class="datepicker form-control" value="<?php echo $inputDate; ?>"><br>
            <label >Supplier *</label>
            <select name="supplier_id" class="form-control">
                <option value="">-- Pilih Supplier --</option>
                <?php foreach ($supplier as $row): ?>
                <option value="<?php echo $row['supplier_id'] ?>" <?php echo (isset($purchase) AND $purchase['supplier_supplier_id'] == $row['supplier_id'])? 'selected' : NULL ?>><?php echo $row['supplier_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
        <div class="col-sm-9 col-md-3">
            <div class="form-group">
                <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                <a href="<?php echo site_url('admin/purchase'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                <?php if (isset($purchase)): ?>
                    <a href="<?php echo site_url('admin/purchase/delete/' . $purchase['purchase_id']); ?>" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<?php if (isset($purchase)): ?>
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
                <?php echo form_open('admin/purchase/delete/' . $purchase['purchase_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $purchase['purchase_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $purchase['purchase_date'] ?>" />
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