<?php
if (isset($customer)) {
    $id = $customer['customer_id'];
    $inputNameValue = $customer['customer_full_name'];
    $inputEmailValue = $customer['customer_email'];
    $inputPhoneValue = $customer['customer_phone'];
    $inputAddressValue = $customer['customer_address'];
} else {
    $inputNameValue = set_value('customer_full_name');
    $inputEmailValue = set_value('customer_email');
    $inputPhoneValue = set_value('customer_phone');
    $inputAddressValue = set_value('customer_address');
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">

          <div class="grid-body no-border">
            <h3 class="page-header" ><?php echo $operation; ?> Customer</h3>
            <?php echo isset($alert) ? ' ' . $alert : null; ?>
            <?php echo validation_errors(); ?>

            <?php echo form_open_multipart(current_url()); ?>
            <div class="row">
                <div class="col-sm-9 col-md-9">
                    <?php if (isset($customer)): ?>
                        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id'] ?>" />
                    <?php endif; ?>
                    <label >Nama Lengkap *</label>
                    <input type="text" name="customer_full_name" placeholder="Nama Lengkap" class="form-control" value="<?php echo $inputNameValue; ?>"><br>

                    <?php if (!isset($customer)): ?>
                        <label >Password *</label>
                        <input type="password" placeholder="Password" name="customer_password" class="form-control"><br>
                        <label >Konfirmasi Password *</label>
                        <input type="password" placeholder="Konfirmasi Password" name="passconf" class="form-control">
                        <p style="color:#9C9C9C;margin-top: 5px"><i>Password minimal 6 karakter</i></p>
                    <?php endif; ?>
                    <label >No. Telepon *</label>
                    <input type="text" name="customer_phone" placeholder="No. Telepon" class="form-control" value="<?php echo $inputPhoneValue; ?>"><br>

                    <label >Email *</label>
                    <input type="text" name="customer_email" placeholder="Email Pengguna" class="form-control" value="<?php echo $inputEmailValue; ?>">
                    <p style="color:#9C9C9C;margin-top: 5px"><i>Contoh : example@yahoo.com / example@example.com</i></p>
                    <label> Alamat Pengguna *</label>
                    <textarea name="customer_address" class="form-control tinymce-init" rows="10" placeholder="Alamat pengguna"><?php echo $inputAddressValue; ?></textarea><br>
                    <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
                </div>
                <div class="col-sm-9 col-md-3">
                    <div class="form-group">
                        <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                        <a href="<?php echo site_url('admin/customer'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                        <?php if (isset($customer)): ?>
                            <?php if ($this->session->userdata('user_id_admin') != $id) {
                                ?>
                                <a style="margin-top: 3px" href="#confirm-del" data-toggle="modal" class="btn btn-danger"><i class="ion-trash-a"></i> Hapus</a>
                            <?php } ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>

            <?php if (isset($customer)): ?>
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
                            <?php echo form_open('admin/customer/delete/' . $customer['customer_id']); ?>
                            <div class="modal-footer">
                                <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                                <input type="hidden" name="del_id" value="<?php echo $customer['customer_id'] ?>" />
                                <input type="hidden" name="del_name" value="<?php echo $customer['customer_full_name'] ?>" />
                                <button type="submit" class="btn btn-primary">Ya</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <?php if ($this->session->flashdata('delete')) { ?>
                    <script type = "text/javascript">
                        $(window).load(function () {
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
