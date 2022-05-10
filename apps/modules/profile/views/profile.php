<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header">Profil Pengguna</h3>

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
                        <td><?php echo pretty_date($user['user_created_date'], 'l, d m Y', FALSE) ?></td>
                    </tr>
                    <tr>
                        <td>Peran</td>
                        <td>:</td>
                        <td><?php echo $user['role_name']; ?></td>
                    </tr>
                </tbody>
            </table>

            <a href="<?php echo site_url('admin/profile/edit/');?>" class="btn btn-success"><i class="ion-edit"></i> Edit</a>
            <a href="<?php echo site_url('admin/profile/cpw/');?>" class="btn btn-primary"><i class="ion-refresh"></i> Ubah Password</a>

		</div>
		</div>
	</div>
</div>
