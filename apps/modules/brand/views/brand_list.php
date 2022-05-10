<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <a href="<?php echo site_url('admin/brand/add'); ?>" class="btn btn-success pull-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </h3>

                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th class="controls" align="center">NAMA</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($brand)) {
                        foreach ($brand as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <td ><a href="<?php echo site_url('admin/brand/edit/' . $row['brand_id']); ?>" ><?php echo $row['brand_name']; ?></a></td>
                                </tr>
                            </tbody>
                            <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="1" align="center">Data Kosong</td>
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