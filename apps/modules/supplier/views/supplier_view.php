<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header">
                Detail Supplier
                <span class=" pull-right">
                    <a href="<?php echo site_url('admin/supplier') ?>"
                        class="btn btn-info"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a> 
                    <a href="<?php echo site_url('admin/supplier/edit/'.$supplier['supplier_id']) ?>"
                        class="btn btn-warning"><i class="fa fa-edit"></i>&nbsp; Edit</a> 
                </span>
            </h3>

            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?php echo $supplier['supplier_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo $supplier['supplier_email'] ?></td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td><?php echo $supplier['supplier_phone'] ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo $supplier['supplier_address'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal input</td>
                        <td>:</td>
                        <td><?php echo pretty_date($supplier['supplier_created_date']) ?></td>
                    </tr>
                    <tr>
                        <td>Penulis</td>
                        <td>:</td>
                        <td><?php echo $supplier['user_name']; ?></td>
                    </tr>
                </tbody>
            </table>

		</div>
		</div>
	</div>
</div>
