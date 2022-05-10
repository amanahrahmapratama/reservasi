<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">

            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <a href="<?php echo site_url('admin/sale/expired'); ?>" class="btn btn-danger pull-right">
                        Transaksi Expired
                    </a>
                </h3>

                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th class="controls" align="center">INVOICE</th>
                            <th class="controls" align="center">TANGGAL PENJUALAN</th>
                            <th class="controls" align="center">PELANGGAN</th>
                            <th class="controls" align="center">STATUS</th>
                            <th class="controls" align="center">AKSI</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($sale)) {
                        foreach ($sale as $row) {
                            ?>
                            <tbody>
                                <tr <?php if ($row['sale_status_sale_status_id'] == 3): ?>
                                    class="bg-info"
                                <?php endif ?>>
                                    <td ><?php echo $row['sale_inv_num']; ?></td>
                                    <td ><?php echo pretty_date($row['sale_date'], 'l, d/m/Y', FALSE); ?></td>
                                    <td ><?php echo $row['customer_full_name'] . ' (' . $row['customer_email'] .')' ; ?></td>
                                    <td ><?php echo $row['sale_status_name']; ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/sale/view/' . $row['sale_id']); ?>" ><span class="fa fa-eye"></span></a>
                                        <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/sale/edit/' . $row['sale_id']); ?>" ><span class="fa fa-edit"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="7" align="center">Data Kosong</td>
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
