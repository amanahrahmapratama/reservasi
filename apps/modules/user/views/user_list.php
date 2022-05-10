<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3>
                <?php echo $title ?>
                <a href="<?php echo site_url('admin/user/add'); ?>" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> Tambah</a>
            </h3>

        <table class="table no-more-tables">
            <thead>
                <tr>
                    <th>USERNAME</th>
                    <th>NAMA LENGKAP</th>
                    <th>EMAIL</th>
                    <th>STATUS ADMIN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <?php
            if (!empty($user)) {
                foreach ($user as $row) {
                    ?>
                    <tbody>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('admin/user/view/' . $row['user_id']); ?>">
                                <?php echo $row['user_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo site_url('admin/user/view/' . $row['user_id']); ?>">
                                <?php echo $row['user_full_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo site_url('admin/user/view/' . $row['user_id']); ?>">
                                <?php echo $row['user_email']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo site_url('admin/user/view/' . $row['user_id']); ?>">
                                <?php echo $row['role_name']; ?>
                                </a>
                            </td>
                            <td>
                                    <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/user/view/' . $row['user_id']); ?>" >
                                        <i class="fa fa-eye"></i></a>
                                    <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/user/edit/' . $row['user_id']); ?>" >
                                        <i class="fa fa-edit"></i></a>

                                <?php if ($this->session->userdata('user_id_admin') != $row['user_id']) { ?>
                                    <a class="btn btn-primary btn-xs" href="<?php echo site_url('admin/user/rpw/' . $row['user_id']); ?>" >
                                        <span class="fa fa-refresh"></span>&nbsp; Reset Password</a>
                                <?php } else {
                                    ?>
                                    <a class = "btn btn-primary btn-xs" href = "<?php echo site_url('admin/profile/cpw/'); ?>" >
                                        <span class="fa fa-refresh"></span>&nbsp; Ubah Password</a>
                                <?php } ?>
                        </tr>
                    </tbody>
                    <?php
                }
            } else {
                ?>
                <tbody>
                    <tr id="row">
                        <td colspan="5" align="center">Data Kosong</td>
                    </tr>
                </tbody>
                <?php
            }
            ?>   
        </table>

    <div >
        <?php echo $this->pagination->create_links(); ?>
    </div>


		</div>
		</div>
	</div>
</div>
