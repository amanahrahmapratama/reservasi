<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <a href="<?php echo site_url('admin/posting/add'); ?>" class="btn btn-success pull-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </h3>

                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th class="controls" align="center">JUDUL</th>
                            <th class="controls" align="center">PENULIS</th>
                            <th class="controls" align="center">KATEGORI</th>
                            <th class="controls" align="center">STATUS</th>
                            <th class="controls" align="center">TANGGAL</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($posting)) {
                        foreach ($posting as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <td ><b><a style="float: left;" href="<?php echo site_url('admin/posting/edit/' . $row['posting_id']); ?>" ><?php echo $row['posting_title']; ?></a></b></td>
                                    <td ><?php echo $row['user_name']; ?></td>
                                    <td ><?php echo $row['posting_category_name']; ?></td>
                                    <td ><?php echo $row['posting_publish_status'] ? 'Terbit' : 'Draft' ; ?></td>
                                    <td ><?php echo pretty_date($row['posting_created_date'], 'l, d/m/Y', FALSE); ?></td>
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

                <div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>