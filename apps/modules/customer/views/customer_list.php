<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header">
                Daftar Customer
                <a href="<?php echo site_url('admin/customer/add'); ?>" class="btn btn-success pull-right">
                    <i class="fa fa-plus"></i> Tambah</button></a>
            </h3>

        <table class="table no-more-tables">
            <thead>
                <tr>
                    <th>NAMA LENGKAP</th>
                    <th>EMAIL</th>
                    <th>No. Telp</th>
                    <th>ALAMAT</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <?php
            if (!empty($customer)) {
                foreach ($customer as $row) {
                    ?>
                    <tbody>
                        <tr>
                            <td><a href="<?php echo site_url('admin/customer/view/' . $row['customer_id']); ?>">
                                <?php echo $row['customer_full_name']; ?></a>
                            </td>
                            <td><a href="<?php echo site_url('admin/customer/view/' . $row['customer_id']); ?>">
                                <?php echo $row['customer_email']; ?></a>
                            </td>
                            <td><a href="<?php echo site_url('admin/customer/view/' . $row['customer_id']); ?>">
                                <?php echo $row['customer_phone']; ?></a>
                            </td>
                            <td><a href="<?php echo site_url('admin/customer/view/' . $row['customer_id']); ?>">
                                <?php echo $row['customer_address']; ?></a>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-xs"
                                    href="<?php echo site_url('admin/customer/view/' . $row['customer_id']); ?>" >
                                    <i class="fa fa-eye"></i></a>
                                <a class="btn btn-success btn-xs"
                                    href="<?php echo site_url('admin/customer/edit/' . $row['customer_id']); ?>" >
                                    <i class="fa fa-edit"></i></a>
                            </td>
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
