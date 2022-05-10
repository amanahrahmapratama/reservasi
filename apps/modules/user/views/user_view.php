<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header">
                Detail Pengguna

            <span class=" pull-right">
                <a href="<?php echo site_url('admin/user') ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a> 
                <a href="<?php echo site_url('admin/user/edit/' . $user['user_id']) ?>" class="btn btn-success"><i class="fa fa-edit"></i>&nbsp; Edit</a> 
            </span>
            </h3>

            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Nama Singkat</td>
                        <td>:</td>
                        <td><?php echo $user['user_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><?php echo $user['user_full_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo $user['user_email'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal daftar</td>
                        <td>:</td>
                        <td><?php echo pretty_date($user['user_created_date'], 'l, d-mY', FALSE) ?></td>
                    </tr>
                    <tr>
                        <td>Peran</td>
                        <td>:</td>
                        <td><?php echo $user['role_name']; ?></td>
                    </tr>
                </tbody>
            </table>

		</div>
		</div>
	</div>
</div>
