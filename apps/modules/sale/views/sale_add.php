<?php
if (isset($sale)) {
    $inputDate = $sale['sale_date'];
    $inputCustomer = $sale['customer_customer_id'];
    $inputStatus = $sale['sale_status_sale_status_id'];
} else {
    $inputDate = set_value('sale_date');
    $inputCustomer = set_value('customer_id');
    $inputStatus = set_value('status_id');
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">

            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                </h3>

                <?php echo validation_errors(); ?>
                <?php echo form_open_multipart(current_url()); ?>

                <div class="row">
                    <div class="col-md-8">
                        <?php if (isset($sale)): ?>
                            <input type="hidden" name="sale_id" value="<?php echo $sale['sale_id']; ?>" />
                        <?php endif; ?>
                        <label >Tanggal Penjualan *</label>
                        <input name="sale_date" placeholder="Tanggal Penjualan" type="text" class="datepicker form-control" value="<?php echo $inputDate; ?>"><br>
                        <label >Pelanggan *</label>
                        <select name="customer_id" class="form-control">
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($customer as $row): ?>
                                <option value="<?php echo $row['customer_id'] ?>" <?php echo (isset($sale) AND $sale['customer_customer_id'] == $row['customer_id'])? 'selected' : NULL ?>><?php echo $row['customer_full_name'] . ' -'. $row['customer_email'] .'-' ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <label >Status Penjualan *</label>
                        <select name="sale_status_id" class="form-control">
                            <option value="">-- Pilih Status Penjualan --</option>
                            <?php foreach ($status as $row): ?>
                                <option value="<?php echo $row['sale_status_id'] ?>" <?php echo (isset($sale) AND $sale['sale_status_sale_status_id'] == $row['sale_status_id'])? 'selected' : NULL ?>><?php echo $row['sale_status_name'] ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                            <a href="<?php echo site_url('admin/sale'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                            <?php if (isset($sale)): ?>
                                <a href="<?php echo site_url('admin/sale/delete/' . $sale['sale_id']); ?>" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
                            <?php endif; ?>
                        </div> 
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($sale)): ?>
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
                <?php echo form_open('admin/sale/delete/' . $sale['sale_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $sale['sale_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $sale['sale_date'] ?>" />
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php if ($this->session->flashdata('delete')) { ?>
    <script type="text/javascript">
        $(window).load(function() {
            $('#confirm-del').modal('show');
        });
    </script>
    <?php }
    ?>
<?php endif; ?>