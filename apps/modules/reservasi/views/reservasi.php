<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <a href="<?php echo site_url('admin/reservasi/add'); ?>" class="btn btn-success pull-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </h3>

                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th class="controls" align="center">NAMA RUANGAN</th>
                            <th class="controls" align="center">PEMOHON</th>
                            <th class="controls" align="center">TANGGAL</th>
                            <th class="controls" align="center">STATUS</th>
                            <th class="controls" align="center">AKSI</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($reservasi)) {
                        foreach ($reservasi as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <td ><?php echo $row['catalog_name']; ?></td>
                                    <td ><?php echo $row['customer_full_name']; ?></td>
                                    <td ><?php echo pretty_date($row['reservasi_date_start'], 'd F Y', false) . ' s.d. ' . pretty_date($row['reservasi_date_end'], 'd F Y', false) ?></td>
                                    <td ><?php echo $row['status_name']; ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/reservasi/view/' . $row['reservasi_id']); ?>" ><i class="fa fa-eye"></i></a>
                                        <?php if ($row['reservasi_status_status_id'] == STATUS_NEW || $row['reservasi_status_status_id'] == STATUS_PROCESS): ?>
                                            <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/reservasi/edit/' . $row['reservasi_id']); ?>" ><i class="fa fa-edit"></i></a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="6" align="center">Data Kosong</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    ?>   
                </table>

                <div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>