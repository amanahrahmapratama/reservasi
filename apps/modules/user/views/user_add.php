<?php
if (isset($user)) {
    $id = $user['user_id'];
    $inputNameValue = $user['user_name'];
    $inputJudulValue = $user['user_full_name'];
    $inputRoleValue = $user['user_role_role_id'];
    $inputEmailValue = $user['user_email'];
    $inputPhoneValue = $user['user_phone'];
    $inputAddressValue = $user['user_address'];
} else {
    $inputNameValue = set_value('user_name');
    $inputJudulValue = set_value('user_full_name');
    $inputRoleValue = set_value('user_role_role_id');
    $inputEmailValue = set_value('user_email');
    $inputPhoneValue = set_value('user_phone');
    $inputAddressValue = set_value('user_address');
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3><?php echo $operation; ?> Pengguna</h3>

            <?php echo isset($alert) ? ' ' . $alert : null; ?>
            <?php echo validation_errors(); ?>

    <?php echo form_open_multipart(current_url()); ?>
    <div class="row">
        <div class="col-sm-9 col-md-9">
            <?php if (isset($user)): ?>
                <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>" />
            <?php endif; ?>
            <label >Username *</label>
            <input name="user_name" type="text" <?php echo (isset($user))? 'readonly' : '' ?> placeholder="Username" class="form-control" value="<?php echo $inputNameValue; ?>"><br>
            <label >Nama Lengkap *</label>
            <input type="text" name="user_full_name" placeholder="Nama Lengkap" class="form-control" value="<?php echo $inputJudulValue; ?>"><br>

            <?php if (!isset($user)): ?>
                <label >Password *</label>
                <input type="password" placeholder="Password" name="user_password" class="form-control"><br>
                <label >Konfirmasi Password *</label>
                <input type="password" placeholder="Konfirmasi Password" name="passconf" class="form-control">
                <p style="color:#9C9C9C;margin-top: 5px"><i>Password minimal 6 karakter</i></p>
            <?php endif; ?>
            <label >No. Telepon </label>
            <input type="text" name="user_phone" placeholder="No. Telepon" class="form-control" value="<?php echo $inputPhoneValue; ?>"><br>
            <label >Status Pengguna *</label>
            <select name="user_role_role_id" class="form-control">
                <?php
                if (!empty($role)) {
                    foreach ($role as $row):
                        $select = ($row['role_id'] == $inputRoleValue) ? 'selected' : NULL;
                        ?>

                        <option value="<?php echo $row['role_id']; ?>" <?php echo $select; ?>> <?php echo $row['role_name']; ?></option>

                        <?php
                    endforeach;
                }
                ?>
            </select><br>

            <label >Email *</label>
            <input type="text" name="user_email" placeholder="Email Pengguna" class="form-control" value="<?php echo $inputEmailValue; ?>">
            <p style="color:#9C9C9C;margin-top: 5px"><i>Contoh : example@yahoo.com / example@example.com</i></p>
            <label> Alamat Pengguna </label>
            <textarea name="user_address" class="form-control tinymce-init" rows="10" placeholder="Alamat pengguna"><?php echo $inputAddressValue; ?></textarea><br>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
        <div class="col-sm-9 col-md-3">
            <div class="form-group">
                <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                <a href="<?php echo site_url('admin/user'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                <?php if (isset($user)): ?>
                    <?php if ($this->session->userdata('user_id_admin') != $id) {
                        ?>
                        <a style="margin-top: 3px" href="#confirm-del" data-toggle="modal" class="btn btn-danger"><i class="ion-trash-a"></i> Hapus</a>
                    <?php } ?>
                    <?php if ($this->session->userdata('user_id_admin') == $id) {
                        ?>
                        <a href="<?php echo site_url('admin/profile/cpw') ?>" class="btn btn-primary" style="margin-top: 3px"> Ubah password</a>
                    <?php } elseif ($this->session->userdata('user_id_admin') != $id) { ?>
                        <a style="margin-top: 3px" class="btn btn-primary" href="<?php echo site_url('admin/user/rpw/' . $user['user_id']); ?>" > Reset Password</a>
                    <?php } ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>

<?php if (isset($user)): ?>
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
                <?php echo form_open('admin/user/delete/' . $user['user_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $user['user_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $user['user_name'] ?>" />
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
