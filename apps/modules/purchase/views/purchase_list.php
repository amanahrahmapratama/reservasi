<div class="col-sm-9 col-md-10 main">
    <h3 class="page-header">
        Daftar Pembelian
        <a href="<?php echo site_url('admin/purchase/add'); ?>" ><button type="button" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Tambah</button></a>
    </h3>

    <!-- Indicates a successful or positive action -->

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="controls" align="center">TANGGAL PEMBELIAN</th>
                    <th class="controls" align="center">SUPPLIER</th>
                    <th class="controls" align="center">AKSI</th>
                </tr>
            </thead>
            <?php
            if (!empty($purchase)) {
                foreach ($purchase as $row) {
                    ?>
                    <tbody>
                        <tr>
                            <td ><?php echo pretty_date($row['purchase_date'], 'l, d/m/Y', FALSE); ?></td>
                            <td ><?php echo $row['supplier_name']; ?></td>
                            <td>
                                <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/purchase/view/' . $row['purchase_id']); ?>" ><span class="ion-eye"></span></a>
                                <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/purchase/edit/' . $row['purchase_id']); ?>" ><span class="ion-edit"></span></a>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                }
            } else {
                ?>
                <tbody>
                    <tr id="row">
                        <td colspan="3" align="center">Data Kosong</td>
                    </tr>
                </tbody>
                <?php
            }
            ?>   
        </table>
    </div>
    <div >
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>