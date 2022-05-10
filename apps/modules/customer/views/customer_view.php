<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">

          <div class="grid-body no-border">
            <h3 class="page-header">
                Detail Customer
                <span class=" pull-right">
                    <a href="<?php echo site_url('admin/customer') ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a> 
                    <a href="<?php echo site_url('admin/customer/edit/' . $customer['customer_id']) ?>" class="btn btn-success"><i class="fa fa-edit"></i>&nbsp; Edit</a> 
                    <a href="<?php echo site_url('admin/customer/rpw/' . $customer['customer_id']) ?>" class="btn btn-success"><i class="fa fa-key"></i>&nbsp; Reset Password</a> 
                    </span>
                </h3>

                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>:</td>
                            <td><?php echo $customer['customer_full_name'] ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $customer['customer_email'] ?></td>
                        </tr>
                        <tr>
                            <td>No. Telp</td>
                            <td>:</td>
                            <td><?php echo $customer['customer_phone'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?php echo $customer['customer_address'] ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
