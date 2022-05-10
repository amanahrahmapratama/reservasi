<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header">
                Daftar Supplier
                <a href="<?php echo site_url('admin/supplier/add'); ?>" class="btn btn-plus btn-success pull-right">
                <i class="fa fa-plus"></i> Tambah</a>
            </h3>

        <table class="table no-more-tables">
            <thead>
                <tr>
                    <th class="controls" align="center">NAMA</th>
                    <th class="controls" align="center">EMAIL</th>
                    <th class="controls" align="center">NO. TELEPON</th>
                    <th class="controls" align="center">TANGGAL</th>
                    <th class="controls" align="center">AKSI</th>
                </tr>
            </thead>
            <?php
            if (!empty($supplier)) {
                foreach ($supplier as $row) {
                    ?>
                    <tbody>
                        <tr>
                            <td><a href="<?php echo site_url('admin/supplier/view/' . $row['supplier_id']); ?>">
                                <?php echo $row['supplier_name']; ?></a>
                            </td>
                            <td><a href="<?php echo site_url('admin/supplier/view/' . $row['supplier_id']); ?>">
                                <?php echo $row['supplier_email']; ?>
                            </td>
                            <td><a href="<?php echo site_url('admin/supplier/view/' . $row['supplier_id']); ?>">
                                <?php echo $row['supplier_phone']; ?>
                            </td>
                            <td><a href="<?php echo site_url('admin/supplier/view/' . $row['supplier_id']); ?>">
                                <?php echo pretty_date($row['supplier_created_date'], 'l, d/m/Y', FALSE); ?>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-xs"
                                    href="<?php echo site_url('admin/supplier/view/' . $row['supplier_id']); ?>" >
                                    <i class="fa fa-eye"></i></a>
                                <a class="btn btn-success btn-xs"
                                    href="<?php echo site_url('admin/supplier/edit/' . $row['supplier_id']); ?>" >
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
